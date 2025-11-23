<?php

namespace App\Services;

use App\Models\Pet;
use App\Models\PetMedicalProcedure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PetMedProcedureService {

    public function store(Array $procedureData, int $petId) {
        
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedHttpException("You must be logged for register a medical procedure!");
        } 

        $pet = Pet::findOrFail($petId);

        $petMed = PetMedicalProcedure::create([
            'type' => $procedureData['type'],
            'description' => $procedureData['description'],
            'start_date' => $procedureData['start_date'],
            'end_date' => $procedureData['end_date'],
            'pet_id' => $pet->id            
        ]); 

        return $petMed;

    }

    public function update(Array $procedureData, int $petMedId) {
        
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedHttpException("You must be logged for update a medical procedure!");
        } 

        $petMed = PetMedicalProcedure::findOrFail($petMedId);

        $petMed->update($procedureData);

        return $petMed;

    }

    public function destroy($petMedId) {
        
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedHttpException("You must be logged for delete a medical procedure!");
        } 

        $petMed = PetMedicalProcedure::findOrFail($petMedId);

        $petMed->delete($petMedId);

        return $petMed;

    }

    public function index(Pet $pet) {

        $petMed = PetMedicalProcedure::where('pet_id', $pet->id)->get();

        return $petMed;

    }

    public function show($petMedId) {
        
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedHttpException("You must be logged for delete a medical procedure!");
        } 

        $petMed = PetMedicalProcedure::findOrFail($petMedId);

        return $petMed;

    }

}