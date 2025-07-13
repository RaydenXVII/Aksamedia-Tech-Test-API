<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'id',
        'name',
        'username',
        'password',
        'phone',
        'email'
    ];

    protected $hidden = [
        'password'
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
