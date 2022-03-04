<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $table = 'desa';

    public function kecamatan()
    {
        return $this->belongsTo('\App\Models\Kecamatan', 'id_kecamatan');
    }
    
    public function kabupaten()
    {
        return $this->belongsTo('\App\Models\Kabupaten', 'id_kabupaten');
    }
}
