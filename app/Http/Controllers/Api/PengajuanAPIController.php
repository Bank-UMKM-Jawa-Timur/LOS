<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanAPIController extends Controller
{
    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Authorized',
            'email' => $user->email,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function getDataPengajuan($id)
    {
        $data = DB::table('pengajuan')
            ->where('skema_kredit', 'KKB')
            ->where('posisi', 'Selesai')
            ->where('pengajuan.id', $id)
            ->whereNotNull('po')
            ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
            ->join('data_po', 'data_po.id_pengajuan', 'pengajuan.id')
            ->join('mst_tipe', 'mst_tipe.id', 'data_po.id_type')
            ->join('mst_merk', 'mst_merk.id', 'mst_tipe.id_merk')
            ->select('pengajuan.id', 'calon_nasabah.nama', 'calon_nasabah.jumlah_kredit', 'data_po.no_po', 'calon_nasabah.tenor_yang_diminta', 'pengajuan.sppk', 'pengajuan.po', 'pengajuan.tanggal', 'pengajuan.pk', 'mst_merk.merk', 'mst_tipe.tipe', 'data_po.tahun_kendaraan', 'data_po.harga', 'data_po.jumlah AS jumlah_kendaraan')
            ->first();
        
        return response()->json([
            'id_pengajuan' => $data->id,
            'nama' => $data->nama,
            'jumlah_kredit' => intval($data->jumlah_kredit),
            'no_po' => $data->no_po,
            'tenor' => intval($data->tenor_yang_diminta) * 12,
            'sppk' => $data->sppk ?? null,
            'po' => $data->po ?? null,
            'pk' => $data->pk ?? null,
            'merk' => $data->merk,
            'tipe' => $data->tipe,
            'tahun_kendaraan' => $data->tahun_kendaraan,
            'harga_kendaraan' => $data->harga,
            'jumlah_kendaraan' => $data->jumlah_kendaraan,
            'tanggal' => $data->tanggal
        ]);
    }

    public function getDataUsers($nip)
    {
        $data = DB::table('users')
            ->select('users.*', 'c.kode_cabang')
            ->join('cabang AS c', 'c.id', 'users.id_cabang')
            ->where('nip', $nip)
            ->first();

        return response()->json($data);
    }
}
