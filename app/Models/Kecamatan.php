<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatan';

    public function kabupaten()
    {
        return $this->belongsTo('\App\Models\Kabupaten', 'id_kabupaten');
    }

    public function desa()
    {
        return $this->hasMany('\App\Models\Desa', 'id_kecamatan');
    }
}
