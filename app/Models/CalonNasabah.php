<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonNasabah extends Model
{
    use HasFactory;
    protected $table = 'calon_nasabah';

    protected $fillable = [
        'nama',
        'alamat_rumah',
        'alamat_usaha',
        'no_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'status',
        'sektor_kredit',
        'jenis_usaha',
        'jumlah_kredit',
        'tujuan_kredit',
        'jaminan_kredit',
        'hubungan_bank',
        'verifikasi_umum',
        'id_user',
        'id_kabupaten',
        'id_kecamatan',
        'id_desa',
        'id_pengajuan',
        'tenor_yang_diminta',
        'no_telp',
    ];

    public function users()
    {
        return $this->belongsTo('\App\Models\Users', 'id');
    }
    public function pengajuan()
    {
        return $this->belongsTo('\App\Models\PengajuanModel', 'id');
    }
}
