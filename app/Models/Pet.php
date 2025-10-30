<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pet extends Model
{
    
    /**
     * Um usuário contém um pet
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo {

        return $this->belongsTo(User::class);

    }

    /**
     * Uma vacina pertence a varios pets
     * 
     * @return BelongsToMany
     */
    public function vaccines(): BelongsToMany {

        return $this->belongsToMany(Vaccine::class);

    }

    /**
     * Um pet pode ter várias obervações
     * 
     * @return HasMany
     */
    public function petObservations(): HasMany{

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
        'sex',
        'specie', 
        'breed',
        'size',
        'weight',
        'is_neutred',
        'birthday',
        'image',
        'color',
        'status', 
        'user_id'
    ];

}
