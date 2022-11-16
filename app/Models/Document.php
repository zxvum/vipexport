<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'template_path',
        'example_path',
        'is_active',
        'status_id',
        'order'
    ];

    public function status(){
        return $this->belongsTo(UserDocumentStatus::class, 'status_id', 'id');
    }
}
