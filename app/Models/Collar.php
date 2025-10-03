<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collar extends Model
{
    
    /**
     * Uma coleira pertence a um pet
     * 
     * @return BelongsTo 
     */
    public function pet() {

        return $this->belongsTo(Pet::class);

    }

    /**
     * Um colar pode possuir varios históricos
     * 
     * @return HasMany
     */
    public function locationHistory() {

        return $this->hasMany(LocationHistory::class);

    }

}
