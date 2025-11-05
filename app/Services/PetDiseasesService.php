<?php 

namespace App\Services;

use App\Models\Pet;
use App\Models\PetDiseases;
use Illuminate\Support\Facades\Auth;

class PetDiseasesService
{
    public function store(Array $data){
        $pet = Pet::findOrFail($data['pet_id']);

        $logged_user = Auth::user();
        
        if($pet->user_id != $logged_user->id){
            throw new \Exception("You cannot insert informations about someone pet!");
        }

        $newDisease = PetDiseases::create($data);

        return $newDisease;
    }

    public function indexChronicDiseases(Pet $pet){
        return PetDiseases::where('pet_id', $pet->id)
            ->where('is_chronic', true)->get();
    }

    public function indexNormalDiseases(Pet $pet){
        return PetDiseases::where('pet_id', $pet->id)
            ->where('is_chronic', false)->get();
    }

}