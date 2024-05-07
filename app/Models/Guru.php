<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'name',
        'lokasi_id',
        'user_id',
    ];

    public function lokasis()
    {
        return $this->belongsToMany(Lokasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
