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
    ];

    /**
     * Get the studi that the mahasiswa belongs to.
     */
    public function studi()
    {
        return $this->belongsTo(Studi::class);
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
