<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PengajuanKreditController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PengajuanAPIController extends Controller
{
    static function getKaryawan($nip){
        // retrieve from api
        $host = env('HCS_HOST');
        $apiURL = $host . '/api/karyawan';

        try {
            $response = Http::timeout(3)->withOptions(['verify' => false])->get($apiURL, [
                'nip' => $nip,
            ]);

            $statusCode = $response->status();
            $responseBody = json_decode($response->getBody(), true);

            if ($responseBody != null) {
                if (is_array($responseBody)) {
                    if (array_key_exists('data', $responseBody))
                        return $responseBody['data'];
                    else
                        return 'undifined';
                } else
                    return 'undifined';
            } else
                return 'undifined';
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return 'undifined';
            // return $e->getMessage();
        }
    }

    public function login(Request $request)
    {
        // Cek User ditemukan atau tidak
        $cekNIPUser = User::where('nip', $request['email'])
            ->first();
        if($cekNIPUser) {
            if(!Auth::attempt(['email' => $cekNIPUser->email, 'password' => $request['password']])) {
                return response()->json([
                    'status' => 'gagal',
                    'message' => 'Email atau NIP tidak ditemukan.',
                    'req' => $request->all()
                ], 401);
            }
        } else {
            if(!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
                return response()->json([
                    'status' => 'gagal',
                    'message' => 'Email atau NIP tidak ditemukan.',
                    'req' => $request->all()
                ], 401);
            }
        }

        $user = User::where('email', $request['email'])
            ->orWhere('nip', $request['email'])
            ->firstOrFail();

        // Cek Role user jika tersedia
        if($user->role == 'Administrator'){
            if(DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->count() > 0){
                return response()->json([
                    'status' => 'gagal',
                    'message' => 'Akun sedang digunakan di perangkat lain.'
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'berhasil',
                'message' => 'berhasil login',
                'email' => $user->email,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'data' => $user->nip ? $this->getKaryawan($user->nip) : $user
            ]);
        } else {
            if($user->nip != null){
                if(DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->count() > 0){
                    return response()->json([
                        'status' => 'gagal',
                        'message' => 'Akun seadang digunakan di perangkat lain.'
                    ], 401);
                }

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'status' => 'berhasil',
                    'message' => 'berhasil login',
                    'email' => $user->email,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'data' => $user->nip ? $this->getKaryawan($user->nip) : $user
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Belum dilakukan Pengkinian Data User untuk $request->email.\nHarap menghubungi Divisi Pemasaran atau TI & AK.',
                ]);
            }
        }
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
            // ->join('mst_tipe', 'mst_tipe.id', 'data_po.id_type')
            // ->join('mst_merk', 'mst_merk.id', 'mst_tipe.id_merk')
            // ->select('pengajuan.id', 'calon_nasabah.nama', 'calon_nasabah.jumlah_kredit', 'data_po.no_po', 'calon_nasabah.tenor_yang_diminta', 'pengajuan.sppk', 'pengajuan.po', 'pengajuan.tanggal', 'pengajuan.pk', 'mst_merk.merk', 'mst_tipe.tipe', 'data_po.tahun_kendaraan', 'data_po.harga', 'data_po.jumlah AS jumlah_kendaraan')
            ->select('pengajuan.id', 'calon_nasabah.nama', 'calon_nasabah.jumlah_kredit', 'data_po.no_po', 'data_po.tipe', 'data_po.merk', 'calon_nasabah.tenor_yang_diminta', 'pengajuan.sppk', 'pengajuan.po', 'pengajuan.tanggal', 'pengajuan.pk', 'data_po.tahun_kendaraan', 'data_po.harga', 'data_po.jumlah AS jumlah_kendaraan')
            ->first();
        if ($data) {
            return response()->json([
                'id_pengajuan' => $data->id,
                'nama' => $data->nama,
                'jumlah_kredit' => intval($data->jumlah_kredit),
                'no_po' => $data->no_po,
                'tenor' => intval($data->tenor_yang_diminta),
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
        else {
            return response()->json([
                'status' => 'success',
                'message' => 'Data not found'
            ]);
        }
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

    public function getCabang($kode) {
        $data = DB::table('cabang')
            ->select('kode_cabang', 'cabang')
            ->where('kode_cabang', $kode)
            ->first();

        return response()->json($data);
    }

    public function getAllCabang() {
        $data = DB::table('cabang')
            ->select('kode_cabang', 'cabang')
            ->get();

        return response()->json($data);
    }

    public function getCountPengajuan(Request $request){
        $cabangIds = DB::table('cabang')->get();
        $tAwal = $request->tanggal_awal;
        $tAkhir = $request->tanggal_akhir;
        $pilCabang = $request->cabang;

        // semua cabang
        $semua_cabang = [];
        foreach ($cabangIds as $c) {
            $dataCS = DB::table('pengajuan')
            ->selectRaw('kode_cabang as kodeC,
                                    cabang,
                                    sum(posisi = "selesai") as disetujui,
                                    sum(posisi = "Ditolak") as ditolak,
                                    sum(posisi = "pincab") as pincab,
                                    sum(posisi = "PBP") as PBP,
                                    sum(posisi = "PBO") as PBO,
                                    sum(posisi = "Review Penyelia") as penyelia,
                                    sum(posisi = "Proses Input Data") as staff,
                                    count(*) as total')
            ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
            ->where('cabang.id', $c->id)
            ->whereBetween('tanggal', [$tAwal, ($tAkhir ?? date('Y-m-d'))])
            ->get();
            $dataCS->map(function ($item) {
                $item->proces = $item->disetujui + $item->pincab + $item->PBP + $item->PBO + $item->penyelia + $item->staff;
                return  $item;
            });

            $c = [
                'kode_cabang' => $c->kode_cabang,
                'cabang' => $c->cabang,
                'disetujui' => $dataCS[0]->disetujui ?? 0,
                'ditolak' => $dataCS[0]->ditolak ?? 0,
                'proses' => $dataCS[0]->proces ?? 0,
            ];

            array_push($semua_cabang, $c);
        }

        // cabang di pilih 1
        $dataC = DB::table('pengajuan')
        ->selectRaw('kode_cabang as kode_cabang,
                                cabang,
                                sum(posisi = "selesai") as disetujui,
                                sum(posisi = "Ditolak") as ditolak,
                                sum(posisi = "pincab") as pincab,
                                sum(posisi = "PBP") as PBP,
                                sum(posisi = "PBO") as PBO,
                                sum(posisi = "Review Penyelia") as penyelia,
                                sum(posisi = "Proses Input Data") as staff,
                                count(*) as total')
        ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
        ->where('cabang.id', $pilCabang)
            ->whereBetween('tanggal', [$tAwal, ($tAkhir ?? date('Y-m-d'))])
            ->get();

        $jarr = $dataC->map(function ($item) {
            $item->proces = $item->disetujui + $item->pincab + $item->PBP + $item->PBO + $item->penyelia + $item->staff;
            return $item;
        });

        $cabang_pilih = $jarr->toArray();


        return response()->json([
            'status' => 'berhasil',
            'message' => 'berhasil menampilkan data',
            'data' => $pilCabang == 'semua' ? $semua_cabang : $cabang_pilih
        ]);
    }

    public function getPosisiPengajuan(Request $request){
        
    }
}
