<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    protected AuthService $authService;

    //para injetar a classe dentro das funções, vai ser executado antes das funções
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index(RegisterUserRequest $request) {

        DB::transaction();

        //realiza a tentativa do comando abaixo, caso dê erro irá rodar o catch 
        try{

            //DB::commit() executa o comando para salvar dentro do banco 
            $user = $this->authService->register($request->validated());
            DB::commit();

            return ResponseHelper::success(false, 'usuário cadastrado com sucesso', null, 200);

        }catch(\Exception $e){

            //DB::rollback() evita que salve erros dentro do banco
            DB::rollBack();

            //joga o erro na tela
            return ResponseHelper::error(true, $e->getMessage(), null, 400);

        }
    }
}
