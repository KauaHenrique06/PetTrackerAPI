<?php

namespace App\Services;

use App\Models\Phone;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function index(User $user){
        $user_phone_list = Phone::where('user_id', $user->id)->get();

        return $user_phone_list;
    }

    public function update(Array $data){
        $phone_list = $data['phones'];

        $logged_user = Auth::user();

        foreach($phone_list as $phone_item){
            $phone = $logged_user->phones()
                ->where('id', $phone_item['id'])
                ->update(['number' => $phone_item['number']]);
        }

        return $logged_user->phones();
    }
}