<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hex',
        'order'
    ];

    public function user_documents()
    {
        return $this->hasMany(UserDocument::class, 'status_id', 'id');
    }
}
