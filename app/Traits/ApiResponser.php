<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponser
{
    protected function successResponse(
        mixed $data,
        string $message = "Operation done with success!",
        int $code = Response::HTTP_OK
    ): JsonResponse{
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse(
        mixed $data,
        string $message = "An error occurred while operating!",
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse{
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
