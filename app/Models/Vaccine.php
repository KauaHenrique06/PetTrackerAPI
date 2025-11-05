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

    /**
     * Um usuário pode ter várias vacinas
     * 
     * @return HasMany
     */
    public function user() {

        return $this->hasMany(User::class);

    }

    protected $fillable = [
        'disease_name',
        'target_species',
        'doses',
        'duration'
    ];
}
