<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'jurusan_id',
    ];

    /**
     * Get the jurusan that owns the studi.
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Get the mahasiswa for the studi.
     */
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
