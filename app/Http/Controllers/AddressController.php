<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\User;
use App\Services\AddressService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    use ApiResponser;

    protected AddressService $addressService;

    public function __construct(AddressService $addressService) {
        $this->addressService = $addressService;
    }

    public function store(AddressRequest $request) {

        $user = Auth::user();

        DB::beginTransaction();

        try {

            $address = $this->addressService->store($user, $request->validated());

            DB::commit();

            return $this->successResponse($address, 'Address registered successfully', Response::HTTP_OK);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }

    }

}
