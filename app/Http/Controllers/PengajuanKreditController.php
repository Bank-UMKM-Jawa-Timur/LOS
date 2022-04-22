<?php

namespace App\Http\Controllers;

use App\Models\CalonNasabah;
use App\Models\Desa;
use App\Models\DetailKomentarModel;
use App\Models\ItemModel;
use App\Models\JawabanPengajuanModel;
use App\Models\JawabanTextModel;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\KomentarModel;
use App\Models\PengajuanModel;
use DateTime;
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
        $id_cabang = Auth::user()->id_cabang;
        if (auth()->user()->role == 'Staf Analis Kredit') {
            $param['pageTitle'] = 'Tambah Pengajuan Kredit';
            $param['btnText'] = 'Tambah Pengajuan';
            $param['btnLink'] = route('pengajuan-kredit.create');
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->get();
            // return view('pengajuan-kredit.add-pengajuan-kredit',$param);
            return view('pengajuan-kredit.list-edit-pengajuan-kredit', $param);
        } elseif (auth()->user()->role == 'Penyelia Kredit') {
            // $param['dataAspek'] = ItemModel::select('*')->where('level',1)->get();

            $id_cabang = Auth::user()->id_cabang;
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->get();
            return view('pengajuan-kredit.list-pengajuan-kredit', $param);
        } elseif (auth()->user()->role == 'Pincab') {
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', Auth::user()->id_cabang)
                ->get();
            return view('pengajuan-kredit.komentar-pincab-pengajuan', $param);
        } else {
            $id_cabang = Auth::user()->id_cabang;
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->get();
            return view('pengajuan-kredit.komentar-pincab-pengajuan', $param);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $param['pageTitle'] = "Dashboard";

        $param['dataDesa'] = Desa::all();
        $param['dataKecamatan'] = Kecamatan::all();
        $param['dataKabupaten'] = Kabupaten::all();
        $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->get();

        $data['dataPertanyaanSatu'] = ItemModel::select('id', 'nama', 'level', 'id_parent')->where('level', 2)->where('id_parent', 3)->get();

        return view('pengajuan-kredit.add-pengajuan-kredit', $param);
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
        // $checkLevelDua = $request->dataLevelDua != null ? 'required' : '';
        // $checkLevelTiga = $request->dataLevelTiga != null ? 'required' : '';
        // $checkLevelEmpat = $request->dataLevelEmpat != null ? 'required' : '';
        $request->validate([
            'name' => 'required',
            'alamat_rumah' => 'required',
            'alamat_usaha' => 'required',
            'no_ktp' => 'required|unique:calon_nasabah,no_ktp|max:16',
            'kabupaten' => 'required',
            'kec' => 'required',
            'desa' => 'required',
            'kabupaten' => 'required',
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
            // 'dataLevelDua.*' => $checkLevelDua,
            // 'dataLevelTiga.*' => $checkLevelTiga,
            // 'dataLevelEmpat.*' => $checkLevelEmpat,
        ], [
            'required' => 'data harus terisi.'
        ]);
        DB::beginTransaction();
        try {
            $addPengajuan = new PengajuanModel;
            $addPengajuan->tanggal = date(now());
            $addPengajuan->id_cabang = auth()->user()->id_cabang;
            $addPengajuan->progress_pengajuan_data = $request->progress;
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

            if ($request->opsi_jawaban != 'input text') {
                foreach ($request->id_level as $key => $value) {
                    $dataJawabanText = new JawabanTextModel;
                    $dataJawabanText->id_pengajuan = $id_pengajuan;
                    $dataJawabanText->id_jawaban = $request->get('id_level')[$key];
                    $dataJawabanText->opsi_text = $request->get('informasi')[$key];
                    $dataJawabanText->save();
                }
            } else {
            }

            $finalArray = array();
            $rata_rata = array();
            // data Level dua
            if ($request->dataLevelDua != null) {
                $data = $request->dataLevelDua;
                $result_dua = array_values(array_filter($data));
                foreach ($result_dua as $key => $value) {
                    $data_level_dua = $this->getDataLevel($value);
                    $skor[$key] = $data_level_dua[0];
                    $id_jawaban[$key] = $data_level_dua[1];
                    array_push($rata_rata, $skor[$key]);
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'created_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }

            // data level tiga
            if ($request->dataLevelTiga != null) {
                $data = $request->dataLevelTiga;
                $result_tiga = array_values(array_filter($data));
                foreach ($result_tiga as $key => $value) {
                    $data_level_tiga = $this->getDataLevel($value);
                    $skor[$key] = $data_level_tiga[0];
                    $id_jawaban[$key] = $data_level_tiga[1];
                    array_push($rata_rata, $skor[$key]);
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'created_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }

            // data level empat
            if ($request->dataLevelEmpat != null) {
                $data = $request->dataLevelEmpat;
                $result_empat = array_values(array_filter($data));
                foreach ($result_empat as $key => $value) {
                    $data_level_empat = $this->getDataLevel($value);
                    $skor[$key] = $data_level_empat[0];
                    $id_jawaban[$key] = $data_level_empat[1];
                    array_push($rata_rata, $skor[$key]);
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'created_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }
            $average = array_sum($rata_rata) / count($rata_rata);
            $result = round($average, 2);
            $status = "";
            $updateData = PengajuanModel::find($id_pengajuan);
            if ($result > 0 && $result <= 1) {
                $status = "merah";
            } elseif ($result >= 2 && $result <= 3) {
                // $updateData->status = "kuning";
                $status = "kuning";
            } elseif ($result > 3) {
                $status = "hijau";
            } else {
                $status = "merah";
            }
            for ($i = 0; $i < count($finalArray); $i++) {
                JawabanPengajuanModel::insert($finalArray[$i]);
            }

            $updateData->posisi = 'Proses Input Data';
            $updateData->status_by_sistem = $status;
            $updateData->average_by_sistem = $result;
            $updateData->update();
            // Session::put('id',$addData->id);
            DB::commit();
            return redirect()->route('pengajuan-kredit.index')->withStatus('Data berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.' . $e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan' . $e->getMessage());
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

        $param['pageTitle'] = "Dashboard";

        $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->get();

        $data['dataPertanyaanSatu'] = ItemModel::select('id', 'nama', 'level', 'id_parent')->where('level', 2)->where('id_parent', 3)->get();

        $param['dataUmum'] = PengajuanModel::select(
            'pengajuan.id',
            'pengajuan.tanggal',
            'pengajuan.posisi',
            'pengajuan.tanggal_review_penyelia',
            'calon_nasabah.id as id_calon_nasabah',
            'calon_nasabah.nama',
            'calon_nasabah.alamat_rumah',
            'calon_nasabah.alamat_usaha',
            'calon_nasabah.no_ktp',
            'calon_nasabah.tempat_lahir',
            'calon_nasabah.tanggal_lahir',
            'calon_nasabah.status',
            'calon_nasabah.sektor_kredit',
            'calon_nasabah.jenis_usaha',
            'calon_nasabah.jumlah_kredit',
            'calon_nasabah.tujuan_kredit',
            'calon_nasabah.jaminan_kredit',
            'calon_nasabah.hubungan_bank',
            'calon_nasabah.hubungan_bank',
            'calon_nasabah.verifikasi_umum',
            'calon_nasabah.id_kabupaten',
            'calon_nasabah.id_kecamatan',
            'calon_nasabah.id_desa'
        )
            ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
            ->find($id);
        $param['allKab'] = Kabupaten::get();
        $param['allKec'] = Kecamatan::where('id_kabupaten', $param['dataUmum']->id_kabupaten)->get();
        $param['allDesa'] = Desa::where('id_kecamatan', $param['dataUmum']->id_kecamatan)->get();
        // 'jawaban.id as id_jawaban','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','jawaban.skor_penyelia'

        // return $param['jawabanpengajuan'] = JawabanPengajuanModel::select('jawaban.id','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','option.id as id_option','option.option as name_option','option.id_item','item.id as id_item','item.nama','item.level','item.id_parent')
        //                             ->join('option','option.id','jawaban.id_jawaban')
        //                             ->join('item','item.id','option.id_item')
        //                             ->where('jawaban.id_pengajuan',$id)
        //                             ->get();

        return view('pengajuan-kredit.edit-pengajuan-kredit', $param);
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
        $request->validate([
            'name' => 'required',
            'alamat_rumah' => 'required',
            'alamat_usaha' => 'required',
            'no_ktp' => 'required|max:16',
            'kabupaten' => 'required',
            'kec' => 'required',
            'desa' => 'required',
            'kabupaten' => 'required',
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
            // 'dataLevelDua.*' => $checkLevelDua,
            // 'dataLevelTiga.*' => $checkLevelTiga,
            // 'dataLevelEmpat.*' => $checkLevelEmpat,
        ], [
            'required' => 'data harus terisi.'
        ]);
        DB::beginTransaction();
        try {
            $updatePengajuan = PengajuanModel::find($id);
            $updatePengajuan->tanggal = date(now());
            $updatePengajuan->id_cabang = auth()->user()->id_cabang;
            $updatePengajuan->progress_pengajuan_data = $request->progress;
            $updatePengajuan->save();
            $id_pengajuan = $updatePengajuan->id;

            $updateData = CalonNasabah::find($request->id_nasabah);
            $updateData->nama = $request->name;
            $updateData->alamat_rumah = $request->alamat_rumah;
            $updateData->alamat_usaha = $request->alamat_usaha;
            $updateData->no_ktp = $request->no_ktp;
            $updateData->tempat_lahir = $request->tempat_lahir;
            $updateData->tanggal_lahir = $request->tanggal_lahir;
            $updateData->status = $request->status;
            $updateData->sektor_kredit = $request->sektor_kredit;
            $updateData->jenis_usaha = $request->jenis_usaha;
            $updateData->jumlah_kredit = $request->jumlah_kredit;
            $updateData->tujuan_kredit = $request->tujuan_kredit;
            $updateData->jaminan_kredit = $request->jaminan;
            $updateData->hubungan_bank = $request->hubungan_bank;
            $updateData->verifikasi_umum = $request->hasil_verifikasi;
            $updateData->id_user = auth()->user()->id;
            $updateData->id_pengajuan = $id_pengajuan;
            $updateData->id_desa = $request->desa;
            $updateData->id_kecamatan = $request->kec;
            $updateData->id_kabupaten = $request->kabupaten;
            $updateData->save();
            $id_calon_nasabah = $updateData->id;


            // $addJawabanLevel = new JawabanPengajuanModel;
            // $addJawabanLevel->id_pengajuan = $id_pengajuan;
            $finalArray = array();
            $rata_rata = array();
            // data Level dua
            if ($request->dataLevelDua != null) {
                $data = $request->dataLevelDua;
                $result_dua = array_values(array_filter($data));
                foreach ($result_dua as $key => $value) {
                    $data_level_dua = $this->getDataLevel($value);
                    $skor[$key] = $data_level_dua[0];
                    $id_jawaban[$key] = $data_level_dua[1];
                    array_push($rata_rata, $skor[$key]);
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'updated_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }

            // data level tiga
            if ($request->dataLevelTiga != null) {
                $data = $request->dataLevelTiga;
                $result_tiga = array_values(array_filter($data));
                foreach ($result_tiga as $key => $value) {
                    $data_level_tiga = $this->getDataLevel($value);
                    $skor[$key] = $data_level_tiga[0];
                    $id_jawaban[$key] = $data_level_tiga[1];
                    array_push($rata_rata, $skor[$key]);
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'updated_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }

            // data level empat
            if ($request->dataLevelEmpat != null) {
                $data = $request->dataLevelEmpat;
                $result_empat = array_values(array_filter($data));
                foreach ($result_empat as $key => $value) {
                    $data_level_empat = $this->getDataLevel($value);
                    $skor[$key] = $data_level_empat[0];
                    $id_jawaban[$key] = $data_level_empat[1];
                    array_push($rata_rata, $skor[$key]);
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'updated_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }
            $average = array_sum($rata_rata) / count($rata_rata);
            $result = round($average, 2);
            $status = "";
            $updateData = PengajuanModel::find($id_pengajuan);
            if ($result > 0 && $result <= 1) {
                $status = "merah";
            } elseif ($result >= 2 && $result <= 3) {
                // $updateData->status = "kuning";
                $status = "kuning";
            } elseif ($result > 3) {
                $status = "hijau";
            } else {
                $status = "merah";
            }
            // return $request;
            for ($i = 0; $i < count($finalArray); $i++) {
                /*
                1. variabel a = query select k table jawaban where(id, id_jawaban)
                2. jika variabel a itu ada maka proses update
                3. jika variabel a itu null maka insert / data baru
                */
                $data = DB::table('jawaban');

                if (!empty($request->id[$i])) {
                    $data->where('id', $request->id[$i])->update($finalArray[$i]);
                } else {
                    $data->insert($finalArray[$i]);
                }
                // $data = DB::table('jawaban')
                //         ->where('id',$request->id[$i]);
            }
            // for ($i=0; $i < count($finalArray); $i++) {
            //     DB::table('jawaban')
            //         ->where('id',$request->id[$i])
            //         ->update($finalArray[$i]);
            //     // JawabanPengajuanModel::whereIn('id',$request->id[$i])->update($finalArray[$i]);
            // }

            $updateData->posisi = 'Proses Input Data';
            $updateData->status_by_sistem = $status;
            $updateData->average_by_sistem = $result;
            $updateData->update();
            // Session::put('id',$addData->id);
            DB::commit();
            return redirect()->route('pengajuan-kredit.index')->withStatus('Berhasil mengganti data.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.' . $e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan' . $e->getMessage());
        }
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
        $kecamatan = Kecamatan::where("id_kabupaten", $request->kabID)->pluck('id', 'kecamatan');
        return response()->json($kecamatan);
    }
    public function getdesa(Request $request)
    {
        $desa = Desa::where("id_kecamatan", $request->kecID)->pluck('id', 'desa');
        return response()->json($desa);
    }
    public function getDataLevel($data)
    {
        $data_level = explode('-', $data);
        return $data_level;
    }

    // get detail jawaban dan skor pengajuan
    public function getDetailJawaban($id)
    {
        if (auth()->user()->role == 'Penyelia Kredit') {
            $param['pageTitle'] = "Dashboard";
            $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->get();
            $param['dataUmum'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia')
                ->find($id);

            // $param['jawabanpengajuan'] = JawabanPengajuanModel::select('jawaban.id','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','option.id as id_option','option.option as name_option','option.id_item','item.id as id_item','item.nama','item.level','item.id_parent')
            //                             ->join('option','option.id','jawaban.id_jawaban')
            //                             ->join('item','item.id','option.id_item')
            //                             ->where('jawaban.id_pengajuan',$id)
            //                             ->get();

            return view('pengajuan-kredit.detail-pengajuan-jawaban', $param);
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    // insert komentar
    public function getInsertKomentar(Request $request)
    {
        // return $request;
        $request->validate([
            // 'komentar_penyelia_text.*'=> 'required',
            'komentar_penyelia.*' => 'required',
            'skor_penyelia.*' => 'required',
        ]);
        try {
            $finalArray = array();
            $finalArray_text = array();

            foreach ($request->skor_penyelia as $key => $value) {
                array_push($finalArray, [
                    'skor_penyelia' => $value
                ]);
            };
            foreach ($request->skor_penyelia_text as $key => $value) {
                array_push($finalArray_text, [
                    'skor_penyelia' => $value
                ]);
            }
            // return $finalArray_text;
            $sum_select = array_sum($request->skor_penyelia);
            $sum_text = array_sum($request->skor_penyelia_text);
            $average = ($sum_select + $sum_text) / count($request->skor_penyelia);
            $result = round($average, 2);
            $status = "";
            $updateData = PengajuanModel::find($request->id_pengajuan);
            if ($result > 0 && $result <= 1) {
                $status = "merah";
            } elseif ($result >= 2 && $result <= 3) {
                $status = "kuning";
            } elseif ($result > 3) {
                $status = "hijau";
            } else {
                $status = "merah";
            }
            for ($i = 0; $i < count($finalArray); $i++) {
                JawabanPengajuanModel::where('id', $request->id_jawaban[$i])->update($finalArray[$i]);
            }
            for ($i = 0; $i < count($finalArray_text); $i++) {
                JawabanTextModel::where('id', $request->id_jawaban_text[$i])->update($finalArray_text[$i]);
            }
            $updateData->status = $status;
            $updateData->average_by_penyelia = $result;
            $updateData->update();

            $addKomentar = new KomentarModel;
            $addKomentar->id_pengajuan = $request->id_pengajuan;
            $addKomentar->save();
            $id_komentar = $addKomentar->id;
            foreach ($request->id as $key => $value) {
                $addDetailKomentar = new DetailKomentarModel;
                $addDetailKomentar->id_komentar = $id_komentar;
                $addDetailKomentar->id_user = Auth::user()->id;
                $addDetailKomentar->id_item = $_POST['id'][$key];
                $addDetailKomentar->komentar = $_POST['komentar_penyelia'][$key];
                $addDetailKomentar->save();
            }
            return redirect()->route('pengajuan-kredit.index')->withStatus('Berhasil menambahkan data');
        } catch (Exception $e) {
            return $e;
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return $e;
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }

    // check status penyelia data pengajuan
    public function checkPenyeliaKredit($id)
    {
        try {
            $statusPenyelia = PengajuanModel::find($id);
            $statusPenyelia->posisi = "Review Penyelia";
            $statusPenyelia->tanggal_review_penyelia = date(now());
            $statusPenyelia->update();
            return redirect()->back()->withStatus('Berhasil mengganti posisi.');
        } catch (Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }

    // check status pincab
    public function checkPincab($id)
    {
        if (auth()->user()->role == 'Penyelia Kredit') {
            $dataPenyelia = PengajuanModel::find($id);
            $status = $dataPenyelia->status;
            if ($status != null) {
                $dataPenyelia->tanggal_review_pincab = date(now());
                $dataPenyelia->posisi = "Pincab";
                $dataPenyelia->update();
                return redirect()->back()->withStatus('Berhasil mengganti posisi.');
            } else {
                return redirect()->back()->withError('Belum di review Penyelia.');
            }
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    // check status pincab
    public function checkPincabStatus()
    {
        if (auth()->user()->role == "Pincab") {
            $param['pageTitle'] = "Dashboard";
            $id_cabang = Auth::user()->id_cabang;
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->get();
            return view('pengajuan-kredit.komentar-pincab-pengajuan', $param);
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    public function checkPincabStatusDetail($id)
    {

        $param['pageTitle'] = "Dashboard";
        $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->get();
        // $param['jawabanpengajuan'] = JawabanPengajuanModel::select('jawaban.id','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','option.id as id_option','option.option as name_option','option.id_item','item.id as id_item','item.nama','item.level','item.id_parent')
        //                             ->join('option','option.id','jawaban.id_jawaban')
        //                             ->join('item','item.id','option.id_item')
        //                             ->where('jawaban.id_pengajuan',$id)
        //                             ->get();
        $param['dataNasabah'] = CalonNasabah::select('calon_nasabah.*', 'kabupaten.id as kabupaten_id', 'kabupaten.kabupaten', 'kecamatan.id as kecamatan_id', 'kecamatan.id_kabupaten', 'kecamatan.kecamatan', 'desa.id as desa_id', 'desa.id_kabupaten', 'desa.id_kecamatan', 'desa.desa')
            ->join('kabupaten', 'kabupaten.id', 'calon_nasabah.id_kabupaten')
            ->join('kecamatan', 'kecamatan.id', 'calon_nasabah.id_kecamatan')
            ->join('desa', 'desa.id', 'calon_nasabah.id_desa')
            ->where('calon_nasabah.id_pengajuan', $id)
            ->first();
        $param['dataUmum'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia')
            ->find($id);
        $param['comment'] = KomentarModel::where('id_pengajuan', $id)->first();
        // $param['jawabanpengajuan'] = JawabanPengajuanModel::select('jawaban.id','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','option.id as id_option','option.option as name_option','option.id_item','item.id as id_item','item.nama','item.level','item.id_parent')
        //                             ->join('option','option.id','jawaban.id_jawaban')
        //                             ->join('item','item.id','option.id_item')
        //                             ->where('jawaban.id_pengajuan',$id)
        //                             ->get();

        return view('pengajuan-kredit.detail-komentar-pengajuan', $param);
    }
    public function checkPincabStatusDetailPost(Request $request)
    {
        try {
            // $updateData = PengajuanModel::find($request->id_pengajuan);
            // $updateData->update();
            $addKomentar = new KomentarModel;
            $addKomentar->id_pengajuan = $request->id_pengajuan;
            // $addKomentar->komentar_pincab = $request->komentar;
            $addKomentar->save();
            $id_komentar = $addKomentar->id;
            foreach ($request->get('id') as $key => $value) {
                $addDetailKomentar = new DetailKomentarModel;
                $addDetailKomentar->id_komentar = $id_komentar;
                $addDetailKomentar->id_user = Auth::user()->id;
                $addDetailKomentar->id_item = $request->get('id')[$key];
                $addDetailKomentar->komentar = $request->get('komentar');
                $addDetailKomentar->save();
            }

            return redirect('/pengajuan-kredit')->withStatus('Berhasil menambahkan komentar');
        } catch (Exception $e) {
            return $e;
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return $e;
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }
    public function checkPincabStatusChange($id)
    {
        $statusPincab = PengajuanModel::find($id);
        $review_pincab = $statusPincab->tanggal_review_pincab;
        if (auth()->user()->role == 'Pincab') {
            if ($review_pincab != null) {
                $statusPincab->posisi = "Selesai";
                $statusPincab->tanggal_review_pincab = date(now());
                $statusPincab->update();
                return redirect()->back()->withStatus('Berhasil mengganti posisi.');
            } else {
                return redirect()->back()->withError('Belum di review Pincab.');
            }
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    // check status staf analisa
    public function checkStafAnalisa($id)
    {
        if (auth()->user()->role == 'Staf Analis Kredit ') {
            $statusPenyelia = PengajuanModel::find($id);
            $statusPenyelia->posisi = "Review Penyelia";
            $statusPenyelia->update();
            return redirect()->back()->withStatus('Berhasil mengganti posisi.');
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
}
