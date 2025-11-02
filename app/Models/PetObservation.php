<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetObservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'user_id'
    ];
    
    /**
     * A observação pertence a um pet
     * 
     * @return BelongsTo
     */
    public function pet() {

        return $this->belongsTo(Pet::class);

    }

}
