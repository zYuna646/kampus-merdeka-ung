<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'tahun_akademik',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai', // Mengubah 'sop/pob' menjadi 'sop_pob' karena nama kolom tidak boleh mengandung karakter '/'
    ];

    public function program()
    {
        return $this->belongsTo(ProgramKampus::class);
    }

    public function programTransaction()
    {
        return $this->hasMany(ProgramTransaction::class);
    }
}
