<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'lowongan_id',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class);
    }
}
