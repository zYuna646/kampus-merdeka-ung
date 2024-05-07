<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
    ];

    /**
     * Get the jurusans for the fakultas.
     */
    public function jurusans()
    {
        return $this->hasMany(Jurusan::class);
    }
}
