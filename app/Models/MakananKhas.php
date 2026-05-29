<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakananKhas extends Model
{
    protected $table = 'makanan_khas';

    protected $fillable = [
        'province_id',
        'province_name',
        'nama_makanan',
        'deskripsi',
        'foto_path',
    ];
}
