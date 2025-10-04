<?php

namespace App\Services;
use App\Models\User;

class AuthService {

    public function register(Array $userData) {

        $user = User::create([

            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'cpf' => $userData['cpf'],
            'birthday' => $userData['birthday']

        ]);

        return $user;

    }

}