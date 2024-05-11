<?php

namespace App\Models;

use App\Traits\GeneratesUniqueCodes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;
    use GeneratesUniqueCodes;

    protected $fillable = [
        'name',
        'program_id',
        'kecamatan_id',
        'kabupaten_id',
        'kelurahan_id',
        'provinsi_id',
        'lokasi',
        'code'
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

    public function kelurahan()
    {
        return $this->belongsTo(Village::class);
    }

    public function guru()
    {
        return $this->belongsToMany(Guru::class);
    }

}
