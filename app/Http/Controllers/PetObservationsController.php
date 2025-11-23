<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetObservationRequest;
use App\Http\Requests\UpdatePetObservationRequest;
use App\Models\Pet;
use App\Services\PetObservationService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PetObservationsController extends Controller
{

    use ApiResponser;

    protected PetObservationService $petObservation;

    public function __construct(PetObservationService $petObservation) {
        $this->petObservation = $petObservation;
    }

    public function store(PetObservationRequest $request, int $petId) {

        DB::beginTransaction();

        try {

            $petObs = $this->petObservation->store($request->validated(), $petId);

            DB::commit();

            return $this->successResponse($petObs, 'Observations registered with success!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollback();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function update(UpdatePetObservationRequest $request, int $petObsId) {

        DB::beginTransaction();

        try {

            $petObs = $this->petObservation->update($request->validated(), $petObsId);

            DB::commit();

            return $this->successResponse($petObs, 'Observations updated with success!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollback();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function destroy(int $petObsId) {

        DB::beginTransaction();

        try {

            $petObs = $this->petObservation->destroy($petObsId);

            DB::commit();

            return $this->successResponse($petObs, 'Observations deleted with success!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollback();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function index(Pet $pet) {

        DB::beginTransaction();

        try {

            $petObs = $this->petObservation->index($pet);

            return $this->successResponse($petObs, 'All pets finded!', Response::HTTP_OK);

        } catch(\Exception $e) {

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function show(int $petObsId) {

        DB::beginTransaction();

        try {

            $petObs = $this->petObservation->show($petObsId);

            return $this->successResponse($petObs, "Observation with id = $petObsId finded!", Response::HTTP_OK);

        } catch(\Exception $e) {

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

}
