<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetMedicationsRequest;
use App\Services\PetMedicationService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;

class PetMedicationsController extends Controller
{
    use ApiResponser;

    public function __construct(public PetMedicationService $petMedicationService){}


    public function store(StorePetMedicationsRequest $request){
        try{
            $newMedication = $this->petMedicationService->store($request->validated());

            return $this->successResponse($newMedication, "Treatment registered with success!", Response::HTTP_CREATED);
        }catch(\Exception $e){
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
