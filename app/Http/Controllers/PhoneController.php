<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Models\User;
use App\Services\PhoneService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PhoneController extends Controller
{

    use ApiResponser;

    protected PhoneService $phoneService;

    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public function store(PhoneRequest $request) {

        $user = Auth::user();

        DB::beginTransaction();

        try {

            $phone = $this->phoneService->store($user, $request->validated());

            DB::commit();

            return $this->successResponse($phone, 'Phone registered successfully!', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollback();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

    public function index(){
        $user = Auth::user();

        return $this->successResponse($this->phoneService->index($user), "Phone list reached!", Response::HTTP_OK);
    }

    public function update(UpdatePhoneRequest $request){
        DB::beginTransaction();
        try{
            $updated_user_phone_list = $this->phoneService->update($request->validated());
            DB::commit();
            return $this->successResponse($updated_user_phone_list, "Phones updated with success!", Response::HTTP_OK);
        }catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }        
    }
}