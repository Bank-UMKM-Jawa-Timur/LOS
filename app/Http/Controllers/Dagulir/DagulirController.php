<?php

namespace App\Http\Controllers\Dagulir;

use App\Http\Controllers\Controller;
use App\Http\Requests\DagulirRequestForm;
use App\Models\Cabang;
use App\Models\Desa;
use App\Models\JawabanPengajuanModel;
use App\Models\JawabanTextModel;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\PengajuanDagulir;
use App\Models\PengajuanModel;
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

    private $repo;
    public function __construct()
    {
        $this->repo = new PengajuanDagulirRepository;
    }

    public function index(Request $request)
    {
        // paginate
        $limit = $request->has('page_length') ? $request->get('page_length') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        // search
        $search = $request->get('q');
        $pengajuan_degulir = $this->repo->get($search,$limit,$page);

        // return $pengajuan_degulir;
        return view('dagulir.index',[
            'data' => $pengajuan_degulir
        ]);
    }

    public function create() {
        $itemRepo = new MasterItemRepository;
        $item = $itemRepo->get([13]);
        // return $item;
        $list = list_tipe_pengajuan();
        $jenis_usaha = list_jenis_usaha();
        $list_cabang = Cabang::select('id', 'cabang')
                    ->where('cabang','!=','Kantor Pusat')
                    ->orderBy('id', 'asc')
                    ->get();
        $dataKabupaten = Kabupaten::all();
        return view('dagulir.form.create',[
            'items' => $item,
            'tipe' => $list,
            'list_cabang' => $list_cabang,
            'dataKabupaten' => $dataKabupaten,
            'jenis_usaha' => $jenis_usaha
        ]);
    }

    // function store(DagulirRequestForm $request) {
    public function store(Request $request) {
        try {
            $find = array('Rp.', '.', ',');

            // Jawaban untuk file
            DB::beginTransaction();
            $pengajuan = new PengajuanDagulir;
            $pengajuan->kode_pendaftaran = null;
            $pengajuan->nama = $request->get('nama_lengkap');
            $pengajuan->nik = $request->get('nik');
            $pengajuan->nama_pj_ketua = $request->has('nama_pj') ? $request->has('nama_pj') : null;
            $pengajuan->tempat_lahir = $request->get('tempat_lahir');
            $pengajuan->tanggal_lahir = $request->get('tanggal_lahir');
            $pengajuan->telp = $request->get('telp');
            $pengajuan->jenis_usaha = $request->get('jenis_usaha');
            $pengajuan->nominal = $request->get('nominal_pengajuan');
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
            $pengajuan->tanggal = $request->get('tanggal_pengajuan');
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

    public function getDataLevel($data)
    {
        $data_level = explode('-', $data);
        return $data_level;
    }

    public function review($id)  {
        $pengajuan_degulir = $this->repo->detail($id);
        $itemRepo = new MasterItemRepository;
        $item = $itemRepo->get([13]);
        return view('dagulir.form.review',[
            'data' => $pengajuan_degulir,
            'items' => $item,
        ]);
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

}
