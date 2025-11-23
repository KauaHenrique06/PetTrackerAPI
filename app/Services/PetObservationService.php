<?php

namespace App\Services;

use App\Models\Pet;
use App\Models\PetObservation;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PetObservationService {

    public function store(Array $obsData, int $petId) {
    
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedHttpException("You must be logged for register an observation!");
        } 

        $pet = Pet::findOrFail($petId);

        $petObs = PetObservation::create([
            'description' => $obsData['description'],
            'pet_id' => $pet->id            
        ]); 

        return $petObs;

    }

    public function update(Array $obsData, int $petObsId) {
        
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedHttpException("You must be logged for register an observation!");
        } 

        $petObs = PetObservation::findOrFail($petObsId);

        $petObs->update($obsData);

        return $petObs;

    }

    public function destroy(int $petObsId) {
        
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedHttpException("You must be logged for register an observation!");
        } 

        $petObs = PetObservation::findOrFail($petObsId);

        return $petObs->delete();

    }

    public function index(Pet $pet) { 

        return $pet->petObservations;

    }

    public function show(int $petObsId) {
    
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedHttpException("You must be logged for view this observation!");
        } 

        $petObs = PetObservation::findOrFail($petObsId);

        return $petObs;

    }

}