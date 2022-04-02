<?php

namespace App\Http\Controllers;

use App\Models\CalonNasabah;
use App\Models\Desa;
use App\Models\DetailKomentarModel;
use App\Models\ItemModel;
use App\Models\JawabanPengajuanModel;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\KomentarModel;
use App\Models\PengajuanModel;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        if(auth()->user()->role == 'Staf Analis Kredit' || auth()->user()->role == 'PBO / PBP'){
            $param['dataDesa'] = Desa::all();
            $param['dataKecamatan'] = Kecamatan::all();
            $param['dataKabupaten'] = Kabupaten::all();
            $param['dataAspek'] = ItemModel::select('*')->where('level',1)->get();

            $data['dataPertanyaanSatu'] = ItemModel::select('id','nama','level','id_parent')->where('level',2)->where('id_parent',3)->get();
            return view('pengajuan-kredit.add-pengajuan-kredit',$param);
        }
        else{
            $id_cabang = Auth::user()->id_cabang;
            $param['data_pengajuan'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.status','pengajuan.tanggal_konfirmasi','pengajuan.id_cabang','pengajuan.average','calon_nasabah.nama','calon_nasabah.jenis_usaha','calon_nasabah.id_pengajuan')
                                            ->join('calon_nasabah','calon_nasabah.id_pengajuan','pengajuan.id')
                                            ->where('pengajuan.id_cabang',$id_cabang)
                                            ->get();

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
        // return $request;
        $checkLevelDua = $request->dataLevelDua != null ? 'required|not_in:0' : '';
        $checkLevelTiga = $request->dataLevelTiga != null ? 'required|not_in:0' : '';
        $checkLevelEmpat = $request->dataLevelEmpat != null ? 'required|not_in:0' : '';
        $request->validate([
            'name' => 'required',
            'alamat_rumah' => 'required',
            'alamat_usaha' => 'required',
            'no_ktp' => 'required|unique:calon_nasabah,no_ktp|max:16',
            'kabupaten' => 'required|not_in:0',
            'kec' => 'required|not_in:0',
            'desa' => 'required|not_in:0',
            'kabupaten' => 'required|not_in:0',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'status' => 'required|not_in:0',
            'sektor_kredit' => 'required|not_in:0',
            'jenis_usaha' => 'required',
            'jumlah_kredit' => 'required',
            'tujuan_kredit' => 'required',
            'jaminan' => 'required',
            'hubungan_bank' => 'required',
            'hasil_verifikasi' => 'required',
            'dataLevelDua.*' => $checkLevelDua,
            'dataLevelTiga.*' => $checkLevelTiga,
            'dataLevelEmpat.*' => $checkLevelEmpat,
        ],[
            'required' => 'data harus terisi.'
        ]);
        DB::beginTransaction();
        try {
            $addPengajuan = new PengajuanModel;
            $addPengajuan->tanggal = date(now());
            $addPengajuan->status = 'menunggu konfirmasi';
            $addPengajuan->id_cabang = auth()->user()->id_cabang;
            $addPengajuan->save();
            $id_pengajuan = $addPengajuan->id;

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
            $addData->id_pengajuan = $id_pengajuan;
            $addData->id_desa = $request->desa;
            $addData->id_kecamatan = $request->kec;
            $addData->id_kabupaten = $request->kabupaten;
            $addData->save();
            $id_calon_nasabah = $addData->id;


            // $addJawabanLevel = new JawabanPengajuanModel;
            // $addJawabanLevel->id_pengajuan = $id_pengajuan;
            $finalArray = array();
            $rata_rata = array();
            // data Level dua
            if ($request->dataLevelDua != null) {
                foreach ($request->dataLevelDua as $key => $value) {
                    $data_level_dua = $this->getDataLevel($value);
                    $skor[$key] = $data_level_dua[0];
                    $id_jawaban[$key] = $data_level_dua[1];
                    array_push($rata_rata,$skor[$key]);
                    array_push($finalArray, array(
                        'id_pengajuan'=> $id_pengajuan,
                        'id_jawaban'=> $id_jawaban[$key],
                        'skor'=> $skor[$key],
                        'created_at' => date("Y-m-d H:i:s"),)
                    );
                }
                // return $skor[$key];
            }

            // data level tiga
            if ($request->dataLevelTiga != null) {
                foreach ($request->dataLevelTiga as $key => $value) {
                    $data_level_tiga = $this->getDataLevel($value);
                    $skor[$key] = $data_level_tiga[0];
                    $id_jawaban[$key] = $data_level_tiga[1];
                    array_push($rata_rata,$skor[$key]);
                    array_push($finalArray, array(
                        'id_pengajuan'=> $id_pengajuan,
                        'id_jawaban'=> $id_jawaban[$key],
                        'skor'=> $skor[$key],
                        'created_at' => date("Y-m-d H:i:s"),)
                    );

                }
            }

            // data level empat
            if ($request->dataLevelEmpat != null) {
                foreach ($request->dataLevelEmpat as $key => $value) {
                    $data_level_empat = $this->getDataLevel($value);
                    $skor[$key] = $data_level_empat[0];
                    $id_jawaban[$key] = $data_level_empat[1];
                    array_push($rata_rata,$skor[$key]);
                    array_push($finalArray, array(
                        'id_pengajuan'=> $id_pengajuan,
                        'id_jawaban'=> $id_jawaban[$key],
                        'skor'=> $skor[$key],
                        'created_at' => date("Y-m-d H:i:s"),)
                    );

                }
            }
            $average = array_sum($rata_rata)/count($rata_rata);
            $result = round($average,2);
            $status = "";
            $updateData = PengajuanModel::find($id_pengajuan);
            if ($result > 0 && $result <= 1) {
                $status = "merah";
            }elseif($result >= 2 && $result <= 3 ){
                // $updateData->status = "kuning";
                $status = "kuning";
            }elseif($result > 3) {
                $status = "hijau";
            }
            JawabanPengajuanModel::insert($finalArray);
            $updateData->status = $status;
            $updateData->average = $result;
            $updateData->update();
            // Session::put('id',$addData->id);
            DB::commit();
            return redirect()->back()->withStatus('Data berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.' . $e->getMessage());
        }catch(QueryException $e){
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan'. $e->getMessage());
        }
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
    public function getDataLevel($data)
    {
        $data_level = explode('-',$data);
        return $data_level;
    }

    // get detail jawaban dan skor pengajuan
    public function getDetailJawaban($id)
    {
        $param['pageTitle'] = "Dashboard";
        $param['jawabanpengajuan'] = JawabanPengajuanModel::select('jawaban.id','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','option.id as id_option','option.option as name_option','option.id_item','item.id as id_item','item.nama','item.level','item.id_parent')
                                    ->join('option','option.id','jawaban.id_jawaban')
                                    ->join('item','item.id','option.id_item')
                                    ->where('jawaban.id_pengajuan',$id)
                                    ->get();

        return view('pengajuan-kredit.detail-pengajuan-jawaban',$param);
    }
    // insert komentar
    public function getInsertKomentar(Request $request)
    {
       $request->validate([
           'komentar.*' => 'required',
       ]);
        try {
            $addKomentar = new KomentarModel;
            $addKomentar->id_pengajuan = $request->id_pengajuan;
            $addKomentar->save();
            $id_komentar = $addKomentar->id;
            foreach ($request->id_item as $key => $value) {
                $addDetailKomentar = new DetailKomentarModel;
                $addDetailKomentar->id_komentar = $id_komentar;
                $addDetailKomentar->id_user = Auth::user()->id;
                $addDetailKomentar->id_item = $_POST['id_item'][$key];
                $addDetailKomentar->komentar = $_POST['komentar'][$key];
                $addDetailKomentar->save();
            }
            return redirect()->route('pengajuan-kredit.index')->withStatus('Berhasil menambahkan data');
        }catch (Exception $e) {
            return $e;
            return redirect()->back()->withError('Terjadi kesalahan.');
            return $e;
        }catch(QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }
}

