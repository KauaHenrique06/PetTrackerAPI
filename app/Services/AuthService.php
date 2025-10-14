<?php

namespace App\Services;
use App\Models\User;
use App\Utils\Formatter;

class AuthService {

    public function register(Array $userData) {

        //Adicionei limpeza do CPF ao salvar
        $user = User::create([

            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'cpf' => Formatter::cleanCpf($userData['cpf']),
            'birthday' => $userData['birthday']

        ]);

        return $user;

    }

}