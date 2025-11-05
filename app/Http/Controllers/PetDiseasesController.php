<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetDiseaseRequest;
use App\Http\Requests\UpdatePetDiseaseRequest;
use App\Models\Pet;
use App\Models\PetDiseases;
use App\Services\PetDiseasesService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PetDiseasesController extends Controller
{
    use ApiResponser;

    public function __construct(public PetDiseasesService $petDiseasesService){}

    public function store(StorePetDiseaseRequest $request){
        try{
            $newDisease = $this->petDiseasesService->store($request->validated());

            return $this->successResponse($newDisease, "Disease registeres with success!");
        }catch(\Exception $e){
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function indexChronicDiseases(Pet $pet){
        $petDiseases = $this->petDiseasesService->indexChronicDiseases($pet);

        return $this->successResponse($petDiseases, "Pet diseases indexed with sucesses!", Response::HTTP_OK);
    }

    public function indexNormalDiseases(Pet $pet){
        $petDiseases = $this->petDiseasesService->indexNormalDiseases($pet);

        return $this->successResponse($petDiseases, "Pet diseases indexed with sucesses!", Response::HTTP_OK);
    }

    public function updatePetDisease(PetDiseases $petDiseases, UpdatePetDiseaseRequest $request){
        DB::beginTransaction();
        try{
            $updatedDisease = $this->petDiseasesService->updatePetDisease($petDiseases, $request->validated());

            DB::commit();
            return $this->successResponse($updatedDisease, "Disease updated with success", Response::HTTP_OK);
        }catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
