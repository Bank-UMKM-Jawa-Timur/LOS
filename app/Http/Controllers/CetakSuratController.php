<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonNasabah;
use App\Models\ItemModel;
use App\Models\KomentarModel;
use App\Models\PengajuanModel;
use Illuminate\Support\Facades\DB;

class CetakSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // protected $param;
    protected $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    public function index()
    {
        $param['nasabah'] = CalonNasabah::get();
        return view('cetak.cetak-surat', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $this->params['nasabah'] = CalonNasabah::find($id);
        // return view('cetak.cetak-surat', $this->params);
        echo "asd";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cetak($id)
    {
        $param['dataAspek'] = ItemModel::select('*')->where('level',1)->get();
        $param['dataNasabah'] = CalonNasabah::select('calon_nasabah.*','kabupaten.id as kabupaten_id','kabupaten.kabupaten','kecamatan.id as kecamatan_id','kecamatan.id_kabupaten','kecamatan.kecamatan','desa.id as desa_id','desa.id_kabupaten','desa.id_kecamatan','desa.desa')
                                        ->join('kabupaten','kabupaten.id','calon_nasabah.id_kabupaten')
                                        ->join('kecamatan','kecamatan.id','calon_nasabah.id_kecamatan')
                                        ->join('desa','desa.id','calon_nasabah.id_desa')
                                        ->where('calon_nasabah.id_pengajuan',$id)
                                        ->first();
        $param['dataUmum'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.tanggal_review_penyelia')
                                        ->find($id);
        $param['dataUmum'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.tanggal_review_penyelia')
                                        ->find($id);
        $param['komentar'] = KomentarModel::where('id_pengajuan', $id)->first();

        return view('cetak.cetak-surat', $param);
    }

    public function cetakSPPk($id)
    {
        $count = DB::table('log_cetak_kkb')
            ->where('id_pengajuan', $id)
            ->count('*');
        if($count < 1){
            DB::table('log_cetak_kkb')
                ->insert([
                    'id_pengajuan' => $id,
                    'tgl_cetak_sppk' => now()
                ]);
        } else{
            DB::table('log_cetak_kkb')
                ->where('id_pengajuan', $id)
                ->update([
                    'tgl_cetak_sppk' => now()
                ]);
        }
    
        $param['dataNasabah'] = CalonNasabah::select('calon_nasabah.*','kabupaten.id as kabupaten_id','kabupaten.kabupaten','kecamatan.id as kecamatan_id','kecamatan.id_kabupaten','kecamatan.kecamatan','desa.id as desa_id','desa.id_kabupaten','desa.id_kecamatan','desa.desa')
            ->join('kabupaten','kabupaten.id','calon_nasabah.id_kabupaten')
            ->join('kecamatan','kecamatan.id','calon_nasabah.id_kecamatan')
            ->join('desa','desa.id','calon_nasabah.id_desa')
            ->where('calon_nasabah.id_pengajuan',$id)
            ->first();
            
        $param['dataUmum'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang')
            ->find($id);

        $param['dataCabang'] = DB::table('cabang')
            ->where('id', $param['dataUmum']->id_cabang)
            ->first();

        $param['tglCetak'] = DB::table('log_cetak_kkb')
            ->where('id_pengajuan', $id)
            ->first();

        $indexBulan = intval(date('m', strtotime($param['tglCetak']->tgl_cetak_sppk))) - 1;
        $param['tgl'] = date('d', strtotime($param['tglCetak']->tgl_cetak_sppk)) . ' ' . $this->bulan[$indexBulan] . ' ' . date('Y', strtotime($param['tglCetak']->tgl_cetak_sppk));

        $param['installment'] = DB::table('jawaban_text')
            ->where('id_pengajuan', $id)
            ->where('id_jawaban', 140)
            ->first() ?? '0';

        return view('cetak.cetak-sppk', $param);
    }

    public function cetakPO($id)
    {
        $count = DB::table('log_cetak_kkb')
            ->where('id_pengajuan', $id)
            ->count('*');
        if($count < 1){
            DB::table('log_cetak_kkb')
                ->insert([
                    'id_pengajuan' => $id,
                    'tgl_cetak_po' => now()
                ]);
        } else {
            DB::table('log_cetak_kkb')
                ->where('id_pengajuan', $id)
                ->update([
                    'tgl_cetak_po' => now()
                ]);
        }

        $param['dataNasabah'] = CalonNasabah::select('calon_nasabah.*','kabupaten.id as kabupaten_id','kabupaten.kabupaten','kecamatan.id as kecamatan_id','kecamatan.id_kabupaten','kecamatan.kecamatan','desa.id as desa_id','desa.id_kabupaten','desa.id_kecamatan','desa.desa')
            ->join('kabupaten','kabupaten.id','calon_nasabah.id_kabupaten')
            ->join('kecamatan','kecamatan.id','calon_nasabah.id_kecamatan')
            ->join('desa','desa.id','calon_nasabah.id_desa')
            ->where('calon_nasabah.id_pengajuan',$id)
            ->first();
            
        $param['dataUmum'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang')
            ->find($id);
            

        $param['tglCetak'] = DB::table('log_cetak_kkb')
            ->where('id_pengajuan', $id)
            ->first();

        $param['dataCabang'] = DB::table('cabang')
            ->where('id', $param['dataUmum']->id_cabang)
            ->first();

        $indexBulan = intval(date('m', strtotime($param['tglCetak']->tgl_cetak_po))) - 1;
        $param['tgl'] = date('d', strtotime($param['tglCetak']->tgl_cetak_po)) . ' ' . $this->bulan[$indexBulan] . ' ' . date('Y', strtotime($param['tglCetak']->tgl_cetak_po));

        $param['dataKendaraan'] = DB::table('data_po')
            ->where('id_pengajuan', $id)
            ->join('mst_tipe', 'mst_tipe.id', 'data_po.id_type')
            ->join('mst_merk', 'mst_tipe.id_merk', 'mst_merk.id')
            ->select('mst_tipe.tipe', 'mst_merk.merk')
            ->first();
        $param['dataPO'] = DB::table('data_po')
            ->where('id_pengajuan', $id)
            ->first();
        return view('cetak.cetak-po', $param);
    }

    public function cetakPk($id)
    {
        $count = DB::table('log_cetak_kkb')
            ->where('id_pengajuan', $id)
            ->count('tgl_cetak_pk');
        if($count < 1){
            DB::table('log_cetak_kkb')
                ->where('id_pengajuan', $id)
                ->update([
                    'tgl_cetak_pk' => now()
                ]);
        }

        $param['dataNasabah'] = CalonNasabah::select('calon_nasabah.*','kabupaten.id as kabupaten_id','kabupaten.kabupaten','kecamatan.id as kecamatan_id','kecamatan.id_kabupaten','kecamatan.kecamatan','desa.id as desa_id','desa.id_kabupaten','desa.id_kecamatan','desa.desa')
            ->join('kabupaten','kabupaten.id','calon_nasabah.id_kabupaten')
            ->join('kecamatan','kecamatan.id','calon_nasabah.id_kecamatan')
            ->join('desa','desa.id','calon_nasabah.id_desa')
            ->where('calon_nasabah.id_pengajuan',$id)
            ->first();
            

        $param['tglCetak'] = DB::table('log_cetak_kkb')
            ->where('id_pengajuan', $id)
            ->first();

        $param['dataUmum'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang')
            ->find($id);

        $param['dataCabang'] = DB::table('cabang')
            ->where('id', $param['dataUmum']->id_cabang)
            ->first();

        $indexBulan = intval(date('m', strtotime($param['tglCetak']->tgl_cetak_pk))) - 1;
        $param['tgl'] = date('d', strtotime($param['tglCetak']->tgl_cetak_pk)) . ' ' . $this->bulan[$indexBulan] . ' ' . date('Y', strtotime($param['tglCetak']->tgl_cetak_pk));
            
        return view('cetak.cetak-pk', $param);
    }
}
