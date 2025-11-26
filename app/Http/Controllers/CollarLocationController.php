<?php

namespace App\Http\Controllers;

use App\Services\LocationHistoryService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CollarLocationController extends Controller
{
    use ApiResponser;

    public function __construct(public LocationHistoryService $location_history_service){}

    public function store(Request $request, string $collar_id){
        try{
            $location = $this->location_history_service->store($request->all(), $collar_id);

            return $this->successResponse($location, "Location registered with success");
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function index($pet_id){
        return $this->successResponse($this->location_history_service->index($pet_id), "History finded");
    }
}
