<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index(RegisterUserRequest $request) {

        DB::transaction();

        try{

            $user = $this->authService->register($request->validated());
            DB::commit();

            return response()->json(['registro' => true, 'user' => $user]);

        }catch(\Exception $e){

            DB::rollBack();
            throw $e;
            
        }
    }
}
