<?php

namespace App\Services;

use App\Models\Vaccine;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PetVaccineService{
    
    public function store(array $data) {
        // Lógica para armazenar a relação pet-vacina
        $logged_user = Auth::user();

        // Verifica se o pet pertence ao usuário logado
        $pet = Pet::findOrFail($data['pet_id']);
        if($pet->user_id != $logged_user->id){
            throw new AccessDeniedHttpException("You don't have permission to add a vaccine to this pet!");
        }

        $pivotData = [
            'application_date' => $data['application_date'],
            'next_dose_date' => $data['next_dose_date'] ?? null
        ];

        $pet->vaccines()->attach($data['vaccine_id'], $pivotData);

        $pet->load('vaccines');

        return $pet;
    }
}