<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
        'price', 
        'total',
        'quantity',
        'orderId',
        'productId'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId');
    }
}
