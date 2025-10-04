<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index(RegisterUserRequest $request) {

        $user = $this->authService->register($request->validated());
        
        return response()->json(['registro' => true, 'user' => $user]);

    }
}
