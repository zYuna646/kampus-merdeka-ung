<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'program_id',
        'kecamatan_id',
        'kabupaten_id',
        'kelurahan_id',
        'provinsi_id',
        'lokasi'
    ];



    public function program()
    {
        return $this->belongsTo(ProgramKampus::class);
    }

    public function programTransaction()
    {
        return $this->hasMany(ProgramTransaction::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(District::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Regency::class);
    }

    public function Kelurahan()
    {
        return $this->belongsTo(Village::class);
    }

    public function guru()
    {
        return $this->hasMany(Guru::class);
    }

}
