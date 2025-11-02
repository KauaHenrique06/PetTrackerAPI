<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetMedications extends Model
{
    protected $fillable = [
        'name',
        'type',
        'dosage_form',
        'dosing_interval',
        'interval_unit',
        'start_date',
        'end_date',
        'is_active',
        'description',
        'due_date',
        'pet_id'
    ];

    public function pet() {

        return $this->belongsTo(Pet::class);

    }
}
