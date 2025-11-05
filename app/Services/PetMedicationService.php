<?php 

namespace App\Services;

use App\Models\Pet;
use App\Models\PetMedications;
use Illuminate\Support\Facades\Auth;

class PetMedicationService
{
    public function store(Array $medicationData){
        $logged_user = Auth::user();

        $pet = Pet::findOrFail($medicationData['pet_id']);
        
        if($pet->user_id != $logged_user->id){
            throw new \Exception("You cannot insert informations about someone pet!");
        }
        
        $savedMedication = PetMedications::create($medicationData);

        return $savedMedication;
    }

    public function indexContinuousTreatments(Pet $pet, string $indexType){
        if($indexType == "active"){
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'continuous')
                ->active()
                ->get();
        }else if($indexType == "inactive"){
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'continuous')
                ->inactive()
                ->get();
        }else{
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'continuous')
                ->get();
        }
    }
    
    public function indexPeriodicTreatments(Pet $pet, string $indexType){
        if($indexType == "active"){
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'periodic')
                ->active()
                ->get();
        }else if($indexType == "inactive"){
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'periodic')
                ->inactive()
                ->get();
        }else{
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'periodic')
                ->get();
        }
    }

    public function indexUniqueDoseTreatments(Pet $pet, string $indexType){
        if($indexType == "active"){
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'unique')
                ->active()
                ->get();
        }else if($indexType == "inactive"){
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'unique')
                ->inactive()
                ->get();
        }else{
            return PetMedications::where('pet_id', $pet->id)
                ->where('treatment_type', 'unique')
                ->get();
        }
    }

    public function removeMedication(PetMedications $petMedications){
        $petOwner = $petMedications->pet->user;
        $loggedUser = Auth::user();

        if($petOwner->id != $loggedUser->id){
            throw new \Exception('You cannot update someone pet medication!');
        }
        
        return $petMedications->delete();
    }

    public function updatePetMedication(PetMedications $petMedications, Array $newData){
        $petOwner = $petMedications->pet->user;
        $loggedUser = Auth::user();

        if($petOwner->id != $loggedUser->id){
            throw new \Exception('You cannot delete someone pet medication!');
        }

        $petMedications->update($newData);

        return $petMedications;
    } 
}