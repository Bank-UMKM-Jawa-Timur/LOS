<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeModel extends Model
{
    use HasFactory;
    protected $table = 'mst_tipe';

    public function merk()
    {
        return $this->belongsTo('\App\Models\MerkModel', 'id_merk');
    }
}
