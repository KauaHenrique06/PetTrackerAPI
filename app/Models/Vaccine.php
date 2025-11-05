<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{

    /**
     * Uma vacina pode ser aplicada em vários pets
     * 
     * @return BelongsToMany
     */
    public function pets() {

        return $this->belongsToMany(Pet::class, 'pet_vaccine')->withPivot('application_date', 'next_dose_date')->withTimestamps();

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
