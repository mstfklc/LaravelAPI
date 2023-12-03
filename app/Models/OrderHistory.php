<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'order_histories';

    protected $fillable = [
        'device_id',
        'product_id',
        'receipt_token',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
