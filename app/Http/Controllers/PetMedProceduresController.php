<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetMedProceduresRequest;
use App\Http\Requests\UpdatePetMedProceduresRequest;
use App\Services\PetMedProcedureService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PetMedProceduresController extends Controller
{
    
    use ApiResponser;

    protected PetMedProcedureService $petMedProcedure;

    public function __construct(PetMedProcedureService $petMedProcedure) {
        $this->petMedProcedure = $petMedProcedure;
    }

    public function store(StorePetMedProceduresRequest $request, int $petId) {

        DB::beginTransaction();

        try {

            $petMed = $this->petMedProcedure->store($request->validated(), $petId);

            DB::commit();

            return $this->successResponse($petMed, 'Procedure medications registered with success!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function update(UpdatePetMedProceduresRequest $request, int $petMedId) {
    
        DB::beginTransaction();

        try {

            $petMed = $this->petMedProcedure->update($request->validated(), $petMedId);

            DB::commit();

            return $this->successResponse($petMed, 'Procedure medications updated with success!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function destroy($petMedId) {
        
        DB::beginTransaction();

        try {

            $petMed = $this->petMedProcedure->destroy($petMedId);

            DB::commit();

            return $this->successResponse($petMed, 'Procedure medications excluded with succes!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function index() {
        
        DB::beginTransaction();

        try {

            $petMed = $this->petMedProcedure->index();

            DB::commit();

            return $this->successResponse($petMed, 'All procedures medications!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function show($petMedId) {
    
        DB::beginTransaction();

        try {

            $petMed = $this->petMedProcedure->show($petMedId);

            DB::commit();

            return $this->successResponse($petMed, 'Procedure medication!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

}
