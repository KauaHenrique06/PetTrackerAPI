<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Collar extends Model
{

    public $incrementing = false;   
    protected $keyType = 'string';

    protected $fillable = [
        'pet_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    
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
