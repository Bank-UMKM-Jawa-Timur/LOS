<?php
namespace App\Services;

use App\Models\CalonNasabahTemp;
use App\Models\User;
use Illuminate\Http\Request;

class TemporaryService
{
    public static function getNasabahData(User $user): CalonNasabahTemp|null
    {
        return CalonNasabahTemp::where('id_user', $user->id)
            ->first();
    }

    public static function saveNasabah(array $data): CalonNasabahTemp
    {
        $exist = CalonNasabahTemp::first();

        if($exist) {
            $exist->update($data);
            return $exist;
        }

        return CalonNasabahTemp::insert($data);
    }

    public static function convertNasabahReq(Request $request): array
    {
        return [
            'nama' => $request->name,
            'alamat_rumah' => $request->alamat_rumah,
            'alamat_usaha' => $request->alamat_usaha,
            'no_ktp' => $request->no_ktp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status' => $request->status,
            'sektor_kredit' => $request->sektor_kredit,
            'jenis_usaha' => $request->jenis_usaha,
            'jumlah_kredit' => str_replace('.', '', $request->jumlah_kredit),
            'tujuan_kredit' => $request->tujuan_kredit,
            'jaminan_kredit' => $request->jaminan,
            'hubungan_bank' => $request->hubungan_bank,
            'verifikasi_umum' => $request->hasil_verifikasi,
            'id_user' => $request->user()->id,
            'id_kabupaten' => intval($request->kabupaten),
            'id_kecamatan' => intval($request->kec),
            'id_desa' => intval($request->desa),
            'tenor_yang_diminta' => intval($request->tenor_yang_diminta),
        ];
    }
}
