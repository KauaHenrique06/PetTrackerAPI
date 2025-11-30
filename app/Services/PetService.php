<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PetService {

    public function __construct(protected NotificationService $notificationService){}

    public function store(User $user, Array $petData, ?UploadedFile $imageFile) {

        return DB::transaction(function () use ($user, $petData, $imageFile) { 

            $imagePath = null;

            if($imageFile && $imageFile->isValid()) {
                $imagePath = $imageFile->store('image', 'public');
            }

            $pet = $user->pet()->create([
                'name' => $petData['name'],
                'sex' => $petData['sex'],
                'specie_id' => $petData['specie_id'],
                'breed' => $petData['breed'],
                'size' => $petData['size'],
                'weight' => $petData['weight'],
                'is_neutred' => $petData['is_neutred'],
                'birthday' => $petData['birthday'],
                'image' => $imagePath,
                'color' => $petData['color'],
                'status' => $petData['status'],
                'user_id' => $user->id
            ]);

            return $pet;

        });
       
    }

    public function update(Array $petData, int $petId, ?UploadedFile $imageFile = null) {

    $logged_user = Auth::user();
    $pet = Pet::findOrFail($petId);

    // Verifica permissão
    if($pet->user_id != $logged_user->id){
        throw new AccessDeniedHttpException("You don't have permission to update this pet data!");
    }

    // Lógica de Atualização de Imagem
    if ($imageFile && $imageFile->isValid()) {
        $petData['image'] = $imageFile->store('image', 'public');
    }

    // Atualiza os dados (agora incluindo o novo path da imagem, se houver)
    $pet->fill($petData);

    // Lógica de Notificações
    if ($pet->isDirty('status')) {
        
        $newStatus = $pet->status;
        $oldStatus = $pet->getOriginal('status');

        if ($newStatus === 'lost') {
            $this->sendLostNotification($pet);
        }

        if ($newStatus === 'safe') {
            $this->sendFoundedNotification($pet);
        }

        if ($oldStatus === 'lost' && $newStatus === 'deceased') {
            $this->sendDeseasedNotification($pet);
        }
    }

    $pet->save();

    return $pet;
}

    public function destroy($petId) {

        $logged_user = Auth::user();

        $pet = Pet::findOrFail($petId);

        if($pet->user_id != $logged_user->id) {
            throw new AccessDeniedException("You don't have permission to delete this pet data!");
        }

        return $pet->delete();

    }

    public function index() {

        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedException("You don't have permission to view this pet data!");
        }

        $pet = Pet::where('user_id', $logged_user->id)->get();

        return $pet->load('collar');

    }

    public function show($petId) {

        $pet = Pet::findOrFail($petId);

        return $pet->load(['collar', 'user.phones', 'user.address']);

    }

        
    private function sendLostNotification(Pet $pet){
        $owner_address = $pet->user->address;

        $near_address = Address::nearTo($owner_address->latitude, $owner_address->longitude, 15)
            ->where('user_id', '!=', $owner_address->user_id)
            ->with('user')
            ->get();
        
        foreach($near_address as $address){
            $user = $address->user;

            $this->notificationService->CreateLostNotification($pet, $user);
        }
    }

    private function sendFoundedNotification(Pet $pet){
        $owner_address = $pet->user->address;

        $near_address = Address::nearTo($owner_address->latitude, $owner_address->longitude, 15)
            ->where('user_id', '!=', $owner_address->user_id)
            ->with('user')
            ->get();
        
        foreach($near_address as $address){
            $user = $address->user;

            $this->notificationService->CreateFoundedNotification($pet, $user);
        }
    }

    private function sendDeseasedNotification(Pet $pet){
        $owner_address = $pet->user->address;

        $near_address = Address::nearTo($owner_address->latitude, $owner_address->longitude, 15)
            ->where('user_id', '!=', $owner_address->user_id)
            ->with('user')
            ->get();
        
        foreach($near_address as $address){
            $user = $address->user;

            $this->notificationService->CreateDeseasedNotification($pet, $user);
        }
    }
}