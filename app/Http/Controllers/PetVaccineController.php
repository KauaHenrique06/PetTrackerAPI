<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetVaccineRequest;
use App\Models\Pet;
use App\Services\PetVaccineService;
use App\Traits\ApiResponser;
use Carbon\Carbon;
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

    public function index(int $petId){
        $pet = Pet::findOrFail($petId);

        $data = DB::table("pet_vaccine")
            ->join('vaccines', "pet_vaccine.vaccine_id", "=", "vaccines.id")
            ->select(
                'pet_vaccine.id',
                'pet_vaccine.pet_id',
                'pet_vaccine.application_date',
                'vaccines.disease_name',
                'vaccines.duration'
            )
            ->where('pet_vaccine.pet_id', $petId)
            ->get();
        
        $data->transform(function ($item) {
            $item->expiration_date = Carbon::parse($item->application_date)
                ->addMonths($item->duration)
                ->format('Y-m-d'); // Formata para apenas data (ano-mês-dia)
                
            return $item;
        });
    
        return $this->successResponse($data, "Vaccines Retrived with success");
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