<?php

namespace App\Http\Controllers\Dagulir;

use App\Events\EventMonitoring;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogPengajuanController;
use App\Http\Controllers\PengajuanKreditController;
use App\Http\Requests\DagulirRequestForm;
use App\Models\Cabang;
use App\Models\CalonNasabah;
use App\Models\Desa;
use App\Models\DetailKomentarModel;
use App\Models\JawabanPengajuanModel;
use App\Models\JawabanTextModel;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\KomentarModel;
use App\Models\PendapatPerAspek;
use App\Models\PengajuanDagulir;
use App\Models\PengajuanModel;
use App\Models\User;
use App\Services\TemporaryService;
use Exception;
use App\Repository\MasterItemRepository;
use App\Repository\PengajuanDagulirRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class DagulirController extends Controller
{

    private $logPengajuan;
    private $pengajuanKredit;
    private $repo;
    public function __construct()
    {
        $this->logPengajuan = new LogPengajuanController;
        $this->pengajuanKredit = new PengajuanKreditController;
        $this->repo = new PengajuanDagulirRepository;
    }

    public function index(Request $request)
    {
        $id_cabang = Auth::user()->id_cabang;
        $param['cabang'] = DB::table('cabang')
            ->get();
        $role = auth()->user()->role;
        // paginate
        $search = $request->get('q');
        $limit = $request->has('page_length') ? $request->get('page_length') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        if ($role == 'Staf Analis Kredit') {
            $pengajuan_dagulir = $this->repo->get($search,$limit,$page, 'Staf Analis Kredit');
        } elseif ($role == 'Penyelia Kredit') {
            $pengajuan_dagulir = $this->repo->get($search,$limit,$page, 'Penyelia Kredit');
        } elseif ($role == 'Pincab') {
            $pengajuan_dagulir = $this->repo->get($search,$limit,$page, 'Pincab');
        } else {
            $pengajuan_dagulir = $this->repo->get($search,$limit,$page, 'Staf Analis Kredit');
        }

        // search

        // return $pengajuan_dagulir;
        return view('dagulir.index',[
            'data' => $pengajuan_dagulir
        ]);
    }

    public function create() {
        $itemRepo = new MasterItemRepository;
        $item = $itemRepo->get([13]);
        $jenis_usaha = config('dagulir.jenis_usaha');
        $tipe = config('dagulir.tipe_pengajuan');

        $dataKabupaten = Kabupaten::all();
        return view('dagulir.form.create',[
            'items' => $item,
            'tipe' => $tipe,
            'dataKabupaten' => $dataKabupaten,
            'jenis_usaha' => $jenis_usaha
        ]);
    }

    // function store(DagulirRequestForm $request) {
    public function store(DagulirRequestForm $request) {
        try {
            $find = array('Rp.', '.', ',');

            // Jawaban untuk file
            DB::beginTransaction();
            $pengajuan = new PengajuanDagulir;
            $pengajuan->kode_pendaftaran = null;
            $pengajuan->nama = $request->get('nama_lengkap');
            $pengajuan->nik = $request->get('nik');
            $pengajuan->nama_pj_ketua = $request->has('nama_pj') ? $request->has('nama_pj') : null;
            $pengajuan->tempat_lahir =  $request->get('tempat_lahir');
            $pengajuan->tanggal_lahir = $request->get('tanggal_lahir');
            $pengajuan->telp = $request->get('telp');
            $pengajuan->jenis_usaha = $request->get('jenis_usaha');
            $pengajuan->nominal =$this->formatNumber($request->get('nominal_pengajuan'));
            $pengajuan->tujuan_penggunaan = $request->get('tujuan_penggunaan');
            $pengajuan->jangka_waktu = $request->get('jangka_waktu');
            $pengajuan->kode_bank_pusat = 1;
            $pengajuan->kode_bank_cabang = auth()->user()->id_cabang;
            $pengajuan->kec_ktp = $request->get('kecamatan_sesuai_ktp');
            $pengajuan->kotakab_ktp = $request->get('kode_kotakab_ktp');
            $pengajuan->alamat_ktp = $request->get('alamat_sesuai_ktp');
            $pengajuan->kec_dom = $request->get('kecamatan_domisili');
            $pengajuan->kotakab_dom = $request->get('kode_kotakab_domisili');
            $pengajuan->alamat_dom = $request->get('alamat_domisili');
            $pengajuan->kec_usaha = $request->get('kecamatan_usaha');
            $pengajuan->kotakab_usaha = $request->get('kode_kotakab_usaha');
            $pengajuan->alamat_usaha = $request->get('alamat_usaha');
            $pengajuan->tipe = $request->get('tipe_pengajuan');
            $pengajuan->npwp = $request->input_text[79][0];
            $pengajuan->jenis_badan_hukum = $request->get('jenis_badan_hukum');
            $pengajuan->tempat_berdiri = $request->get('tempat_berdiri');
            $pengajuan->tanggal_berdiri = $request->get('tanggal_berdiri');
            $pengajuan->tanggal = now();
            $pengajuan->user_id = Auth::user()->id;
            $pengajuan->status = 8;
            $pengajuan->created_at = now();
            $pengajuan->from_apps = 'pincetar';
            $pengajuan->save();

            $addPengajuan = new PengajuanModel();
            $addPengajuan->id_staf = Auth::user()->id;
            $addPengajuan->tanggal = date(now());
            $addPengajuan->posisi = 'Proses Input Data';
            $addPengajuan->id_cabang = auth()->user()->id_cabang;
            $addPengajuan->skema_kredit = 'Dagulir';
            $addPengajuan->dagulir_id = $pengajuan->id;
            $addPengajuan->save();

            // Jawaban input option

            foreach ($request->input_option as $key => $value) {
                $JawabanOption = new JawabanPengajuanModel;
                $JawabanOption->id_pengajuan = $addPengajuan->id;
                $JawabanOption->id_jawaban = $this->getDataLevel($value[0])[0];
                $JawabanOption->skor = $this->getDataLevel($value[0])[1];
                $JawabanOption->save();
            }
            // Jawaban input text, long text, number
            foreach ($request->input_text as $key => $value) {
                $jawabanText = new JawabanTextModel;
                $jawabanText->id_pengajuan = $addPengajuan->id;
                $jawabanText->id_jawaban = $key;
                $jawabanText->opsi_text = str_replace($find, "", $value)[0];
                $jawabanText->save();
            }
            foreach ($request->input_number as $key => $value) {
                $jawabanText = new JawabanTextModel;
                $jawabanText->id_pengajuan = $addPengajuan->id;
                $jawabanText->id_jawaban = $key;
                $jawabanText->opsi_text = str_replace($find, "", $value)[0];
                $jawabanText->save();
            }
            foreach ($request->input_text_long as $key => $value) {
                $jawabanText = new JawabanTextModel;
                $jawabanText->id_pengajuan = $addPengajuan->id;
                $jawabanText->id_jawaban = $key;
                $jawabanText->opsi_text = str_replace($find, "", $value)[0];
                $jawabanText->save();
            }
            // end Jawaban input text, long text, number
            if ($request->has('file')) {
                foreach ($request->file('file') as $key => $value) {
                    $image = $request->file('file')[$key];
                    $imageName = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();

                    $filePath = public_path() . '/upload/' . $addPengajuan->id . '/' .$key;

                    if (!File::isDirectory($filePath)) {
                        File::makeDirectory($filePath, 493, true);
                    }

                    $image->move($filePath, $imageName);

                    $dataJawabanText = new JawabanTextModel;
                    $dataJawabanText->id_pengajuan = $addPengajuan->id;
                    $dataJawabanText->id_jawaban =  $key;
                    $dataJawabanText->opsi_text = $imageName;
                    $dataJawabanText->save();
                }
            }


            DB::commit();
            return redirect()->route('dagulir.index')->withStatus('Berhasil menambahkan pengajuan!');

        } catch (Exception $th) {
            return $th;
            DB::rollback();
        } catch (QueryException $e){
            return $e;
            DB::rollBack();
        }
    }

     // check status penyelia data pengajuan
     public function checkPenyeliaKreditDagulir(Request $request)
     {
         try {
             $statusPenyelia = PengajuanModel::find($request->id_pengajuan);
             if ($statusPenyelia) {
                 $statusPenyelia->posisi = "Review Penyelia";
                 $statusPenyelia->id_penyelia = $request->select_penyelia;
                 $statusPenyelia->update();

                 // Log Pengajuan melanjutkan dan mendapatkan
                //  $nasabah = CalonNasabah::select('id', 'nama')->where('id_pengajuan', $request->id_pengajuan)->first();
                //  $namaNasabah = 'undifined';
                //  if ($nasabah)
                //      $namaNasabah = $nasabah->nama;

                //  $penyelia = User::find($request->select_penyelia);
                //  $this->logPengajuan->store('Staff dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' menindak  lanjuti pengajuan atas nama ' . $namaNasabah . ' ke penyelia dengan NIP ' . $penyelia->nip . ' atas nama ' . $this->getNameKaryawan($penyelia->nip) . ' .', $statusPenyelia->id, Auth::user()->id, Auth::user()->nip);
                //  $this->logPengajuan->store('Penyelia dengan NIP ' . $penyelia->nip . ' atas nama ' . $this->getNameKaryawan($penyelia->nip) . ' menerima data pengajuan atas nama ' . $namaNasabah . ' dari staf dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . '.', $statusPenyelia->id, $penyelia->id, $penyelia->nip);
                 return redirect()->back()->withStatus('Berhasil mengganti posisi.');
             } else {
                 return back()->withError('Data pengajuan tidak ditemukan.');
             }
         } catch (Exception $e) {
             return redirect()->back()->withError('Terjadi kesalahan.');
         } catch (QueryException $e) {
             return redirect()->back()->withError('Terjadi kesalahan');
         }
     }

    // send to pincab
    public function sendToPincab($id)
    {
        try {
            $pengajuan = PengajuanModel::find($id);
            if ($pengajuan) {
                $pincab = User::select('id')
                        ->where('id_cabang', $pengajuan->id_cabang)
                        ->where('role', 'Pincab')
                        ->where('user_dagulir', 1)
                        ->first();
                if ($pincab) {
                    $pengajuan->posisi = "Pincab";
                    $pengajuan->id_pincab = $pincab->id;
                    $pengajuan->update();

                    return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                } else {
                    return back()->withError('User pincab tidak ditemukan pada cabang ini.');
                }
            } else {
                return back()->withError('Data pengajuan tidak ditemukan.');
            }
        } catch (Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }

    public function getDetailJawaban($id)
    {
        $pengajuan = PengajuanModel::with('pendapatPerAspek')->find($id);
        $pengajuan_dagulir = PengajuanDagulir::find($pengajuan->dagulir_id);
        $itemRepo = new MasterItemRepository;
        $item = $itemRepo->getWithJawaban($id, [13]);

        $jenis_usaha = config('dagulir.jenis_usaha');
        $tipe = config('dagulir.tipe_pengajuan');

        $kabupaten_ktp = Kabupaten::select('id','kabupaten')->find($pengajuan_dagulir->kotakab_ktp);
        $kecamatan_ktp = Kecamatan::select('id','kecamatan')->find($pengajuan_dagulir->kec_ktp );
        $kabupaten_dom = Kabupaten::select('id','kabupaten')->find($pengajuan_dagulir->kotakab_dom);
        $kecamatan_dom = Kecamatan::select('id','kecamatan')->find($pengajuan_dagulir->kec_dom );
        $kabupaten_usaha = Kabupaten::select('id','kabupaten')->find($pengajuan_dagulir->kotakab_usaha);
        $kecamatan_usaha = Kecamatan::select('id','kecamatan')->find($pengajuan_dagulir->kec_usaha);

        $dataKabupaten = Kabupaten::all();
        return view('dagulir.form.review',[
            'items' => $item,
            'tipe' => $tipe,
            'dataKabupaten' => $dataKabupaten,
            'jenis_usaha' => $jenis_usaha,
            'dagulir' => $pengajuan_dagulir,
            'pengajuan' => $pengajuan,
            'kabupaten_ktp' => $kabupaten_ktp,
            'kecamatan_ktp' => $kecamatan_ktp,
            'kabupaten_dom' => $kabupaten_dom,
            'kecamatan_dom' => $kecamatan_dom,
            'kabupaten_usaha' => $kabupaten_usaha,
            'kecamatan_usaha' => $kecamatan_usaha,
        ]);
    }

    public function updateReviewPenyelia(Request $request, $id) {
        $role = Auth::user()->role;
        try {
            $finalArray = array();
            $totalDataNull = 0;
            $sum_select = 0;
            foreach ($request->skor_penyelia as $key => $value) {
                if (is_numeric($value)) {
                    array_push($finalArray, [
                        'skor_penyelia' => $value
                    ]);
                    $sum_select += $value;
                } else
                    $totalDataNull++;
            }

            $average = ($sum_select) / (count($request->skor_penyelia) - $totalDataNull);
            $result = round($average, 2);
            $status = "";
            $updateData = PengajuanModel::find($id);
            if ($result > 0 && $result <= 2) {
                $status = "merah";
            } elseif ($result >= 2 && $result <= 3) {
                $status = "kuning";
            } elseif ($result > 3) {
                $status = "hijau";
            } else {
                $status = "merah";
            }
            // Hanya Penyelia saja
            if ($role == 'Penyelia Kredit') {
                foreach ($request->get('option') as $key => $value) {
                    JawabanPengajuanModel::where('id_jawaban', $value)->where('id_pengajuan', $id)
                        ->update([
                            'skor_penyelia' => $request->get('skor_penyelia')[$key] ? $request->get('skor_penyelia')[$key] : null
                        ]);
                }
            }

            $updateData->status = $status;
            $updateData->id_penyelia = auth()->user()->id;
            $updateData->tanggal_review_penyelia = date('Y-m-d');
            if ($role == 'Penyelia Kredit'){
                $updateData->average_by_penyelia = $result;
            }
            $updateData->update();

            // Detail Komentar
            $idKomentar = KomentarModel::where('id_pengajuan', $id)->first();
            $countDK = DetailKomentarModel::where('id_komentar', $idKomentar->id)->count();
            if ($countDK > 0) {
                foreach ($request->option as $key => $value) {
                    $dk = DetailKomentarModel::where('id_komentar', $idKomentar->id)->where('id_user', Auth::user()->id)->where('id_item', $value)->first();
                    if ($dk) {
                        $dk->komentar = $_POST['komentar_penyelia'][$key];
                        $dk->save();
                    }
                }
            } else {
                foreach ($request->option as $key => $value) {
                    if ($value) {
                        $dk = new DetailKomentarModel;
                        $dk->id_komentar = $idKomentar->id;
                        $dk->id_user = Auth::user()->id;
                        $dk->id_item = $value;
                        $dk->komentar = $_POST['komentar_penyelia'][$key];
                        $dk->save();
                    }
                }
            }

            // pendapat penyelia
            // if ($role == 'Penyelia Kredit')
            $countpendapat = PendapatPerAspek::where('id_pengajuan', $id)->where('id_penyelia', Auth::user()->id)->count();
            if ($countpendapat > 0) {
                if ($role == 'Penyelia Kredit') {
                    foreach ($request->get('id_aspek') as $key => $value) {
                        $pendapatperaspekpenyelia = PendapatPerAspek::where('id_pengajuan', $id)->where('id_aspek', $value)->where('id_penyelia', Auth::user()->id)->first();
                        $pendapatperaspekpenyelia->pendapat_per_aspek = $_POST['pendapat_usulan'][$key];
                        $pendapatperaspekpenyelia->save();
                    }
                }
            }else{
                for ($i=0; $i <  count($request->get('id_aspek')); $i++) {
                    $updateKomentar = new PendapatPerAspek();
                    $updateKomentar->id_pengajuan = $id;
                    $updateKomentar->id_penyelia = auth()->user()->id;
                    $updateKomentar->id_aspek = $_POST['id_aspek'][$i];
                    $updateKomentar->pendapat_per_aspek = $_POST['pendapat_usulan'][$i];
                    $updateKomentar->save();
                }

            }
            DB::commit();
            return redirect()->route('dagulir.index')->withStatus('Berhasil Review!');
        } catch (Exception $th) {
            return $th;
            DB::rollback();
        } catch (QueryException $e){
            return $e;
            DB::rollBack();
        }
    }

    public function getDetailJawabanPincab($id)
    {
        $pengajuan = PengajuanModel::with('pendapatPerAspek')->find($id);
        $pengajuan_dagulir = PengajuanDagulir::find($pengajuan->dagulir_id);
        $itemRepo = new MasterItemRepository;
        $item = $itemRepo->getWithJawaban($id, [13]);

        $jenis_usaha = config('dagulir.jenis_usaha');
        $tipe = config('dagulir.tipe_pengajuan');

        $kabupaten_ktp = Kabupaten::select('id','kabupaten')->find($pengajuan_dagulir->kotakab_ktp);
        $kecamatan_ktp = Kecamatan::select('id','kecamatan')->find($pengajuan_dagulir->kec_ktp );
        $kabupaten_dom = Kabupaten::select('id','kabupaten')->find($pengajuan_dagulir->kotakab_dom);
        $kecamatan_dom = Kecamatan::select('id','kecamatan')->find($pengajuan_dagulir->kec_dom );
        $kabupaten_usaha = Kabupaten::select('id','kabupaten')->find($pengajuan_dagulir->kotakab_usaha);
        $kecamatan_usaha = Kecamatan::select('id','kecamatan')->find($pengajuan_dagulir->kec_usaha);

        $dataKabupaten = Kabupaten::all();

        return view('dagulir.form.review-pincab',[
            'items' => $item,
            'tipe' => $tipe,
            'dataKabupaten' => $dataKabupaten,
            'jenis_usaha' => $jenis_usaha,
            'dagulir' => $pengajuan_dagulir,
            'pengajuan' => $pengajuan,
            'kabupaten_ktp' => $kabupaten_ktp,
            'kecamatan_ktp' => $kecamatan_ktp,
            'kabupaten_dom' => $kabupaten_dom,
            'kecamatan_dom' => $kecamatan_dom,
            'kabupaten_usaha' => $kabupaten_usaha,
            'kecamatan_usaha' => $kecamatan_usaha,
        ]);
    }

    public function updateReviewPincab(Request $request, $id) {
        DB::beginTransaction();
        try {
            $dagulir = PengajuanDagulir::find($id);
            if ($dagulir) {
                $pengajuan = PengajuanModel::where('dagulir_id', $dagulir->id)->first();
                if ($pengajuan) {
                    $pengajuan->id_pincab = auth()->user()->id;
                    $pengajuan->tanggal_review_pincab = date('Y-m-d');
                    $pengajuan->save();

                    $idKomentar = KomentarModel::where('id_pengajuan', $pengajuan->id)->first();
                    KomentarModel::where('id', $idKomentar->id)->update(
                        [
                            'komentar_pincab' => $request->pendapat,
                            'id_pincab' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                    // Log Pengajuan review
                    $nasabah = CalonNasabah::select('id', 'nama')->where('id_pengajuan', $request->id_pengajuan)->first();
                    // $nasabah->nominal_realisasi = $request->get('nominal_realisasi');
                    // $nasabah->update();

                    $namaNasabah = 'undifined';

                    if ($nasabah)
                        $namaNasabah = $nasabah->nama;

                    $this->logPengajuan->store('Pincab dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->pengajuanKredit->getNameKaryawan(Auth::user()->nip) . ' melakukan review terhadap pengajuan atas nama ' . $namaNasabah, $pengajuan->id, Auth::user()->id, Auth::user()->nip);

                    DB::commit();
                    return redirect()->route('dagulir.index')->withStatus('Berhasil mereview!');
                }
                else {
                    return redirect()->route('dagulir.index')->withError('Data pengajuan tidak ditemukan');
                }
            }
            else {
                return redirect()->route('dagulir.index')->withError('Data pengajuan tidak ditemukan');
            }
        } catch (Exception $e) {
            return $e->getMessage();
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return $e->getMessage();
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }

    public function updateReview(Request $request) {
        $statusSlik = false;
        $findRupiah = array('Rp ', '.', ',') ;
        $request->validate([
            ''
        ]);
        try {
            DB::beginTransaction();
            $updatePengajuan = PengajuanModel::where('dagulir_id',$request->get('dagulir_id'))->first();
            $updatePengajuan->progress_pengajuan_data = $request->progress;
            $updatePengajuan->tanggal_review_penyelia = date(now());
            $updatePengajuan->update();

            // Tempory
            $tempNasabah = TemporaryService::getNasabahData($request->idCalonNasabah);
            DB::table('temporary_calon_nasabah')
                ->where('id_user', $request->user()->id)
                ->first('id_user');

        } catch (Exception $e) {
            //throw $th;
        }
    }

    public function formatNumber($param)
    {
        return (int)str_replace('.', '', $param);
    }

    public function accPengajuan($id)
    {
        $statusPincab = PengajuanModel::find($id);
        $komentarPincab = KomentarModel::where('id_pengajuan', $id)->first();
        if (auth()->user()->role == 'Pincab') {
            if ($komentarPincab->komentar_pincab != null) {
                $statusPincab->posisi = "Selesai";
                $statusPincab->tanggal_review_pincab = date(now());
                $statusPincab->update();

                // $nasabah = CalonNasabah::select('id', 'nama')->where('id_pengajuan', $id)->first();
                // $namaNasabah = 'undifined';
                // if ($nasabah)
                //     $namaNasabah = $nasabah->nama;

                // $this->logPengajuan->store('Pincab dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->pengajuanKredit->getNameKaryawan(Auth::user()->nip) . ' menyetujui pengajuan atas nama ' . $namaNasabah . '.', $id, Auth::user()->id, Auth::user()->nip);

                event(new EventMonitoring('menyetujui pengajuan'));

                return redirect()->back()->withStatus('Berhasil mengganti posisi.');
            } else {
                return redirect()->back()->withError('Belum di review Pincab.');
            }
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }

    public function decPengajuan($id)
    {
        $statusPincab = PengajuanModel::find($id);
        $komentarPincab = KomentarModel::where('id_pengajuan', $id)->first();
        if (auth()->user()->role == 'Pincab') {
            if ($komentarPincab->komentar_pincab != null) {
                $statusPincab->posisi = "Ditolak";
                $statusPincab->tanggal_review_pincab = date(now());
                $statusPincab->update();

                // $nasabah = CalonNasabah::select('id', 'nama')->where('id_pengajuan', $id)->first();
                // $namaNasabah = 'undifined';
                // if ($nasabah)
                //     $namaNasabah = $nasabah->nama;

                // $this->logPengajuan->store('Pincab dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->pengajuanKredit->getNameKaryawan(Auth::user()->nip) . ' menolak pengajuan atas nama ' . $namaNasabah . '.', $id, Auth::user()->id, Auth::user()->nip);
                event(new EventMonitoring('tolak pengajuan'));
                return redirect()->back()->withStatus('Berhasil mengganti posisi.');
            } else {
                return redirect()->back()->withError('Belum di review Pincab.');
            }
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }

    public function storeSipde(Request $request) {
        $pengajuan = PengajuanModel::with('pendapatPerAspek')->find($request->id_dagulir);
        $pengajuan_dagulir = PengajuanDagulir::find($pengajuan->dagulir_id);
        $data = sipde_token();
        $body = [
            "nama" => $pengajuan_dagulir->nama,
            "nik" => $pengajuan_dagulir->nik,
            "tempat_lahir" => $pengajuan_dagulir->tempat_lahir,
            "tanggal_lahir" => $pengajuan_dagulir->tanggal_lahir,
            "telp" => $pengajuan_dagulir->telp,
            "jenis_usaha" => $pengajuan_dagulir->jenis_usaha,
            "nominal_pengajuan" => $this->formatNumber($request->nominal_realisasi),
            "tujuan_penggunaan" => $pengajuan_dagulir->tujuan_penggunaan,
            "jangka_waktu" => intval($request->get('jangka_waktu')),
            "ket_agunan" => 'BPKB',
            "kode_bank_pusat" => '01-BPR',
            "kode_bank_cabang" => $pengajuan_dagulir->kode_bank_cabang,
            "kecamatan_sesuai_ktp" => $pengajuan_dagulir->kec_ktp,
            "kode_kotakab_ktp" => $pengajuan_dagulir->kotakab_ktp,
            "alamat_sesuai_ktp" => $pengajuan_dagulir->alamat_ktp,
            "kecamatan_domisili" => $pengajuan_dagulir->kec_dom ,
            "kode_kotakab_domisili" => $pengajuan_dagulir->kotakab_dom,
            "alamat_domisili" => $pengajuan_dagulir->alamat_dom,
            "kecamatan_usaha" => $pengajuan_dagulir->kec_usaha,
            "kode_kotakab_usaha" => $pengajuan_dagulir->kotakab_usaha ,
            "alamat_usaha" => $pengajuan_dagulir->alamat_usaha,
            "tipe_pengajuan" => $pengajuan_dagulir->tipe,
            "npwp" => $pengajuan_dagulir->npwp,
            // "jenis_badan_hukum" => $pengajuan_dagulir->jenis_badan_hukum,
            "jenis_badan_hukum" => "Berbadan Hukum",
            "tempat_berdiri" => $pengajuan_dagulir->tempat_berdiri,
            "tanggal_berdiri" => $pengajuan_dagulir->tanggal_berdiri,
            "email" => $pengajuan_dagulir->email,
            "nama_pj" => $pengajuan_dagulir->nama_pj_ketua ??  null,
        ];
        $pengajuan_dagulir = Http::withHeaders([
            'Authorization' => 'Bearer ' .$data['token'],
        ])->post(config('dagulir.host').'/pengajuan.json', $body)->json();

        if (array_key_exists('data', $pengajuan_dagulir)) {
            $update_pengajuan_dagulir = PengajuanDagulir::find($pengajuan->dagulir_id);
            $update_pengajuan_dagulir->kode_pendaftaran = $pengajuan_dagulir['data']['kode_pendaftaran'];
            $update_pengajuan_dagulir->nominal_realisasi = $this->formatNumber($request->nominal_realisasi);
            $update_pengajuan_dagulir->jangka_waktu = $request->jangka_waktu;
            $update_pengajuan_dagulir->status = 1;
            $update_pengajuan_dagulir->update();

            return redirect()->route('dagulir.index')->withStatus('Berhasil mengirimkan data.');
        }
        else {
            $message = 'Terjadi kesalahan.';
            if (array_key_exists('error', $pengajuan_dagulir)) $message .= ' '.$pengajuan_dagulir['error'];

            return redirect()->route('dagulir.index')->withError($message);
        }
    }

    public function updateStatus($kode_pendaftaran, $status, $lampiran_analisa = null, $jangka_waktu, $realisasi_dana) {
        $data = sipde_token();
        $pengajuan_dagulir = Http::withHeaders([
            'Authorization' => 'Bearer ' .$data['token'],
        ])->post(env('SIPDE_HOST').'/update_status.json',[
            "kode_pendaftaran" => $kode_pendaftaran,
            "status" => $status,
            "lampiran_analisa" => $lampiran_analisa,
            "jangka_waktu" => $jangka_waktu,
            "realisasi_dana" => $realisasi_dana
        ])->json();
        return $pengajuan_dagulir;
    }
    public function getDataLevel($data)
    {
        $data_level = explode('-', $data);
        return $data_level;
    }

}
