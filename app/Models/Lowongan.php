<?php

namespace App\Models;

use App\Traits\GeneratesUniqueCodes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;
    use GeneratesUniqueCodes;

    protected $fillable = [
        'code',
        'program_id',
        'tahun_akademik',
        'semester',
        'pendaftaran_mulai',
        'pendaftaran_selesai',
        'tanggal_mulai',
        'tanggal_selesai', // Mengubah 'sop/pob' menjadi 'sop_pob' karena nama kolom tidak boleh mengandung karakter '/'
        'isLogBook'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = $model->generateUniqueCode(static::class);
        });
    }

    public function program()
    {
        return $this->belongsTo(ProgramKampus::class);
    }

    public function programTransaction()
    {
        return $this->hasMany(ProgramTransaction::class);
    }
}
