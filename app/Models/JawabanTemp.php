<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTemp extends Model
{
    use HasFactory;

    protected $table = 'temporary_jawaban_text';

    protected $fillable = [
        'id_temporary_calon_nasabah',
        'id_jawaban',
        'opsi_text',
        'skor_penyelia',
        'skor',
        'type',
    ];
}
