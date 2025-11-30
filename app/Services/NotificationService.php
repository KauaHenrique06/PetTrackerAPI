<?php 

namespace App\Services;

use App\Models\Notification;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function index(){
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)->get();

        return $notifications;
    }

    public function CreateLostNotification(Pet $pet, User $user)
    {
        $owner_address = $pet->user->address;

        $message = "The pet named " . $pet->name . " was reported lost by his owner: " . $pet->user->name ." in the vicinity of the following address: " . $owner_address->district . ", " . $owner_address->city . ", " . $owner_address->state . ". If you see a " . $pet->specie->name . " that looks like him, please contact the owner. If you manage to rescue him, please call the owner at:" . $pet->user->phones->first()?->number;

        return Notification::create([
            'type' => 'lost',
            'message' => $message,
            'image_path' => $pet->image == null ? null : "storage/" . $pet->image,
            'user_id' => $user->id,
            'pet_id' => $pet->id
        ]);
    }

    public function CreateFoundedNotification(Pet $pet, User $user)
    {
        $message = "The pet named " . $pet->name . " was reported founded by his owner: " . $pet->user->name;

        return Notification::create([
            'type' => 'founded',
            'message' => $message,
            'image_path' => $pet->image == null ? null : "storage/" . $pet->image,
            'user_id' => $user->id,
            'pet_id' => $pet->id
        ]);
    }

    public function CreateDeseasedNotification(Pet $pet, User $user)
    {
        $message = "The pet named " . $pet->name . " who was missing, has unfortunately been declared deceased";

        return Notification::create([
            'type' => 'deceased',
            'message' => $message,
            'image_path' => $pet->image == null ? null : "storage/" . $pet->image,
            'user_id' => $user->id,
            'pet_id' => $pet->id
        ]);
    }

    public function CreateScannedNotification(Pet $pet, $lat, $lon)
    {
        $address = $this->getAddressFromCoordinates($lat, $lon);

        if(Auth::check()){
            $user = Auth::user();

            $message = "your pet named" . $pet->name . "  had the collar scanned at the following address: " . $address . ". The user who scanned is: " . $user->name . ", you can contact him at: " . $pet->user->phones->first()?->number;
        }else{
            $message = "your pet named" . $pet->name . "  had the collar scanned at the following address: " . $address;
        }

        return Notification::create([
            'type' => 'scanned',
            'message' => $message,
            'image_path' => $pet->image == null ? null : "storage/" . $pet->image,
            'user_id' => $pet->user->id,
            'pet_id' => $pet->id
        ]);
    }

    private function getAddressFromCoordinates($lat, $lon)
    {
        // 1. Monta a URL (format=jsonv2 é mais fácil de processar que o v1)
        $url = sprintf(
            "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=%s&lon=%s&addressdetails=1",
            $lat,
            $lon
        );

        // 2. Configura o cURL (A maneira profissional de fazer requisições)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // IMPORTANTE: O Nominatim EXIGE um User-Agent válido. 
        // Coloque o nome do seu app ou seu email.
        curl_setopt($ch, CURLOPT_USERAGENT, "SeuNomeApp_PetTracker/1.0 (seu_email@dominio.com)");
        
        // Timeout para não travar seu script se a API demorar
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); 

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // 3. Validações básicas
        if ($httpCode !== 200 || !$response) {
            return "Endereço não localizado (Erro na API)";
        }

        $data = json_decode($response, true);
        $address = $data['address'] ?? [];

        // 4. Lógica de Fallback (Onde a mágica acontece)
        // O Nominatim retorna chaves diferentes dependendo do tipo de via/local.
        // Usamos o operador null coalescing (??) para tentar a prioridade.

        // Rua: Pode ser road, pedestrian, highway, etc.
        $rua = $address['road'] 
            ?? $address['pedestrian'] 
            ?? $address['street'] 
            ?? $address['path'] 
            ?? null;

        // Bairro: Pode ser suburb, neighbourhood, residential, etc.
        $bairro = $address['suburb'] 
            ?? $address['neighbourhood'] 
            ?? $address['residential'] 
            ?? $address['quarter'] 
            ?? null;

        // Cidade: Pode ser city, town, village, municipality.
        $cidade = $address['city'] 
            ?? $address['town'] 
            ?? $address['village'] 
            ?? $address['municipality'] 
            ?? null;

        // Estado: Geralmente é state ou region.
        $estado = $address['state'] 
            ?? $address['region'] 
            ?? null;

        // 5. Montagem da String Final (com limpeza de vírgulas extras)
        $partes = [];
        if ($rua) $partes[] = $rua;
        if ($bairro) $partes[] = "- " . $bairro; // Adiciona um separador visual
        if ($cidade) $partes[] = $cidade;
        if ($estado) $partes[] = "/ " . $estado;

        // Se não achou nada (ex: coordenadas no meio do oceano)
        if (empty($partes)) {
            return "Endereço sem detalhes disponíveis";
        }

        // Exemplo de saída: "Rua das Flores - Centro, São Paulo / São Paulo"
        return implode(", ", $partes);
    }
}