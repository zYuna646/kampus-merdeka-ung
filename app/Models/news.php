<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'cover',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryNews::class, 'category_id');
    }
}
