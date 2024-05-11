<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_transaction_id',
        'weekly_log_id',
        'date',
        'msg',
        'status',
        'dokumentasi'
    ];

    public function programTransaction()
    {
        return $this->belongsTo(ProgramTransaction::class);
    }

    public function week()
    {
        return $this->belongsTo(WeeklyLog::class);
    }

    public function activity()
    {
        return $this->belongsToMany(ActivityLog::class);
    }


}
