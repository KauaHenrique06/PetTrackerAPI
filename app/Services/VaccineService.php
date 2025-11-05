<?php

namespace App\Services;

use App\Models\Vaccine;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VaccineService {

    public function store(User $user, Array $vaccineData) {

        return DB::transaction(function () use ($user, $vaccineData) { 

            $vaccine = $user->vaccines()->create([
                'disease_name' => $vaccineData['disease_name'],
                'target_species' => $vaccineData['target_species'],
                'doses' => $vaccineData['doses'],
                'duration' => $vaccineData['duration'],
            ]);

            return $vaccine;

        });
    }

    public function update(Array $vaccineData, int $vaccineId) {

        $logged_user = Auth::user();

        // Procura a vacina pelo ID
        $vaccine = Vaccine::findOrFail($vaccineId);

        // Verifica a permisão do usuario para alterar essa vacina
        if($vaccine->user_id != $logged_user->id){
            throw new AccessDeniedHttpException("You don't have permission to update this vaccine data!");
        }

        // Vai mudar somente os dados que forem passados na requisição
        $vaccine->fill($vaccineData);
        $vaccine->save();

        return $vaccine;
    }

    public function destroy(int $vaccineId) {

        $logged_user = Auth::user();

        // Procura a vacina pelo ID
        $vaccine = Vaccine::findOrFail($vaccineId);

        // Verifica a permisão do usuario para deletar essa vacina
        if($vaccine->user_id != $logged_user->id){
            throw new AccessDeniedHttpException("You don't have permission to delete this vaccine data!");
        }

        // Deleta a vacina
        $vaccine->delete();

        return true;
    }

    public function show(int $vaccineId) {

        $vaccine = Vaccine::findOrFail($vaccineId);

        return $vaccine;
    }

    public function index() {

        $vaccines = Vaccine::all();

        return $vaccines;
    }
}
