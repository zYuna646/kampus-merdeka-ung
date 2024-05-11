<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPL extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'lowongan_id',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(ProgramTransaction::class);
    }
}
