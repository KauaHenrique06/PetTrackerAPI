<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasApiTokens, HasFactory, Notifiable;

    /**
     * Um usuário vai ter somente um endereço
     * 
     * @return HasOne
     */
    public function address() {

        return $this->hasOne(Address::class);

    }

    /**
     * Um usuário pode ter vários telefones
     * 
     * @return HasMany
     */
    public function phone() {

        return $this->hasMany(Phone::class);

    }

    /**
     * Um usuário pode ter vários pets
     * 
     * @return HasMany
     */
    public function pet() {

        return $this->hasMany(Pet::class);

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
