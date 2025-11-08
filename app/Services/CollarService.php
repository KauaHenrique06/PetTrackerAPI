<?php 

namespace App\Services;

use App\Models\Collar;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class CollarService
{
    public function store(){
        return Collar::create();
    }

    public function associatePetToCollar(Collar $collar, Pet $pet){
        $loggedUser = Auth::user();

        if($pet->user_id != $loggedUser->id){
            throw new \Exception('You cannot associate a collar to someone pet');
        }
        
        if($pet->collar_id != null || $collar->pet_id != null){
            throw new \Exception('Collar or Pet already have an association!');
        }

        $collar->pet_id = $pet->id;
        $pet->collar_id = $collar->id;

        $collar->save();
        $pet->save();

        return $collar->with('pet')->get();
    }

    public function desassociatePetToCollar(Collar $collar, Pet $pet){
        $loggedUser = Auth::user();

        if($pet->user_id != $loggedUser->id){
            throw new \Exception("You cannot disassociate someone pet collar!");
        }

        if($pet->collar_id == null || $collar->pet_id == null || $pet->collar_id != $collar->id){
            throw new \Exception("This collar or colllar not have with association with each other");
        }

        $pet->collar_id = null;
        $collar->pet_id = null;

        $pet->save();
        $collar->save();
    }

    public function findPetByCollarId(Collar $collar){
        if($collar->pet_id == null){
            throw new \Exception("This collar doesnt have an pet associated");
        }

        return $collar->pet->load('collar');
    }
}