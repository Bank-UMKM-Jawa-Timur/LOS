<?php

namespace App\Http\Controllers\Dagulir;

use App\Http\Controllers\Controller;
use App\Http\Requests\DagulirRequestForm;
use App\Models\Cabang;
use App\Models\Desa;
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

        return view('dagulir.index',[
            'data' => $pengajuan_degulir
        ]);
    }

    public function create() {
        $itemRepo = new MasterItemRepository;
        $item = $itemRepo->get([13]);
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

    function store(DagulirRequestForm $request) {
        try {
            $data = sipde_token();
            DB::beginTransaction();
            $pengajuan_degulir = Http::withHeaders([
                'Authorization' => 'Bearer ' .$data['token'],
            ])->post(env('SIPDE_HOST').'/pengajuan.json',[
                "nama" => $request->get('nama_lengkap'),
                "nik" => $request->get('nik'),
                "tempat_lahir" => $request->get('tempat_lahir'),
                "tanggal_lahir" => $request->get('tanggal_lahir'),
                "telp" =>  $request->get('telp'),
                "jenis_usaha" =>  $request->get('jenis_usaha'),
                "nominal_pengajuan" => $request->get('nominal_pengajuan'),
                "tujuan_penggunaan" => $request->get('tujuan_penggunaan'),
                "jangka_waktu" =>  $request->get('jangka_waktu'),
                "ket_agunan" =>  $request->get('ket_agunan'),
                "kode_bank_pusat" =>  '01-BPR',
                "kode_bank_cabang" =>  $request->get('kode_bank_cabang'),
                "kecamatan_sesuai_ktp" => $request->get('kecamatan_sesuai_ktp'),
                "kode_kotakab_ktp" => $request->get('kode_kotakab_ktp'),
                "alamat_sesuai_ktp" => $request->get('alamat_sesuai_ktp'),
                "kecamatan_domisili" => $request->get('kecamatan_domisili'),
                "kode_kotakab_domisili" => $request->get('kode_kotakab_domisili'),
                "alamat_domisili" =>  $request->get('alamat_domisili'),
                "kecamatan_usaha" =>  $request->get('kecamatan_usaha'),
                "kode_kotakab_usaha" =>  $request->get('kode_kotakab_usaha'),
                "alamat_usaha" =>  $request->get('alamat_usaha'),
                "tipe_pengajuan" =>  $request->get('tipe_pengajuan'),
                "npwp" =>  $request->get('npwp'),
                "jenis_badan_hukum" =>  $request->get('jenis_badan_hukum'),
                "tempat_berdiri" =>  $request->get('tempat_berdiri'),
                "tanggal_berdiri" =>  $request->get('tanggal_berdiri'),
                "email" =>  $request->get('email'),
                "nama_pj" => $request->has('nama_pj') ? $request->has('nama_pj') : null,
            ])->json();
            if ($pengajuan_degulir['data']['status_code'] == 400) {
                return redirect()->route('dagulir.index')->withStatus('Terjadi kesalahan data.');
            }
            $pengajuan = new PengajuanDagulir;
            $pengajuan->kode_pendaftaran = $pengajuan_degulir['data']['kode_pendaftaran'];
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
            $pengajuan->kode_bank_cabang = $request->get('kode_bank_cabang');
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
            $pengajuan->npwp = $request->get('npwp');
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
            $addPengajuan->id_cabang = $request->get('kode_bank_cabang');
            $addPengajuan->skema_kredit = 'Dagulir';
            $addPengajuan->dagulir_id = $pengajuan->id;
            $addPengajuan->save();

            DB::commit();
            return redirect()->route('dagulir.index')->withStatus('Berhasil menambahkan pengajuan! dengan Kode Pendaftaran : '.$pengajuan_degulir['data']['kode_pendaftaran']);

        } catch (Exception $th) {
            return $th;
            DB::rollback();
        } catch (QueryException $e){
            return $e;
            DB::rollBack();
        }
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
