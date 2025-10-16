<?php

namespace App\Services;

use App\Models\Phone;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PhoneService {

    public function store(User $user, Array $phoneData) {

        return DB::transaction(function () use ($user, $phoneData) { 

            //Chamo a função phone() que faz a relação entre tabelas
            $phone = $user->phones()->create([
                'number' => $phoneData['number'],
                'user_id' => $user->id
            ]);

            //Verifica se o campo has_phone da tabela não esta definida como true
            if($user->has_phone == false) {
                $user->update(['has_phone' => true]);
            }

            return $phone;

        });
    }

}