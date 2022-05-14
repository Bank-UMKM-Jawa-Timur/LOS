<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonNasabah;
use App\Models\ItemModel;
use App\Models\KomentarModel;
use App\Models\PengajuanModel;

class CetakSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // protected $param;
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
}
