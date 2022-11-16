<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'country_id',
        'region',
        'city',
        'postal_code',
        'street',
        'phone_number',
        'email'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function address_name(){
        return $this->country->name.' '.$this->region.' '.$this->city.' '.$this->street;
    }
}
