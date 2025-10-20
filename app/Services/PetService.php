<?php

namespace App\Services;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PetService {

    public function store(User $user, Array $petData) {

        return DB::transaction(function () use ($user, $petData) { 

            $pet = $user->pet()->create([
                'name' => $petData['name'],
                'birthday' => $petData['birthday'],
                'specie' => $petData['specie'],
                'color' => $petData['color'],
                'user_id' => $user->id
            ]);

            return $pet;

        });
       

    }

}