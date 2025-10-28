<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserService{

    public function update(User $user, array $userData, ?UploadedFile $imageFile) {

        // Verifica se foi enviado um arquivo de imagem
        if($imageFile && $imageFile->isValid()) {

            // Remove a imagem antiga, se existir
            if($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Armazena a nova imagem e obtém o caminho
            $imagePath = $imageFile->store('user_image', 'public');
            $userData['image'] = $imagePath;
        }

        // Atualiza os dados do usuário
        $user->update($userData);

        $user->refresh();

        return $user;
    }
}