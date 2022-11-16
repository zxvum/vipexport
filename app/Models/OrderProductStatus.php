<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hex',
        'order'
    ];

    public function orders()
    {
        return $this->hasMany(OrderProduct::class, 'status_id', 'id');
    }
}
