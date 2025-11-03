<?php

namespace App\Services;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PetService {

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

    public function update(Array $petData, int $petId) {

        $logged_user = Auth::user();

        // Procura o pet pelo ID
        $pet = Pet::findOrFail($petId);

        // Verifica a permisão do usuario para alterar esse pet
        if($pet->user_id != $logged_user->id){
            throw new AccessDeniedHttpException("You don't have permission to update this pet data!");
        }

        // Vai mudar somente os dados que forem passados na requisição
        $pet->fill($petData);

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

        return $pet;

    }

    public function show($petId) {
        
        $logged_user = Auth::user();

        if($logged_user == null) {
            throw new AccessDeniedException("You don't have permission to view this pet data!");
        } 

        $pet = Pet::where('user_id', $logged_user->id)->findOrFail($petId);

        return $pet;

    }

}