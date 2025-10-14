<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

    // Helper central para criar a resposta de erro no seu formato padrão.
    $jsonErrorResponse = function (
        string $message,
        int $code,
        mixed $data = null // O payload de dados/erros
    ) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    };


    // 422 - Erros de Validação
    $exceptions->render(function (ValidationException $e, Request $request) use ($jsonErrorResponse) {
        if ($request->expectsJson()) {
            return $jsonErrorResponse(
                'Os dados fornecidos são inválidos.',
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $e->errors() // O 'data' aqui contém a lista de erros por campo
            );
        }
    });

    // 401 - Falha de Autenticação
    $exceptions->render(function (AuthenticationException $e, Request $request) use ($jsonErrorResponse) {
        if ($request->expectsJson()) {
            return $jsonErrorResponse(
                'Não autenticado. É necessário um token de acesso válido.',
                Response::HTTP_UNAUTHORIZED
            );
        }
    });

    // 403 - Falha de Autorização (Usuário autenticado, mas sem permissão)
    $exceptions->render(function (AuthorizationException $e, Request $request) use ($jsonErrorResponse) {
        if ($request->expectsJson()) {
            return $jsonErrorResponse(
                $e->getMessage() ?: 'Esta ação não é autorizada.',
                Response::HTTP_FORBIDDEN
            );
        }
    });

    // 404 - Rota ou Recurso (Model) não encontrado
    $exceptions->render(function (NotFoundHttpException|ModelNotFoundException $e, Request $request) use ($jsonErrorResponse) {
        if ($request->expectsJson()) {
            return $jsonErrorResponse(
                'O recurso solicitado não foi encontrado.',
                Response::HTTP_NOT_FOUND
            );
        }
    });

    // 405 - Método HTTP não permitido na rota
    $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) use ($jsonErrorResponse) {
        if ($request->expectsJson()) {
            return $jsonErrorResponse(
                'O método HTTP não é permitido para esta rota.',
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        }
    });

    // 500 - Handler Genérico (Fallback para qualquer outra exceção)
    $exceptions->render(function (Throwable $e, Request $request) use ($jsonErrorResponse) {
        if ($request->expectsJson()) {
            // Em produção, nunca exponha detalhes do erro.
            $message = app()->isProduction()
                ? 'Ocorreu um erro interno no servidor.'
                : $e->getMessage();

            // Em desenvolvimento, é útil ter mais detalhes no payload 'data'.
            $data = app()->isProduction()
                ? null
                : [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ];

            $code = method_exists($e, 'getStatusCode')
                ? $e->getCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            // Garante que o código seja um erro de cliente/servidor válido
            if (!is_numeric($code) || $code < 400 || $code > 599) {
                $code = 500;
            }

            return $jsonErrorResponse($message, $code, $data);
        }
    });
})->create();
