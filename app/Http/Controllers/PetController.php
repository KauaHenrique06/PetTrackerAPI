<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Services\PetService;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PetController extends Controller
{

    use ApiResponser;

    protected PetService $petService;

    public function __construct(PetService $petService) {
        $this->petService = $petService;
    }

    public function store(CreatePetRequest $request) {

        $user = Auth::user();

        DB::beginTransaction();

        try {

            $pet = $this->petService->store($user, $request->validated());

            DB::commit();

            return $this->successResponse($pet, 'Pet registered succesfully!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function update(UpdatePetRequest $request, int $petId) {

        DB::beginTransaction();

        try {

            $pet = $this->petService->update($request->validated(), $petId);

            DB::commit();

            return $this->successResponse($pet, 'Data updated succesfully!', Response::HTTP_OK);

        } catch (ModelNotFoundException $e){

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_NOT_FOUND);

        } catch(AccessDeniedHttpException $e) {

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_FORBIDDEN);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

}
