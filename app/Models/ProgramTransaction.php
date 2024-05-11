<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'lowongan_id',
        'lokasi_id',
        'mahasiswa_id',
        'rancangan',
        'status_rancangan_pamong',
        'status_rancangan_dpl',
        'msg_dpl',
        'msg_pamong',
        'status_mahasiswa'
    ];

    public function dailyLog()
    {
        return $this->hasMany(DailyLog::class);
    }

    public function weeklyLog()
    {
        return $this->hasMany(WeeklyLog::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dpls()
    {
        return $this->belongsToMany(DPL::class);
    }

    public function pamong()
    {
        return $this->belongsToMany(MitraTransaction::class);
    }
}
