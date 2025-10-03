<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetObservation extends Model
{
    
    /**
     * A observação pertence a um pet
     * 
     * @return BelongsTo
     */
    public function pet() {

        return $this->belongsTo(Pet::class);

    }

}
