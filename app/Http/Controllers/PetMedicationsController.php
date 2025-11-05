<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetMedicationsRequest;
use App\Http\Requests\UpdatePetMedicationsRequest;
use App\Http\Requests\UpdatePetObservationRequest;
use App\Models\Pet;
use App\Models\PetMedications;
use App\Services\PetMedicationService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PetMedicationsController extends Controller
{
    use ApiResponser;

    public function __construct(public PetMedicationService $petMedicationService){}


    public function store(StorePetMedicationsRequest $request){
        DB::beginTransaction();
        try{
            $newMedication = $this->petMedicationService->store($request->validated());

            DB::commit();
            return $this->successResponse($newMedication, "Treatment registered with success!", Response::HTTP_CREATED);
        }catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function indexContinuousTreatments(Pet $pet, Request $request){
        $indexType = $request->input('index_type', 'all');

        $treatments = $this->petMedicationService->indexContinuousTreatments($pet, $indexType);

        return $this->successResponse($treatments, "Continuous treatments indexed with success!");
    }

    public function indexPeriodicTreatments(Pet $pet, Request $request){
        $indexType = $request->input('index_type', 'all');

        $treatments = $this->petMedicationService->indexPeriodicTreatments($pet, $indexType);

        return $this->successResponse($treatments, "Continuous treatments indexed with success!");
    }

    public function indexUniqueDoseTreatments(Pet $pet, Request $request){
        $indexType = $request->input('index_type', 'all');

        $treatments = $this->petMedicationService->indexUniqueDoseTreatments($pet, $indexType);

        return $this->successResponse($treatments, "Continuous treatments indexed with success!");
    }

    public function updatePetMedications(PetMedications $petMedications, UpdatePetMedicationsRequest $request){
        DB::beginTransaction();
        try{
            $updatedMedication = $this->petMedicationService->updatePetMedication($petMedications, $request->validated());
            DB::commit();

            return $this->successResponse($updatedMedication, "Medication Updated with success");
        }catch(\Exception $e){
            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function removePetMedications(PetMedications $petMedications){
        DB::beginTransaction();
        try{
            $this->petMedicationService->removeMedication($petMedications);
            DB::commit();

            return $this->successResponse(null, "Medication Removed with success!");
        }catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
