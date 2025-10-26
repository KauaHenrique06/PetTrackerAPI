<?php

namespace App\Services;
use App\Models\User;
use App\Utils\Formatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AuthService {

    public function register(Array $userData, ?UploadedFile $imageFile) {

        $imagePath = null;

        if($imageFile && $imageFile->isValid()) {
            $imagePath = $imageFile->store('user_image', 'public');
        }

        //Adicionei limpeza do CPF ao salvar
        $user = User::create([

            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'cpf' => Formatter::cleanCpf($userData['cpf']),
            'birthday' => $userData['birthday'],
            'image' => $imagePath

        ]);

        return $user;

    }

    public function login(Array $userData) {

        //Busca na tabela do banco um dado exatamento ao o que foi fornecido no request
        $user = User::where('email', $userData['email'])->first();

        /**
         * Verifica se o email existe, caso exista verifica a senha
         * passo primeiro o texto puro da senha e depois o hash da senha armazenada
         */
        if (!$user || !Hash::check($userData['password'], $user->password)) {
            return null; 
        }

        $token = $user->createToken('access-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];

    }
    
    public function logout(Request $request) {
        //
        Auth::user()->tokens()->delete();
    }

}