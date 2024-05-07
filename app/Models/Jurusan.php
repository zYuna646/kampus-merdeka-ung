<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'fakultas_id', // Menggunakan fakultas_id sebagai kunci asing
    ];

    /**
     * Get the fakultas that owns the jurusan.
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class); // Menggunakan fakultas_id sebagai kunci asing secara default
    }

    /**
     * Get the studi for the jurusan.
     */
    public function studi()
    {
        return $this->hasMany(Studi::class);
    }
}
