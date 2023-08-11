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
                'role' => $user->role,
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
                    'role' => $user->role,
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

<<<<<<< HEAD
    public function getSumPengajuan(Request $request) {
        if ($request->all() != null){
            // return $request->all();
            $dataTertinggi = DB::table('pengajuan')
                ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir') != null ? $request->get('tanggal_akhir') : now()])
                ->selectRaw('count(pengajuan.id) as total, cabang.kode_cabang, cabang.cabang')
                ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                ->groupBy('cabang.kode_cabang')
                ->orderBy('total', 'desc')
                ->limit('5')
                ->get();
            $dataTerendah = DB::table('pengajuan')
                ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir') != null ? $request->get('tanggal_akhir') : now()])
                ->selectRaw('count(pengajuan.id) as total, cabang.kode_cabang, cabang.cabang')
                ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                ->groupBy('cabang.kode_cabang')
                ->orderBy('total', 'asc')
                ->limit('5')
                ->get();
            $message = 'berhasil menampilkan data pengajuan berdasarkan tanggal.';
        } else {
            $dataTertinggi = DB::table('pengajuan')
            ->selectRaw('count(pengajuan.id) as total, cabang.kode_cabang, cabang.cabang')
            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
            ->groupBy('cabang.kode_cabang')
            ->orderBy('total', 'desc')
            ->limit('5')
            ->get();
            $dataTerendah = DB::table('pengajuan')
                ->selectRaw('count(pengajuan.id) as total, cabang.kode_cabang, cabang.cabang')
                ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                ->groupBy('cabang.kode_cabang')
                ->orderBy('total', 'asc')
                ->limit('5')
                ->get();
            $message = 'berhasil menampilkan data pengajuan.';
        }
        // $dataKeseluruhan = DB::table('pengajuan')
        //     ->selectRaw('count(pengajuan.id) as total, cabang.kode_cabang, cabang.cabang')
        //     ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
        //     ->groupBy('cabang.kode_cabang')
        //     ->get();
        return response()->json([
            'status' => 'berhasil',
            'message' => $message,
            'data' => [
                'tertinggi' => $dataTertinggi,
                'terendah' => $dataTerendah,
                // 'keseluruhan' => $dataKeseluruhan
            ]
        ], 200);

    }

    public function getPosisiPengajuan(Request $request){
        $pilCabang = $request->cabang;
        $tAkhir = $request->tAkhir;
        $tAwal = $request->tAwal;
        $cabangIds = DB::table('cabang')->get();

        // cabang semua
        $all_data = [];
        foreach ($cabangIds as $rows) {
            $dat = DB::table('pengajuan')
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
            ->where('cabang.id', $rows->id)
                ->whereBetween('tanggal', [$tAwal, ($tAkhir ?? date('Y-m-d'))])
                ->get();
                $cbgs = [
                    'kode_cabang' => $dat[0]->kode_cabang ,
                    'cabang' => $dat[0]->cabang ,
                    'pincab' => $dat[0]->pincab | 0,
                    'PBP' => $dat[0]->PBP | 0,
                    'PBO' => $dat[0]->PBO | 0,
                    'penyelia' => $dat[0]->penyelia | 0,
                    'staff' => $dat[0]->staff | 0,
                ];
            array_push($all_data, $cbgs);
        }

        // cabang dipilih
        $data = DB::table('pengajuan')
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
=======
    public function getCountPengajuan(Request $request){
        $cabangIds = DB::table('cabang')->get();
        $tAwal = $request->tAwal;
        $tAkhir = $request->tAkhir;
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
                $item->proces = $item->pincab + $item->PBP + $item->PBO + $item->penyelia + $item->staff;
                return  $item;
            });

            $c = [
                'kode_cabang' => $c->kode_cabang,
                'cabang' => $c->cabang,
                'disetujui' => $dataCS[0]->disetujui != null ? $dataCS[0]->disetujui : 0,
                'ditolak' => $dataCS[0]->ditolak != null ? $dataCS[0]->ditolak : 0,
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
>>>>>>> feat/count-pengajuan
        ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
        ->where('cabang.id', $pilCabang)
            ->whereBetween('tanggal', [$tAwal, ($tAkhir ?? date('Y-m-d'))])
            ->get();

<<<<<<< HEAD
        $jarr = $data->map(function ($d) {
            return [
                'kode_cabang' => $d->kode_cabang,
                'cabang' => $d->cabang,
                'pincab' => $d->pincab | 0,
                'PBP' => $d->PBP | 0,
                'PBO' => $d->PBO | 0,
                'penyelia' => $d->penyelia | 0,
                'staff' => $d->staff | 0,
            ];
        });

        $pilih_cabang = $jarr->toArray();
=======
        $jarr = $dataC->map(function ($item) {
            // Menghitung nilai dari semua posisi kecuali "disetujui" dan "ditolak"
            $item->proses = $item->pincab + $item->PBP + $item->PBO + $item->penyelia + $item->staff;

            return [
                'kode_cabang' => $item->kode_cabang,
                'cabang' => $item->cabang,
                'disetujui' => $item->disetujui | 0,
                'ditolak' => $item->ditolak | 0,
                'proses' => $item->proses,
            ];
        });

        $cabang_pilih = $jarr->toArray();
>>>>>>> feat/count-pengajuan


        return response()->json([
            'status' => 'berhasil',
<<<<<<< HEAD
            'message' => 'berhasil menampilkan data pengajuan.',
            'data' => [
                'data_cabang' => $pilCabang == 'semua'? $all_data : $pilih_cabang
            ]
=======
            'message' => 'berhasil menampilkan data',
            'data' => $pilCabang == 'semua' ? $semua_cabang : $cabang_pilih
>>>>>>> feat/count-pengajuan
        ]);
    }
}
