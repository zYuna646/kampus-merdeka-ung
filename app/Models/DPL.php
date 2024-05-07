<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPL extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'lokasi_id',
    ];

    public function lokasis()
    {
        return $this->belongsToMany(Lokasi::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
