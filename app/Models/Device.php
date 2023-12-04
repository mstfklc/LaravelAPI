<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Device extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'devices';

    protected $fillable = [
        'uuid',
        'premium_status',
        'config_info',
    ];


    protected $casts = [
        'premium_status' => 'boolean',
    ];
}
