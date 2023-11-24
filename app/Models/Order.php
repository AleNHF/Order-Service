<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'total', 
        'qtyOrdered',
        'deliveryDate',
        'status',
        'userId',   
        'supplierId'
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplierId');
    }

    public function details() 
    {
        return $this->hasMany(OrderDetail::class,'orderId');
    }
}
