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
            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
            // ->join('mst_tipe', 'mst_tipe.id', 'data_po.id_type')
            // ->join('mst_merk', 'mst_merk.id', 'mst_tipe.id_merk')
            // ->select('pengajuan.id', 'calon_nasabah.nama', 'calon_nasabah.jumlah_kredit', 'data_po.no_po', 'calon_nasabah.tenor_yang_diminta', 'pengajuan.sppk', 'pengajuan.po', 'pengajuan.tanggal', 'pengajuan.pk', 'mst_merk.merk', 'mst_tipe.tipe', 'data_po.tahun_kendaraan', 'data_po.harga', 'data_po.jumlah AS jumlah_kendaraan')
            ->select('pengajuan.id', 'calon_nasabah.nama', 'calon_nasabah.jumlah_kredit', 'data_po.no_po', 'data_po.tipe', 'data_po.merk', 'calon_nasabah.tenor_yang_diminta', 'calon_nasabah.alamat_rumah', 'calon_nasabah.alamat_usaha', 'pengajuan.sppk', 'pengajuan.po', 'pengajuan.tanggal', 'pengajuan.pk', 'data_po.tahun_kendaraan', 'data_po.harga', 'data_po.jumlah AS jumlah_kendaraan', 'cabang.kode_cabang', 'cabang.cabang', 'cabang.alamat AS alamat_cabang')
            ->first();
        if ($data) {
            return response()->json([
                'id_pengajuan' => $data->id,
                'nama' => $data->nama,
                'alamat_rumah' => $data->alamat_rumah,
                'alamat_usaha' => $data->alamat_usaha,
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
                'tanggal' => $data->tanggal,
                'kode_cabang' => $data->kode_cabang,
                'cabang' => $data->cabang,
                'alamat_cabang' => $data->alamat_cabang,
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

    public function getAllCabangMobile(){
        $data = DB::table('cabang')
            ->select('kode_cabang', 'cabang')
            ->get();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'berhasil menampilkan data cabang.',
            'data' => $data
        ]);
    }

    public function getSumPengajuan(Request $request) {
        if ($request->all() != null){
            // return $request->all();
            $total_disetujui = DB::table('pengajuan')
                ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir') != null ? $request->get('tanggal_akhir') : now()])
                ->where('posisi', 'Selesai')
                ->count();
            $total_ditolak = DB::table('pengajuan')
                ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir') != null ? $request->get('tanggal_akhir') : now()])
                ->where('posisi', 'Ditolak')
                ->count();
            $total_diproses = DB::table('pengajuan')
                ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir') != null ? $request->get('tanggal_akhir') : now()])
                ->whereIn('posisi', ['Pincab','PBP','PBO','Review Penyelia','Proses Input Data'])
                ->count();
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
            'total_disetujui' => $total_disetujui,
            'total_ditolak' => $total_ditolak,
            'total_diproses' => $total_diproses,
            'data' => [
                'tertinggi' => $dataTertinggi,
                'terendah' => $dataTerendah,
                // 'keseluruhan' => $dataKeseluruhan
            ]
        ], 200);

    }

    public function getSumSkema(Request $request){
        $currentMonth = date('m');
        if ($request->all() == null) {
            //Filter all skema without request in currentMonth
            $data = DB::table('pengajuan')
                ->selectRaw("sum(skema_kredit='PKPJ') as PKPJ,sum(skema_kredit='KKB') as KKB,sum(skema_kredit='Talangan Umroh') as Umroh,sum(skema_kredit='Prokesra') as Prokesra,sum(skema_kredit='Kusuma') as Kusuma")
                ->whereRaw('MONTH(tanggal) = ?', $currentMonth)
                ->get();
            $message = 'Berhasil Menampilkan Total Keseluruhan Skema Data Pengajuan Bulan '. date('F Y') .'.';
        } else {
            if ($request->get('skema') != null) {
                //Skema not null
                if ($request->get('cabang') != null) {
                    if ($request->get('tanggal_awal') != null && $request->get('tanggal_akhir') != null) {
                        //With date filter
                        $data = DB::table('pengajuan')
                            ->selectRaw('cabang.kode_cabang,cabang.cabang,count(pengajuan.id) as total')
                            ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir')])
                            ->where('skema_kredit', $request->get('skema'))
                            ->where('cabang.kode_cabang', $request->get('cabang'))
                            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                            ->groupBy('cabang.kode_cabang')
                            ->get();
                        $message = 'Berhasil Menampilkan Total Skema Data Pengajuan Cabang '. $request->get('cabang') .'.';
                    } else {
                        //without date filter
                        $data = DB::table('pengajuan')
                            ->selectRaw('cabang.kode_cabang,cabang.cabang,count(pengajuan.id) as total')
                            ->whereRaw('MONTH(tanggal) = ?', $currentMonth)
                            ->where('skema_kredit', $request->get('skema'))
                            ->where('cabang.kode_cabang', $request->get('cabang'))
                            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                            ->groupBy('cabang.kode_cabang')
                            ->get();
                        $message = 'Berhasil Menampilkan Total Skema Data Pengajuan Cabang '. $request->get('cabang') .' Bulan '. date('F Y') .'.';
                    }        
                } else {
                    if ($request->get('tanggal_awal') != null && $request->get('tanggal_akhir') != null) {
                        //Only date filter
                        $data = DB::table('pengajuan')
                            ->selectRaw('cabang.kode_cabang,cabang.cabang,count(pengajuan.id) as total')
                            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                            ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir')])
                            ->where('skema_kredit', $request->get('skema'))
                            ->groupBy('cabang.kode_cabang')
                            ->get();
                        $message = 'Berhasil Menampilkan Total Keseluruhan Skema Data Pengajuan';
                    } else {
                        //Without date filter
                        $data = DB::table('pengajuan')
                            ->selectRaw('cabang.kode_cabang,cabang.cabang,count(pengajuan.id) as total')
                            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                            ->whereRaw('MONTH(tanggal) = ?', $currentMonth)
                            ->where('skema_kredit', $request->get('skema'))
                            ->groupBy('cabang.kode_cabang')
                            ->get();
                        $message = 'Berhasil Menampilkan Total Keseluruhan Skema Data Pengajuan Bulan '. date('F Y') .'.';
                    }
                }
            } else {
                if ($request->get('cabang') != null) {
                    if ($request->get('tanggal_awal') != null && $request->get('tanggal_akhir') != null) {
                        //With date filter
                        $data = DB::table('pengajuan')
                            ->selectRaw("cabang.kode_cabang,cabang.cabang,sum(skema_kredit='PKPJ') as PKPJ,sum(skema_kredit='KKB') as KKB,sum(skema_kredit='Talangan Umroh') as Umroh,sum(skema_kredit='Prokesra') as Prokesra,sum(skema_kredit='Kusuma') as Kusuma")
                            ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir')])
                            // ->where('skema_kredit', $request->get('skema'))
                            ->where('cabang.kode_cabang', $request->get('cabang'))
                            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                            ->groupBy('cabang.kode_cabang')
                            ->get();
                        $message = 'Berhasil Menampilkan Total Skema Data Pengajuan Cabang '. $request->get('cabang') .'.';
                    } else {
                        //without date filter
                        $data = DB::table('pengajuan')
                            ->selectRaw("cabang.kode_cabang,cabang.cabang,sum(skema_kredit='PKPJ') as PKPJ,sum(skema_kredit='KKB') as KKB,sum(skema_kredit='Talangan Umroh') as Umroh,sum(skema_kredit='Prokesra') as Prokesra,sum(skema_kredit='Kusuma') as Kusuma")
                            ->whereRaw('MONTH(tanggal) = ?', $currentMonth)
                            // ->where('skema_kredit', $request->get('skema'))
                            ->where('cabang.kode_cabang', $request->get('cabang'))
                            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                            ->groupBy('cabang.kode_cabang')
                            ->get();
                        $message = 'Berhasil Menampilkan Total Skema Data Pengajuan Cabang '. $request->get('cabang') .' Bulan '. date('F Y') .'.';
                    }
                } else {
                    if ($request->get('tanggal_awal') != null && $request->get('tanggal_akhir') != null) {
                        //Only date filter
                        $data = DB::table('pengajuan')
                            ->selectRaw("cabang.kode_cabang,cabang.cabang,sum(skema_kredit='PKPJ') as PKPJ,sum(skema_kredit='KKB') as KKB,sum(skema_kredit='Talangan Umroh') as Umroh,sum(skema_kredit='Prokesra') as Prokesra,sum(skema_kredit='Kusuma') as Kusuma")
                            ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                            ->whereBetween('tanggal', [$request->get('tanggal_awal'), $request->get('tanggal_akhir')])
                            // ->where('skema_kredit', $request->get('skema'))
                            ->groupBy('cabang.kode_cabang')
                            ->get();
                        $message = 'Berhasil Menampilkan Total Keseluruhan Skema Data Pengajuan.';
                    } else {
                        //Without date filter
                        // $data = DB::table('pengajuan')
                        //     ->selectRaw("cabang.kode_cabang,cabang.cabang,sum(skema_kredit='PKPJ') as PKPJ,sum(skema_kredit='KKB') as KKB,sum(skema_kredit='Talangan Umroh') as Umroh,sum(skema_kredit='Prokesra') as Prokesra,sum(skema_kredit='Kusuma') as Kusuma")
                        //     ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                        //     ->whereRaw('MONTH(tanggal) = ?', $currentMonth)
                        //     // ->where('skema_kredit', $request->get('skema'))
                        //     ->groupBy('cabang.kode_cabang')
                        //     ->get();
                        // $message = 'Berhasil Menampilkan Total Keseluruhan Skema Data Pengajuan Bulan '. date('F Y') .'.';
                    }
                }
                
            }
            
        }
        return response()->json([
            'status' => 'berhasil',
            'message' => $message,
            'data' => $data
        ], 200);
        
    }

    public function getPosisiPengajuan(Request $request)
    {
        $pilCabang = $request->cabang;
        $tAkhir = $request->tAkhir;
        $tAwal = $request->tAwal;
        $tanggal = $request->tAwal . ' ' . $request->tAkhir;
        $tanggalAwal = date('Y') . '-' . date('m') . '-01';
        $hari_ini = now();


        // tanggal di pilih cabang tidak
          if ($tAwal != null && $tAkhir != null && $pilCabang == null) {
            $seluruh_data = DB::table('cabang AS c')
            ->select(
                'c.kode_cabang AS kodeC',
                'c.cabang',
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Pincab' GROUP BY id_cabang), 0) AS pincab"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'PBP' GROUP BY id_cabang), 0) AS pbp"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'PBO' GROUP BY id_cabang), 0) AS pbo"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Review Penyelia' GROUP BY id_cabang), 0) AS penyelia"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Proses Input Data' GROUP BY id_cabang), 0) AS staff"),
            )
                ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
                ->where('c.kode_cabang', '!=', 000)
                ->groupBy('kodeC')
                ->get();


        }
        // tanggal dipilih cabang juga
        elseif ($tAwal != null && $tAkhir != null && $pilCabang != null) {
            $seluruh_data = DB::table('cabang AS c')
            ->select(
                'c.kode_cabang AS kodeC',
                'c.cabang',
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Pincab' GROUP BY id_cabang), 0) AS pincab"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'PBP' GROUP BY id_cabang), 0) AS pbp"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'PBO' GROUP BY id_cabang), 0) AS pbo"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Review Penyelia' GROUP BY id_cabang), 0) AS penyelia"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Proses Input Data' GROUP BY id_cabang), 0) AS staff"),
            )
                ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
                ->where('c.kode_cabang', '!=', 000)
                ->groupBy('kodeC')
                ->where('c.id', $pilCabang)
                ->get();
        }
        // tanggal kosong cabang dipilih
        elseif($tAwal == null && $tAkhir == null && $pilCabang != null) {

            $seluruh_data = DB::table('cabang AS c')
            ->select(
                'c.kode_cabang AS kodeC',
                'c.cabang',
                    DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'Pincab' GROUP BY id_cabang), 0) AS pincab"),
                    DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'PBP' GROUP BY id_cabang), 0) AS pbp"),
                    DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'PBO' GROUP BY id_cabang), 0) AS pbo"),
                    DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'Review Penyelia' GROUP BY id_cabang), 0) AS penyelia"),
                    DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'Proses Input Data' GROUP BY id_cabang), 0) AS staff"),
            )
                ->leftJoin('pengajuan AS p', 'c.id', '=', 'p.id_cabang')
                ->where('c.kode_cabang', '!=', '000')
                ->groupBy('kodeC',)
                ->where('c.id', $pilCabang)
                ->get();
        }
        // tidak milih request
        else {
            $seluruh_data = DB::table('cabang AS c')
                ->select(
                    'c.kode_cabang AS kodeC',
                    'c.cabang',
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'Pincab' GROUP BY id_cabang), 0) AS pincab"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'PBP' GROUP BY id_cabang), 0) AS pbp"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'PBO' GROUP BY id_cabang), 0) AS pbo"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'Review Penyelia' GROUP BY id_cabang), 0) AS penyelia"),
                DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'Proses Input Data' GROUP BY id_cabang), 0) AS staff"),
                )
                ->leftJoin('pengajuan AS p', 'c.id', '=', 'p.id_cabang')
                ->where('c.kode_cabang', '!=', '000')
                ->groupBy('kodeC',)
                ->get();
        }


        return response()->json([
            'status' => 'berhasil',
            'message' => 'berhasil menampilkan data pengajuan.',
            'data' => $seluruh_data
        ]);
    }

    public function getCountPengajuan(Request $request)
    {
        $pilCabang = $request->cabang;
        $tAkhir = $request->tAkhir;
        $tAwal = $request->tAwal;
        $tanggal = $request->tAwal . ' ' . $request->tAkhir;
        $tanggalAwal = date('Y') . '-' . date('m') . '-01';
        $hari_ini = now();

        $total_setuju = 0;
        $total_ditolak = 0;
        $total_proses = 0;


        // tanggal di pilih cabang tidak
        if ( $tAwal != null && $tAkhir != null && $pilCabang == null) {
            $total_disetujui = DB::table('pengajuan')
                ->whereBetween('tanggal', [$tAwal, $tAkhir != null ? $tAkhir : now()])
                ->where('posisi', 'Selesai')
                ->count();
            $total_ditolak = DB::table('pengajuan')
                ->whereBetween('tanggal', [$tAwal, $tAkhir != null ? $tAkhir : now()])
                ->where('posisi', 'Ditolak')
                ->count();
            $total_diproses = DB::table('pengajuan')
                ->whereBetween('tanggal', [$tAwal, $tAkhir != null ? $tAkhir : now()])
                ->whereIn('posisi', ['Pincab','PBP','PBO','Review Penyelia','Proses Input Data'])
                ->count();
            $data = DB::table('pengajuan')
                ->selectRaw("cabang.kode_cabang as kodeC,cabang.cabang,sum(posisi='Selesai') as total_disetujui,sum(posisi='Ditolak') as total_ditolak,sum(posisi IN ('Pincab','PBP','PBO','Review Penyelia','Proses Input Data')) as total_diproses")
                ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                ->whereBetween('tanggal', [$tAwal, $tAkhir])
                ->groupBy('cabang.kode_cabang')
                ->get();
            
            return response()->json([
                'status' => 'berhasil',
                'message' => 'Berhasil Menampilkan Total Data Pengajuan.',
                'total_disetujui' => $total_disetujui,
                'total_ditolak' => $total_ditolak,
                'total_diproses' => $total_diproses,
                'data' => $data,
            ], 200);
        }
        // tanggal dipilih cabang juga
        elseif ($tAwal != null && $tAkhir != null && $pilCabang != null) {
            $data = DB::table('pengajuan')
                ->selectRaw("cabang.kode_cabang as kodeC,cabang.cabang,sum(posisi='Selesai') as total_disetujui,sum(posisi='Ditolak') as total_ditolak,sum(posisi IN ('Pincab','PBP','PBO','Review Penyelia','Proses Input Data')) as total_diproses")
                ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                ->whereBetween('tanggal', [$tAwal, $tAkhir])
                ->where('cabang.kode_cabang', $pilCabang)
                ->groupBy('cabang.kode_cabang')
                ->get();
            
            return response()->json([
                'status' => 'berhasil',
                'message' => 'Berhasil Menampilkan Total Data Pengajuan Cabang '. $pilCabang .'.',
                'data' => $data,
            ], 200);
        }
        // tanggal kosong cabang dipilih
        elseif ($tAwal == null && $tAkhir == null && $pilCabang != null) {
            $data = DB::table('pengajuan')
                ->selectRaw("cabang.kode_cabang as kodeC,cabang.cabang,sum(posisi='Selesai') as total_disetujui,sum(posisi='Ditolak') as total_ditolak,sum(posisi IN ('Pincab','PBP','PBO','Review Penyelia','Proses Input Data')) as total_diproses")
                ->join('cabang', 'cabang.id', 'pengajuan.id_cabang')
                ->whereBetween('tanggal', [$tanggalAwal, $hari_ini])
                ->where('cabang.kode_cabang', $pilCabang)
                ->groupBy('cabang.kode_cabang')
                ->get();
            
            return response()->json([
                'status' => 'berhasil',
                'message' => 'Berhasil Menampilkan Total Data Pengajuan Cabang '. $pilCabang .'.',
                'data' => $data,
            ], 200);
        }
        else {
            // $seluruh_data_proses = DB::table('cabang AS c')
            // ->select(
            //     'c.kode_cabang AS kodeC',
            //     'c.cabang',
            //     DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'Selesai' GROUP BY id_cabang), 0) AS disetujui"),
            //     DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi = 'Ditolak' GROUP BY id_cabang), 0) AS ditolak"),
            //     DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tanggalAwal' AND tanggal <= '$hari_ini' AND posisi != 'Ditolak' AND posisi != 'Selesai' GROUP BY id_cabang), 0) AS diproses")
            // )
            //     ->leftJoin('pengajuan AS p', 'c.id', '=', 'p.id_cabang')
            //     ->where('c.kode_cabang', '!=', '000')
            //     ->groupBy('kodeC',)
            //     ->get();
        }     
    }
}
