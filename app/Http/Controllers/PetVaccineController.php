<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetVaccineRequest;
use App\Models\Pet;
use App\Services\PetVaccineService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response; 
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetVaccineController extends Controller
{
    use ApiResponser;

    protected PetVaccineService $petVaccineService;

    public function __construct(PetVaccineService $petVaccineService)
    {
        $this->petVaccineService = $petVaccineService;
    }

    public function store(PetVaccineRequest $request)
    {
  
        try {
            $validatedData = $request->validated();

            $pet = $this->petVaccineService->store($validatedData);

            return $this->successResponse($pet, 'Vaccine applied to pet successfully!', Response::HTTP_CREATED);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(null, 'Pet not found.', Response::HTTP_NOT_FOUND);

        } catch (AccessDeniedHttpException $e) {
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_FORBIDDEN);

        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $petId, int $pivotId)
    {
        
        DB::beginTransaction();

        try {

            $deleted = $this->petVaccineService->destroy($petId, $pivotId);

            DB::commit();

            return $this->successResponse($deleted, "Vaccine deleted with success!", Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollback();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }
}