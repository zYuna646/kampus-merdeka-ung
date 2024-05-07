<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kegiatan',
        'program_kampus_id',
        'studi_id',
        'sop_pob', // Mengubah 'sop/pob' menjadi 'sop_pob' karena nama kolom tidak boleh mengandung karakter '/'
    ];


}
