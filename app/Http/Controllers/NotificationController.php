<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponser;

    public function __construct(protected NotificationService $notificationService){}
    
    public function index(){
        try{
            $notifications = $this->notificationService->index();

            return $this->successResponse($notifications, "Notifications finded with success!");
        }catch(\Exception $e){
            return $this->errorResponse(null, $e->getMessage());
        }
    }
}
