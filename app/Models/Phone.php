<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{

    protected $fillable = [
        'number',
        'user_id',
    ];
    
    /**
     * Um telefone pertence a um usuário
     * 
     * @return BelongsTo
     */
    public function user() {

        return $this->belongsTo(User::class);

    }

}
