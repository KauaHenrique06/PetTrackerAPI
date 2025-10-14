<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use App\Traits\ApiResponser;
use App\Utils\Formatter;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    use ApiResponser;

    protected AuthService $authService;

    //para injetar a classe dentro das funções, vai ser executado antes das funções
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function store(RegisterUserRequest $request) {
        DB::beginTransaction();
        //realiza a tentativa do comando abaixo, caso dê erro irá rodar o catch 
        try{

            //DB::commit() executa o comando para salvar dentro do banco 
            $user = $this->authService->register($request->validated());
            DB::commit();
            
            //Adicionei formatação do CPF para exibicição
            $user['cpf'] = Formatter::formatCpf($user['cpf']);

            return $this->successResponse($user, 'User registered successfully!', Response::HTTP_CREATED);

        }catch(\Exception $e){

            //DB::rollback() evita que salve erros dentro do banco
            DB::rollBack();

            //joga o erro na tela
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }

    public function login(LoginUserRequest $request) {

        try {

            //Passa somente os campos de email e password que foram fornecidos para o service
            $userData = $this->authService->login($request->only('email', 'password'));

            if(!$userData) {
                return $this->errorResponse(null, 'Invalid Credentials!', Response::HTTP_UNAUTHORIZED);
            }

            //Passo o token que foi retornado do service chamando a variável que armazena toda a lógica
            return $this->successResponse($userData, 'User logged in successfully', Response::HTTP_OK);
           
        } catch(\Exception $e) {

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }
}
