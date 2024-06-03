<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKampus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'content'
    ];

    public function lowongans()
    {
        return $this->hasMany(Lowongan::class);
    }

    public function programKampus()
    {
        return $this->hasMany(ProgramKampus::class);
    }

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class);
    }
}
