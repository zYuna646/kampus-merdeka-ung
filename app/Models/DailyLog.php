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
        'desc',
        'date',
        'msg',
        'status'
    ];

    public function programTransaction()
    {
        return $this->belongsTo(ProgramTransaction::class);
    }

    public function week()
    {
        return $this->belongsTo(WeeklyLog::class);
    }


}
