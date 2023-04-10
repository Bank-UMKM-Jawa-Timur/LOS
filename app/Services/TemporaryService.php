<?php
namespace App\Services;

use App\Models\CalonNasabahTemp;
use App\Models\JawabanTemp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class TemporaryService
{
    public static function getNasabahData(User $user): CalonNasabahTemp
    {
        if($nasData = CalonNasabahTemp::where('id_user', $user->id)->first()) return $nasData;
        return CalonNasabahTemp::create([
            'id_user' => Auth::user()->id,
        ]);
    }

    public static function saveNasabah(int $id, array $data): CalonNasabahTemp
    {
        $nasabah = CalonNasabahTemp::find($id);
        $nasabah->update($data);

        return $nasabah;
    }

    public static function saveFile(CalonNasabahTemp $nasabah, int $aID, int|null $fID, UploadedFile $file)
    {
        $exist = JawabanTemp::find($fID);

        $path = public_path("upload/temp/{$aID}/");
        $name = time() . '.' . $file->getClientOriginalExtension();

        if($exist) {
            @unlink($path . $exist->opsi_text);
            $exist->update(['opsi_text' => $name]);
        } else {
            $exist = JawabanTemp::create([
                'id_temporary_calon_nasabah' => $nasabah->id,
                'id_jawaban' => $aID,
                'opsi_text' => $name,
                'type' => 'file',
            ]);
        }

        $file->move($path, $name);
        return [
            'filename' => $name,
            'file_id' => $exist->id,
        ];
    }

    public static function delFile(JawabanTemp|null $answer)
    {
        if(!$answer) return false;

        $path = public_path("upload/temp/{$answer->id_jawaban}/{$answer->opsi_text}");

        @unlink($path);
        $answer->delete();

        return true;
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
