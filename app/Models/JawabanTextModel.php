<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTextModel extends Model
{
    use HasFactory;
    protected $table = "jawaban_text";

    protected $fillable = [
        'id_pengajuan', 'id_jawaban', 'opsi_text', 'skor_penyelia', 'skor_pbp', 'skor',
    ];
}
