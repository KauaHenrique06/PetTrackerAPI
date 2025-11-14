<?php

namespace App\Http\Controllers;

use App\Models\Collar;
use App\Models\Pet;
use App\Services\CollarService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CollarsController extends Controller
{
    use ApiResponser;

    public function __construct(public CollarService $collarService){}

    public function store(){
        try{
            $newCollar = $this->collarService->store();

            return $this->successResponse($newCollar, "New collar registered with success!");
        }catch(\Exception $e){
            return $this->errorResponse(null, "Error while register new collar");
        }
    }

    public function associatePetToCollar(Pet $pet, Collar $collar){
        DB::beginTransaction();
        try{
            $association = $this->collarService->associatePetToCollar($collar, $pet);
            DB::commit();

            return $this->successResponse($association, "Association done with success!", Response::HTTP_OK);
        }catch(\Exception $e){
            DB::rollBack();
            
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function removeAssociationPetCollar(Pet $pet, Collar $collar){
        DB::beginTransaction();
        try{
            $this->collarService->desassociatePetToCollar($collar, $pet);
            DB::commit();

            return $this->successResponse(null, "Association removed with success!", Response::HTTP_OK);
        }catch(\Exception $e){
            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function findPetByCollarId(Collar $collar){
        $collar = $this->collarService->findPetByCollarId($collar);

        return $collar;
    }
}
