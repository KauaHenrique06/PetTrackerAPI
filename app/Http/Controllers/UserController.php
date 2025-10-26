<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends Controller
{
    use ApiResponser;

    protected UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function me(){
        $user = Auth::user();

        return $this->successResponse($user, "Token verified!");
    }

    public function update(UpdateUserRequest $request) {

        $validatedData = $request->validated();
        $imageFile = $request->file('image');
        $user = Auth::user();

        DB::beginTransaction();

        try {

            $updatedUser = $this->userService->update($user, $validatedData, $imageFile);

            DB::commit();

            if($updatedUser->image) {
                $updatedUser->image = Storage::url($updatedUser->image);
            }

            return $this->successResponse($updatedUser, 'User updated succesfully!');

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);

        }
        
    }
}
