<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'name',
        'studi_id',
        'angkatan',
        'user_id',
        'no_hp',
        'village_id',
        'alamat',
        'penyakit',
    ];

    /**
     * Get the studi that the mahasiswa belongs to.
     */
    public function studi()
    {
        return $this->belongsTo(Studi::class);
    }

    public function desa()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }
    /**
     * Get the user that owns the mahasiswa.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programTransaction()
    {
        return $this->hasMany(ProgramTransaction::class);
    }


}
