<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PetMedications extends Model
{
    protected $fillable = [
        'name',
        'type',
        'treatment_type',
        'dosage_form',
        'dosing_interval',
        'interval_unit',
        'start_date',
        'end_date',
        'description',
        'pet_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function pet() {

        return $this->belongsTo(Pet::class);

    }

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $now = Carbon::now();

                $isStarted = $this->start_date->isPast() || $this->start_date->isToday();

                $isNotExpired = is_null($this->end_date) || $this->end_date->isFuture() || $this->end_date->isToday();

                return $isStarted && $isNotExpired;
            }
        );
    }

    /**
     * Scope para retornar apenas os tratamentos ativos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();

        return $query->where('start_date', '<=', $now)
                     ->where(function ($q) use ($now) {
                         // Onde a data de fim é nula (contínuo)
                         $q->whereNull('end_date')
                           // OU a data de fim ainda não passou
                           ->orWhere('end_date', '>=', $now);
                     });
    }

    /**
     * Scope para retornar apenas os tratamentos inativos.
     * (Oposto do 'active')
     */
    public function scopeInactive($query)
    {
        $now = Carbon::now();

        return $query->where('start_date', '>', $now) // 1. Nem começou
                     ->orWhere('end_date', '<', $now);  // 2. Ou já terminou
    }
}
