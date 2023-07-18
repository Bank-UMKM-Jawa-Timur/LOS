<?php

namespace App\Http\Controllers;

use App\Models\PengajuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        if ($json->data)
            return $json->data->nama_karyawan;
        return Auth::user()->name;
    }
}
