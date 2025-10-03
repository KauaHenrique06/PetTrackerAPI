<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationHistory extends Model
{
    /**
     * Um histórico pertence a uma coleira
     * 
     * @return BelongsTo
     */
    public function collar() {

        return $this->belongsTo(Collar::class);

    }
}
