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

    public function update(Array $petData, int $petId) {

        // Procura o pet pelo ID
        $pet = Pet::findOrFail($petId);

        // Vai mudar somente os dados que forem passados na requisição
        $pet->fill($petData);

        $pet->save();

        return $pet;

    }

}