<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    
    /**
     * Um telefone pertence a um usuário
     * 
     * @return BelongsTo
     */
    public function user() {

        return $this->belongsTo(User::class);

    }

}
