<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use App\Traits\ApiResponser;
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

            return $this->successResponse($user, 'usuário cadastrado com sucesso', 200);

        }catch(\Exception $e){

            //DB::rollback() evita que salve erros dentro do banco
            DB::rollBack();

            //joga o erro na tela
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }
}
