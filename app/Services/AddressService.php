<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AddressService {

    public function store(User $user, Array $addressData) {

        return DB::transaction(function () use ($user, $addressData) {

            /**
             * Faz uma requisição do tipo GET para a api referenciada,
             * insere o cep que foi enviado no request e faz a busca 
             */
            $response = Http::get("https://viacep.com.br/ws/{$addressData['cep']}/json/");

            /**
             * Verifica se houve algum erro na requisição e
             * quando o cep inserido não for encontrado retornatá o 'erro'
             */
            if($response->failed() || isset($response['erro'])) {
                throw new \Exception('Invalid CEP');
            }

            //Converte a requisição em um array para facilitar a manipulação e acesso aos dados  
            $cepData = $response->json();

            //Caso não retorne nenhuma rua ou os demais campos com '?? null' ele armazena como null no banco
            $address = $user->address()->create([
                'user_id' => $user->id,
                'cep' => $addressData['cep'],
                'number' => $addressData['number'],
                'street' => $cepData['logradouro'] ?? null,
                'district' => $cepData['bairro'] ?? null,
                'city' => $cepData['localidade'] ?? null,
                'state' => $cepData['uf'] ?? null,
                'complement' => $addressData['complement'],
                'latitude' => 0.0,
                'longitude' => 0.0
            ]);

            //Verificação para mudar o status ma tabela endereço
            if($user->has_address == false) {
                    $user->update(['has_address' => true]);
                }

            return $address;

        });

    }

    public function addressByLoggedUser(User $user){
        $user_address = Address::where('user_id', $user->id)->first();

        return $user_address;
    }

    public function update(Address $address, Array $newData){
        $logged_user = Auth::user();

        if($address->user_id != $logged_user->id){
            throw new \Exception('You cannot update someone address!');
        }

        $response = Http::get("https://viacep.com.br/ws/{$newData['cep']}/json/");

        if($response->failed() || isset($response['erro'])) {
            throw new \Exception('Invalid CEP');
        }
 
        $cepData = $response->json();
        
        $dataToUpdate = [
                'cep' => $newData['cep'],
                'number' => $newData['number'],
                'street' => $cepData['logradouro'] ?? null,
                'district' => $cepData['bairro'] ?? null,
                'city' => $cepData['localidade'] ?? null,
                'state' => $cepData['uf'] ?? null,
                'complement' => $newData['complement'],
                'latitude' => 0.0,
                'longitude' => 0.0
        ];

        $address->update($dataToUpdate);

        return $address;
    }

}