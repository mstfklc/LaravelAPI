<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class OrderHistory extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'order_histories';

    protected $fillable = [
        'devices_uuid',
        'product_id',
        'receipt_token',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'devices_uuid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
