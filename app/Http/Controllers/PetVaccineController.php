<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetVaccineRequest;
use App\Models\Pet;
use App\Services\PetVaccineService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response; 
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function destroy(int $pet_id, int $pivotId)
    {
        $logged_user = Auth::user();

        $pet = Pet::findOrFail($pet_id);

        if ($pet->user_id !== $logged_user->id) {
            throw new AccessDeniedHttpException("You don't have permission to manage this pet!");
        }

        $deleted = $pet->vaccines()->newPivotStatement()
            ->where('id', $pivotId)
            ->where('pet_id', $pet->id)
            ->delete();


        if ($deleted === 0) {
            throw new ModelNotFoundException("Vaccine record not found for this pet.");
        }

        return response()->noContent();
    }
}