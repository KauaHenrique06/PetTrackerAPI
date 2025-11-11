<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetDiseases extends Model
{
    protected $fillable = [
        'name',
        'is_chronic',
        'diagnosis_date',
        'resolved_date',
        'diagnosis_status',
        'clinical_notes',
        'pet_id'
    ];

    public function pet() {

        return $this->belongsTo(Pet::class);

    }
}
