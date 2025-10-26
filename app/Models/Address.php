<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [

        'user_id',
        'cep',
        'number',
        'street',
        'district',
        'city', 
        'state',
        'complement',
        'latitude',
        'longitude'
    ];
    
    /**
     * Um usuário contém um endereço
     * 
     * @return BelongsTo
     */
    public function user() {

        return $this->belongsTo(User::class);

    }

}
