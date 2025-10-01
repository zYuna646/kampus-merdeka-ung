<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_transaction_id',
        'desc',
        'start_date',
        'end_date',
        'msg',
        'status',
        'is_lock',
        'is_verif_lock',
    ];
    
    protected $casts = [
        'is_lock' => 'boolean',
        'is_verif_lock' => 'boolean',
    ];

    public function programTransaction()
    {
        return $this->belongsTo(ProgramTransaction::class);
    }

    public function daily()
    {
        return $this->hasMany(DailyLog::class);
    }

    public function activity()
    {
        return $this->belongsToMany(ActivityLog::class);
    }
}
