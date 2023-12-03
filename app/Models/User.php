<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'email',
        'name',
        'password',
        'is_admin',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

}
