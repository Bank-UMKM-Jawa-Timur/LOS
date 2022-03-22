<?php

namespace App\Http\Controllers;

use App\Models\CalonNasabah;
use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengajuanKreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $param['pageTitle'] = "Dashboard";
        if(auth()->user()->level == 'Penyelia Kredit' || auth()->user()->level == 'Staf Analis Kredit'){
            $param['dataDesa'] = Desa::all();
            $param['dataKecamatan'] = Kecamatan::all();
            $param['dataKabupaten'] = Kabupaten::all();
            return view('pengajuan-kredit.add-pengajuan-kredit',$param);
        }
        else{
            return view('pengajuan-kredit.list-pengajuan-kredit',$param);
        }
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat_rumah' => 'required',
            'alamat_usaha' => 'required',
            'no_ktp' => 'required|unique:calon_nasabah,no_ktp|max:16',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'status' => 'required',
            'sektor_kredit' => 'required',
            'jenis_usaha' => 'required',
            'jumlah_kredit' => 'required',
            'tujuan_kredit' => 'required',
            'jaminan' => 'required',
            'hubungan_bank' => 'required',
            'hasil_verifikasi' => 'required',
        ],[
            'required' => 'data harus terisi.'
        ]);
        try {
            $addData = new CalonNasabah;
            $addData->nama = $request->name;
            $addData->alamat_rumah = $request->alamat_rumah;
            $addData->alamat_usaha = $request->alamat_usaha;
            $addData->no_ktp = $request->no_ktp;
            $addData->tempat_lahir = $request->tempat_lahir;
            $addData->tanggal_lahir = $request->tanggal_lahir;
            $addData->status = $request->status;
            $addData->sektor_kredit = $request->sektor_kredit;
            $addData->jenis_usaha = $request->jenis_usaha;
            $addData->jumlah_kredit = $request->jumlah_kredit;
            $addData->tujuan_kredit = $request->tujuan_kredit;
            $addData->jaminan_kredit = $request->jaminan;
            $addData->hubungan_bank = $request->hubungan_bank;
            $addData->verifikasi_umum = $request->hasil_verifikasi;
            $addData->id_user = auth()->user()->id;
            $addData->id_desa = $request->desa;
            $addData->id_kecamatan = $request->kec;
            $addData->id_kabupaten = $request->kabupaten;
            $addData->save();
            Session::put('id',$addData->id);

            return redirect()->route('pengajuan-kredit.create')->withStatus('Data berhasil disimpan.');
        } catch (Exception $e) {
            return $e;
            return redirect()->back()->withError('Terjadi kesalahan.');
        }catch(QueryException $e){
            return $e;
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }
    public function createPengajuanManagement()
    {
        $param['pageTitle'] = "Dashboard";
        $param['dataDesa'] = Desa::all();
        $param['dataKecamatan'] = Kecamatan::all();
        $param['dataKabupaten'] = Kabupaten::all();
        return view('pengajuan-kredit.add-aspek-management',$param);
    }
    public function pengajuanManagement(Request $request)
    {
        return redirect()->route('create.pengajuan.management');
    }
    public function pengajuanHukumJaminan(Request $request)
    {

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
        //
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

    public function getkecamatan(Request $request)
    {
        $kecamatan = Kecamatan::where("id_kabupaten",$request->kabID)->pluck('id','kecamatan');
        return response()->json($kecamatan);
    }
    public function getdesa(Request $request)
    {
        $desa = Desa::where("id_kecamatan",$request->kecID)->pluck('id','desa');
        return response()->json($desa);

    }
}
