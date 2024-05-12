<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nidn',
        'name',
        'studi_id',
        'user_id',
    ];

    /**
     * Get the studi that the dosen belongs to.
     */
    public function studi()
    {
        return $this->belongsTo(Studi::class);
    }

    /**
     * Get the user that owns the dosen.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dpl()
    {
        return $this->hasMany(DPL::class);
    }
}
