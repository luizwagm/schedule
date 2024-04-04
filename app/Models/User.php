<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    const USER_TYPE_SELLER = 'seller';
    const USER_TYPE_BUYER = 'buyer';
    const USER_TYPE_ENGINEER = 'engineer';

    const DOCUMENT_TYPE_CPF = 'cpf';
    const DOCUMENT_TYPE_CNPJ = 'cnpj';

    protected $fillable = [
        'fullname',
        'document',
        'document_type',
        'email',
        'phone',
        'company_name',
        'state_registration',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'deleted_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }
}
