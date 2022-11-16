<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductShop extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'order',
    ];

    public function products(){
        return $this->hasMany(OrderProduct::class, 'shop_id', 'id');
    }
}
