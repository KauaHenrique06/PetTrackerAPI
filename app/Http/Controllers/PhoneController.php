<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Models\User;
use App\Services\PhoneService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
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

    public function store(PhoneRequest $request, User $user) {

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

}