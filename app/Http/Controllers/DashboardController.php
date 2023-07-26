<?php

namespace App\Http\Controllers;

use App\Models\PengajuanModel;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\DataNominatif;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }
        $param['cabangs'] = DB::table('cabang')
            ->get();
        $id_cabang = Auth::user()->id_cabang;
        $current_cabang = DB::table('cabang')->select('kode_cabang')->where('id', $id_cabang)->first();
        $kode_cabang = '-';
        if ($current_cabang)
            $kode_cabang = $current_cabang->kode_cabang;
        $param['kode_cabang'] = $kode_cabang;
        
        if (Auth::user()->role == "Staf Analis Kredit") {
            $id_data = auth()->user()->id;
            $param['data'] = PengajuanModel::select('pengajuan.id', 'pengajuan.id_staf', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.progress_pengajuan_data', 'pengajuan.tanggal_review_penyelia', 'pengajuan.tanggal_review_pincab', 'pengajuan.status', 'pengajuan.status_by_sistem', 'pengajuan.id_cabang', 'pengajuan.average_by_sistem', 'pengajuan.average_by_penyelia', 'calon_nasabah.nama', 'calon_nasabah.jenis_usaha', 'calon_nasabah.sektor_kredit', 'calon_nasabah.jumlah_kredit', 'calon_nasabah.id_pengajuan')
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->where('pengajuan.posisi', 'Proses Input Data')
                ->where('pengajuan.id_staf', $id_data)
                ->get();
            // dd($param['data']);
        } elseif (Auth::user()->role == "Penyelia Kredit") {
            $id_data = auth()->user()->id;
            $param['data'] = PengajuanModel::select('pengajuan.id_penyelia', 'pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.progress_pengajuan_data', 'pengajuan.tanggal_review_penyelia', 'pengajuan.tanggal_review_pincab', 'pengajuan.status', 'pengajuan.status_by_sistem', 'pengajuan.id_cabang', 'pengajuan.average_by_sistem', 'pengajuan.average_by_penyelia', 'calon_nasabah.nama', 'calon_nasabah.jenis_usaha', 'calon_nasabah.sektor_kredit', 'calon_nasabah.jumlah_kredit', 'calon_nasabah.id_pengajuan')
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->where('pengajuan.posisi', '=', 'Review Penyelia')
                ->where('pengajuan.id_penyelia', $id_data)
                ->get();
            // dd($param['data']);
        } elseif (Auth::user()->role == "PBO") {
            $id_data = auth()->user()->id;
            $param['data'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.progress_pengajuan_data', 'pengajuan.tanggal_review_penyelia', 'pengajuan.tanggal_review_pincab', 'pengajuan.status', 'pengajuan.status_by_sistem', 'pengajuan.id_cabang', 'pengajuan.average_by_sistem', 'pengajuan.average_by_penyelia', 'calon_nasabah.nama', 'calon_nasabah.jenis_usaha', 'calon_nasabah.sektor_kredit', 'calon_nasabah.jumlah_kredit', 'calon_nasabah.id_pengajuan')
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->where('pengajuan.posisi', '=', 'PBO')
                ->where('pengajuan.id_pbo', $id_data)
                ->get();
        } elseif (Auth::user()->role == "PBP") {
            $id_data = auth()->user()->id;
            $param['data'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.progress_pengajuan_data', 'pengajuan.tanggal_review_penyelia', 'pengajuan.tanggal_review_pincab', 'pengajuan.status', 'pengajuan.status_by_sistem', 'pengajuan.id_cabang', 'pengajuan.average_by_sistem', 'pengajuan.average_by_penyelia', 'calon_nasabah.nama', 'calon_nasabah.jenis_usaha', 'calon_nasabah.sektor_kredit', 'calon_nasabah.jumlah_kredit', 'calon_nasabah.id_pengajuan')
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->where('pengajuan.posisi', '=', 'PBP')
                ->where('pengajuan.id_pbp', $id_data)
                ->get();
        } elseif (Auth::user()->role == "Pincab") {
            $id_data = auth()->user()->id;
            $param['data'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.progress_pengajuan_data', 'pengajuan.tanggal_review_penyelia', 'pengajuan.tanggal_review_pincab', 'pengajuan.status', 'pengajuan.status_by_sistem', 'pengajuan.id_cabang', 'pengajuan.average_by_sistem', 'pengajuan.average_by_penyelia', 'calon_nasabah.nama', 'calon_nasabah.jenis_usaha', 'calon_nasabah.sektor_kredit', 'calon_nasabah.jumlah_kredit', 'calon_nasabah.id_pengajuan')
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->where('pengajuan.posisi', '=', 'Pincab')
                ->where('pengajuan.id_pincab', $id_data)
                ->get();
        } else {
            $param['data'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.progress_pengajuan_data', 'pengajuan.tanggal_review_penyelia', 'pengajuan.tanggal_review_pincab', 'pengajuan.status', 'pengajuan.status_by_sistem', 'pengajuan.id_cabang', 'pengajuan.average_by_sistem', 'pengajuan.average_by_penyelia', 'calon_nasabah.nama', 'calon_nasabah.jenis_usaha', 'calon_nasabah.sektor_kredit', 'calon_nasabah.jumlah_kredit', 'calon_nasabah.id_pengajuan')
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->get();
        }
        return view('dashboard', $param);
    }

    public static function getKaryawan()
    {
        $host = env('HCS_HOST');
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $host . '/api/v1/karyawan/' . auth()->user()->nip,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $json = json_decode($response);

        if ($json) {
            if ($json->data)
                return $json->data->nama_karyawan;
        }
        return Auth::user()->name;
    }

    public function cetak(Request $request)
    {

        $param['tAwal'] = $request->tAwal;
        $param['tAkhir'] = $request->tAkhir;
        $pilCabang = $request->cabang;
        $tAkhir = $request->tAkhir;
        $tAwal = $request->tAwal;
        $jExport = $request->export;
        if ($jExport == 'pdf') {
            $cabangIds = cabang::get();
            if ($pilCabang == 'semua') {
                // $param['data'] = [];
                $all_data = [];
                foreach ($cabangIds as $rows) {
                    $dat = DB::table('pengajuan')
                        ->selectRaw('kode_cabang as kodeC,
                                 cabang,
                                 sum(posisi = "selesai") as disetujui,
                                 sum(posisi = "Ditolak") as ditolak,
                                 sum(posisi = "pincab") as pincab,
                                 sum(posisi = "PBB") as PBB,
                                 sum(posisi = "PBO") as PBO,
                                 sum(posisi = "Review Penyelia") as penyelia,
                                 sum(posisi = "Proses Input Data") as staff,
                                 count(*) as total')
                        ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
                        ->where('cabang.id', $rows->id)
                        ->whereBetween('tanggal', [$tAwal, ($tAkhir ?? date('Y-m-d'))])
                        ->groupBy('id_cabang')
                        ->orderBy('total', 'DESC')
                        ->get();
                    if (count($dat) == 0) {
                        $cbgs = [
                            'kodeC' => $rows->kode_cabang,
                            'cabang' => $rows->cabang,
                            'disetujui' => 0,
                            'ditolak' => 0,
                            'pincab' => 0,
                            'PBB' => 0,
                            'PBO' => 0,
                            'penyelia' => 0,
                            'staff' => 0,
                            'total' => 0,
                        ];
                    } else {
                        $cbgs = [
                            'kodeC' => $dat[0]->kodeC,
                            'cabang' => $dat[0]->cabang,
                            'disetujui' => $dat[0]->disetujui,
                            'ditolak' => $dat[0]->ditolak,
                            'pincab' => $dat[0]->pincab,
                            'PBB' => $dat[0]->PBB,
                            'PBO' => $dat[0]->PBO,
                            'penyelia' => $dat[0]->penyelia,
                            'staff' => $dat[0]->staff,
                            'total' => $dat[0]->total,
                        ];
                    }
                    array_push($all_data, $cbgs);
                }

                $param['data'] =  $all_data;
            } else {
                $data = DB::table('pengajuan')
                    ->selectRaw('kode_cabang as kodeC,
                                 cabang,
                                 sum(posisi = "selesai") as disetujui,
                                 sum(posisi = "Ditolak") as ditolak,
                                 sum(posisi = "pincab") as pincab,
                                 sum(posisi = "PBB") as PBB,
                                 sum(posisi = "PBO") as PBO,
                                 sum(posisi = "Review Penyelia") as penyelia,
                                 sum(posisi = "Proses Input Data") as staff,
                                 count(*) as total')
                    ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
                    ->where('cabang.id', $pilCabang)
                    ->whereBetween('tanggal', [$tAwal, ($tAkhir ?? date('Y-m-d'))])
                    ->groupBy('id_cabang')
                    ->orderBy('total')
                    ->get();

                $arr = $data->map(function ($d) {
                    return get_object_vars($d);
                });

                $param['data'] = $arr->toArray();
            }

            // seluruh data
            $seluruh_data = [];
            foreach ($cabangIds as $row) {
                $dataS = DB::table('pengajuan')
                    ->selectRaw('kode_cabang as kodeC,
                                    cabang,
                                    sum(posisi = "selesai") as disetujui,
                                    sum(posisi = "Ditolak") as ditolak,
                                    sum(posisi = "pincab") as pincab,
                                    sum(posisi = "PBB") as PBB,
                                    sum(posisi = "PBO") as PBO,
                                    sum(posisi = "Review Penyelia") as penyelia,
                                    sum(posisi = "Proses Input Data") as staff,
                                    count(*) as total')
                    ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
                    ->where('cabang.id', $row->id)
                    ->orderBy('KodeC')
                    ->get();

                // if (count($dataS) == 0) {
                //     $c = [
                //         'kodeC' => $row->kode_cabang,
                //         'cabang' => $row->cabang,
                //         'disetujui' => 0,
                //         'ditolak' => 0,
                //         'pincab' => 0,
                //         'PBB' => 0,
                //         'PBO' => 0,
                //         'penyelia' => 0,
                //         'staff' => 0,
                //         'total' => 0,
                //     ];
                // } else {
                $c = [
                    'kodeC' => $dataS[0]->kodeC,
                    'cabang' => $dataS[0]->cabang,
                    'disetujui' => $dataS[0]->disetujui | 0,
                    'ditolak' => $dataS[0]->ditolak | 0,
                    'pincab' => $dataS[0]->pincab | 0,
                    'PBB' => $dataS[0]->PBB | 0,
                    'PBO' => $dataS[0]->PBO | 0,
                    'penyelia' => $dataS[0]->penyelia | 0,
                    'staff' => $dataS[0]->staff | 0,
                    'total' => $dataS[0]->total | 0,
                ];
                // }
                // dd($dataS);

                array_push($seluruh_data, $c);
            }
            $param['dataS'] = $seluruh_data;


            // Semua Data Cabang berhasil dan Di tolak
            $semua_cabang = [];
            foreach ($cabangIds as $c) {
                $dataC = DB::table('pengajuan')
                    ->selectRaw('kode_cabang as kodeC,
                                    cabang,
                                    sum(posisi = "selesai") as disetujui,
                                    sum(posisi = "Proses Input Data") as staff,
                                    count(*) as total')
                    ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
                    ->where('cabang.id', $c->id)
                    ->orderBy('KodeC')
                    ->get();
                // if (count($dataC) == 0) {
                //     $c = [
                //         'kodeC' => $c->kode_cabang,
                //         'cabang' => $c->cabang,
                //         'disetujui' => 0,
                //         'staff' => 0,
                //         'total' => 0,
                //     ];
                // } else {
                $c = [
                    'kodeC' => $dataC[0]->kodeC,
                    'cabang' => $dataC[0]->cabang,
                    'disetujui' => $dataC[0]->disetujui | 0,
                    'staff' => $dataC[0]->staff | 0,
                    'total' => $dataC[0]->total | 0,
                ];
                // }
                array_push($semua_cabang, $c);
            }

            $param['dataC'] =  $semua_cabang;

            $pdf = PDF::loadView('modal.DataNominatif', $param);
            // Return hasil PDF untuk diunduh atau ditampilkan
            return $pdf->download('DATA NOMINATIF.pdf');
        } else {
            return Excel::download(new DataNominatif, 'DATA_NOMINATIF.xlsx');
        }
    }

    public function cetakExcel(Request $request)
    {
        $request->validate(
            [
                'tAwal' => 'required',
                'tAkhir' => 'required'
            ],
            [
                'tAwal.required' => "tanggal Awal Belum Di isi",
                'tAkhir.required' => "tanggal Akhir Belum Di isi",
            ]
        );
    }
}
