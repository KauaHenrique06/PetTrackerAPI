<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{

    /**
     * Um pet pode ter varias vacinas
     * 
     * @return BelongsToMany
     */
    public function pet() {

        return $this->belongsToMany(Pet::class);

    }
}
