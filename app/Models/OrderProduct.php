<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status_id',
        'shop_id',
        'link',
        'title',
        'price',
        'quantity',
    ];

    public function shop()
    {
        return $this->belongsTo(OrderProductShop::class, 'shop_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(OrderProductStatus::class, 'status_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function package(){
        return $this->hasOne(PackageHasProduct::class, 'product_id', 'id');
    }
}
