<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = [
        'name', 
        'email',
        'cellphone',
        'company'
    ];

    public function orders() 
    {
        return $this->hasMany(Order::class, 'supplierId');
    }
}
