<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pengajuan";
    protected $dates = ['deleted_at'];
    protected $fillable = [];

    public function pendapatPerAspek()
    {
        return $this->hasMany('\App\Models\PendapatPerAspek', 'id_pengajuan');
    }

    public function dagulir()
    {
        return $this->belongsTo(PengajuanDagulir::class, 'dagulir_id', 'id');
    }

    public function plafon() {
        return $this->belongsTo(PlafonUsulan::class,'id_pengajuan','id');
    }
}
