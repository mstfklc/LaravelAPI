<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

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
