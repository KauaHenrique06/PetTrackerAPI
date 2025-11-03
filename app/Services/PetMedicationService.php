<?php 

namespace App\Services;

use App\Models\PetMedications;

class PetMedicationService
{
    public function store(Array $medicationData){
        $savedMedication = PetMedications::create($medicationData);

        return $savedMedication;
    }

}