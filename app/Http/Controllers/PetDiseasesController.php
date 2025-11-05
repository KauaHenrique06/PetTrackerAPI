<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetDiseaseRequest;
use App\Models\Pet;
use App\Services\PetDiseasesService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}
