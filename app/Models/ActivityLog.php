<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'desc',
        'rencana',
        'presentase',
        'hambatan',
        'solusi',
        'jam_mulai',
        'jam_selesai'
    ];

    public function daily()
    {
        return $this->belongsToMany(DailyLog::class);
    }

    public function weekly()
    {
        return $this->belongsToMany(WeeklyLog::class);
    }
}
