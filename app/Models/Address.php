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

    public function scopeNearTo($query, $lat, $lng, $km = 10)
    {
        $haversine = "(6371 * acos(
            cos(radians(?)) 
            * cos(radians(latitude)) 
            * cos(radians(longitude) - radians(?)) 
            + sin(radians(?)) 
            * sin(radians(latitude))
        ))";

        return $query
            ->select('*') 
            ->selectRaw("{$haversine} as distance", [$lat, $lng, $lat]) 
            ->having('distance', '<=', $km) 
            ->orderBy('distance');
    }

}
