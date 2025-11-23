<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVaccineRequest;
use App\Http\Requests\UpdateVaccineRequest;
use App\Services\VaccineService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VaccineController extends Controller
{
    use ApiResponser;

    protected VaccineService $vaccineService;

    public function __construct(VaccineService $vaccineService) {
        $this->vaccineService = $vaccineService;
    }

    public function store(CreateVaccineRequest $request) {
        $user = Auth::user();

        DB::beginTransaction();

        try {

            $vaccine = $this->vaccineService->store($user, $request->validated());

            DB::commit();

            return $this->successResponse($vaccine, 'Vaccine registered successfully!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }

    public function update(UpdateVaccineRequest $request, int $vaccineId) {

        DB::beginTransaction();

        try {

            $vaccine = $this->vaccineService->update($request->all(), $vaccineId);

            DB::commit();

            return $this->successResponse($vaccine, 'Vaccine updated successfully!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }

    public function destroy(int $vaccineId) {

        DB::beginTransaction();

        try {

            $this->vaccineService->destroy($vaccineId);

            DB::commit();

            return $this->successResponse(null, 'Vaccine deleted successfully!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }

    public function show($id) {
        
        DB::beginTransaction();

        try {

            $vaccine = $this->vaccineService->show($id);

            return $this->successResponse($vaccine, 'Vaccine informations!', Response::HTTP_OK);

        } catch(\Exception $e ) {

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    } 

    public function index() {

        DB::beginTransaction();

        try {

            $vaccine = $this->vaccineService->index();

            return $this->successResponse($vaccine, 'All vaccines found!', Response::HTTP_OK);

        } catch(\Exception $e ) {

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }
}
