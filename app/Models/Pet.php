<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    
    /**
     * Um usuário contém um pet
     * 
     * @return BelongsTo
     */
    public function user() {

        return $this->belongsTo(User::class);

    }

    /**
     * Uma vacina pertence a varios pets
     * 
     * @return BelongsToMany
     */
    public function vaccine() {

        return $this->belongsToMany(Vaccine::class);

    }

    /**
     * Um pet pode ter várias obervações
     * 
     * @return HasMany
     */
    public function petObservation() {

        return $this->hasMany(PetObservation::class);

    }

    /**
     * Um pet possui uma coleira
     * 
     * @return HasOne
     */
    public function collar() {

        return $this->hasOne(Collar::class);

    }

    protected $fillable = [
        'name',
        'specie', 
        'birthday',
        'color', 
        'user_id'
    ];

}
