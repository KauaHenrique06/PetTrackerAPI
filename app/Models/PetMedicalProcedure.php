<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetMedicalProcedure extends Model
{
    protected $fillable = [
        'type',
        'description',
        'start_date',
        'end_date',
        'pet_id',
    ];

    public function pet(): BelongsTo {
        return $this->belongsTo(Pet::class);
    }
}
