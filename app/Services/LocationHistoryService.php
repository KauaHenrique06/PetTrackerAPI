<?php 

namespace App\Services;

use App\Models\Collar;
use App\Models\LocationHistory;

class LocationHistoryService{

    public function __construct(protected NotificationService $notificationService){}
    
    public function store(Array $data, string $collar_id){
        $collar = Collar::findOrFail($collar_id);

        $location_history = LocationHistory::create([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'collar_id' => $collar->id,
            'pet_id' => $collar->pet_id
        ]);

        if($collar->pet->status == "lost"){
            $this->notificationService->CreateScannedNotification($collar->pet, $data['latitude'], $data['longitude']);
        }

        return $location_history;
    }

    public function index($pet_id){
        $location_history = LocationHistory::where('pet_id', $pet_id)->latest()->get();

        return $location_history;
    }

}