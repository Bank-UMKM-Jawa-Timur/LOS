<?php

namespace App\Http\Controllers\Dagulir;

use App\Http\Controllers\Controller;
use App\Events\EventMonitoring;
use App\Http\Controllers\LogPengajuanController;
use App\Models\AlasanPengembalianData;
use App\Models\CalonNasabah;
use App\Models\CalonNasabahTemp;
use App\Models\Desa;
use App\Models\DetailKomentarModel;
use App\Models\ItemModel;
use App\Models\JawabanPengajuanModel;
use App\Models\JawabanTextModel;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\KomentarModel;
use App\Models\OptionModel;
use App\Models\PengajuanModel;
use App\Models\JawabanSubColumnModel;
use App\Models\PendapatPerAspek;
use App\Models\DetailPendapatPerAspek;
use App\Models\JawabanModel;
use App\Models\JawabanTemp;
use App\Models\JawabanTempModel;
use App\Models\LogPengajuan;
use App\Models\MerkModel;
use App\Models\PengajuanDagulir;
use App\Models\PlafonUsulan;
use App\Models\TipeModel;
use App\Models\User;
use App\Repository\MasterItemRepository;
use App\Repository\PengajuanDagulirRepository;
use App\Repository\PengajuanRepository;
use App\Services\TemporaryService;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Image;
use Carbon\Carbon;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\Return_;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class NewDagulirController extends Controller
{
    private $isMultipleFiles = [];
    private $logPengajuan;
    private $repo;

    public function __construct()
    {
        $this->logPengajuan = new LogPengajuanController;
        $this->isMultipleFiles = [
            'Foto Usaha'
        ];
        $this->repo = new PengajuanDagulirRepository;
    }
    protected $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    public function getUserJson($role)
    {
        $status = '';
        $req_status = 0;
        $message = '';
        $data = null;
        try {
            $data = User::select('id', 'nip', 'email', 'name')
                ->where('role', $role)
                ->whereNotNull('nip')
                ->where('id_cabang', Auth::user()->id_cabang)
                ->get();

            foreach ($data as $key => $value) {
                $karyawan = $this->getKaryawanFromAPI($value->nip);
                if (array_key_exists('nama', $karyawan)) {
                    $value->name = $karyawan['nama'];
                }
            }

            $req_status = HttpFoundationResponse::HTTP_OK;
            $status = 'success';
            $message = 'Berhasil mengambil data';
        } catch (Exception $e) {
            $req_status = HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR;
            $status = 'failed';
            $message = 'Terjadi kesalahan : ' . $e->getMessage();
        } catch (QueryException $e) {
            $req_status = HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR;
            $status = 'failed';
            $message = 'Terjadi kesalahan pada database: ' . $e->getMessage();
        } finally {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ]);
        }
    }

    public function getKaryawanFromAPI($nip)
    {
        // retrieve from api
        $host = env('HCS_HOST');
        $apiURL = $host . '/api/karyawan';

        try {
            $response = Http::timeout(3)->withOptions(['verify' => false])->get($apiURL, [
                'nip' => $nip,
            ]);

            $statusCode = $response->status();
            $responseBody = json_decode($response->getBody(), true);

            if (array_key_exists('data', $responseBody))
                return $responseBody['data'];
            else
                return $responseBody;
            return $responseBody;
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public static function getKaryawanFromAPIStatic($nip)
    {
        // retrieve from api
        $host = env('HCS_HOST');
        $apiURL = $host . '/api/karyawan';

        try {
            $response = Http::timeout(3)->withOptions(['verify' => false])->get($apiURL, [
                'nip' => $nip,
            ]);

            $statusCode = $response->status();
            $responseBody = json_decode($response->getBody(), true);

            if ($responseBody != null) {
                if (is_array($responseBody)) {
                    if (array_key_exists('data', $responseBody))
                        return $responseBody['data']['nama'];
                    else
                        return 'undifined';
                } else
                    return 'undifined';
            } else
                return 'undifined';
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return 'undifined';
            // return $e->getMessage();
        }
    }

    public function getNameKaryawan($nip)
    {
        $host = env('HCS_HOST');
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $host . '/api/v1/karyawan/' . $nip,
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
        if ($response != null) {
            $json = json_decode($response);

            if (isset($json->data))
                return $json->data->nama_karyawan;
        }

        return Auth::user()->name;
    }

    public function formatDate($date)
    {
        if ($date) {
            $arr = explode('-', $date);
            return $arr[2] . '-' . $arr[1] . '-' . $arr[0]; // yyyy-mm-dd
        }
    }

    public function create() {
        $param['pageTitle'] = "Dashboard";
        $param['multipleFiles'] = $this->isMultipleFiles;

        $param['dataDesa'] = Desa::all();
        $param['dataKecamatan'] = Kecamatan::all();
        $param['dataKabupaten'] = Kabupaten::all();
        $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->where('nama', '!=', 'Data Umum')->get();
        $param['itemSlik'] = ItemModel::with('option')->where('nama', 'SLIK')->first();
        $param['itemSP'] = ItemModel::where('nama', 'Surat Permohonan')->first();
        $param['itemP'] = ItemModel::where('nama', 'Laporan SLIK')->first();
        $param['itemKTPSu'] = ItemModel::where('nama', 'Foto KTP Suami')->first();
        $param['itemKTPIs'] = ItemModel::where('nama', 'Foto KTP Istri')->first();
        $param['itemKTPNas'] = ItemModel::where('nama', 'Foto KTP Nasabah')->first();
        $param['itemNIB'] = ItemModel::where('nama', 'Dokumen NIB')->first();
        $param['itemNPWP'] = ItemModel::where('nama', 'Dokumen NPWP')->first();
        $param['itemSKU'] = ItemModel::where('nama', 'Dokumen Surat Keterangan Usaha')->first();

        $data['dataPertanyaanSatu'] = ItemModel::select('id', 'nama', 'level', 'id_parent')->where('level', 2)->where('id_parent', 3)->get();
        $param['dataMerk'] = MerkModel::all();
        $param['jenis_usaha'] = config('dagulir.jenis_usaha');
        $param['tipe'] = config('dagulir.tipe_pengajuan');

        return view('dagulir.pengajuan-kredit.add-pengajuan-kredit', $param);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|unique:pengajuan_dagulir,email',
            'nik_nasabah' => 'required|unique:pengajuan_dagulir,nik',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'telp' => 'required',
            'jenis_usaha' => 'required',
            'nominal_pengajuan' => 'required',
            'tujuan_penggunaan' => 'required',
            'jangka_waktu' => 'required',
            'status' => 'required|not_in:0',
            'desa' => 'required|not_in:0',
            'kecamatan_sesuai_ktp' => 'required|not_in:0',
            'kode_kotakab_ktp' => 'required|not_in:0',
            'alamat_sesuai_ktp' => 'required',
            'kecamatan_domisili' => 'required|not_in:0',
            'kode_kotakab_domisili' => 'required|not_in:0',
            'alamat_domisili' => 'required',
            'kecamatan_usaha' => 'required|not_in:0',
            'kode_kotakab_usaha' => 'required|not_in:0',
            'alamat_usaha' => 'required',
            'tipe_pengajuan' => 'required|not_in:0',
            'jenis_badan_hukum' => 'required|not_in:0',
            'ket_agunan' => 'required|not_in:0'
        ]);
        $statusSlik = false;
        $find = array('Rp ', '.', ',');

        DB::beginTransaction();
        try {
            $find = array('Rp.', '.', ',');

            $pengajuan = new PengajuanDagulir();
            $pengajuan->kode_pendaftaran = null;
            $pengajuan->nama = $request->get('nama_lengkap');
            $pengajuan->email = $request->get('email');
            $pengajuan->nik = $request->get('nik_nasabah');
            $pengajuan->nama_pj_ketua = $request->has('nama_pj') ? $request->get('nama_pj') : null;
            $pengajuan->tempat_lahir =  $request->get('tempat_lahir');
            $pengajuan->tanggal_lahir = $request->get('tanggal_lahir');
            $pengajuan->telp = $request->get('telp');
            $pengajuan->jenis_usaha = $request->get('jenis_usaha');
            $pengajuan->ket_agunan = $request->get('ket_agunan');
            $pengajuan->hubungan_bank = $request->get('hub_bank');
            $pengajuan->hasil_verifikasi = $request->get('hasil_verifikasi');
            $pengajuan->nominal = formatNumber($request->get('nominal_pengajuan'));
            $pengajuan->tujuan_penggunaan = $request->get('tujuan_penggunaan');
            $pengajuan->jangka_waktu = $request->get('jangka_waktu');
            $pengajuan->kode_bank_pusat = 1;
            $pengajuan->kode_bank_cabang = auth()->user()->id_cabang;
            $pengajuan->desa_ktp = $request->get('desa');
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
            $npwp = null;
            if ($request->informasi) {
                if (array_key_exists('79', $request->informasi)) {
                    $npwp = str_replace(['.','-'], '', $request->informasi[79]);
                }
            }
            $pengajuan->npwp = $npwp;
            $pengajuan->jenis_badan_hukum = $request->get('jenis_badan_hukum');
            $pengajuan->tempat_berdiri = $request->get('tempat_berdiri');
            $pengajuan->tanggal_berdiri = $request->get('tanggal_berdiri');
            $pengajuan->tanggal = now();
            $pengajuan->user_id = Auth::user()->id;
            $pengajuan->status = 8;
            $pengajuan->status_pernikahan = $request->get('status');
            $pengajuan->nik_pasangan = $request->has('nik_pasangan') ? $request->get('nik_pasangan') : null;
            $pengajuan->created_at = now();
            $pengajuan->from_apps = 'pincetar';
            $pengajuan->save();

            $dagulir_id = $pengajuan->id;

            $addPengajuan = new PengajuanModel;
            $addPengajuan->id_staf = auth()->user()->id;
            $addPengajuan->tanggal = date(now());
            $addPengajuan->id_cabang = auth()->user()->id_cabang;
            $addPengajuan->progress_pengajuan_data = $request->progress;
            $addPengajuan->skema_kredit = 'Dagulir';
            $addPengajuan->dagulir_id = $pengajuan->id;
            $addPengajuan->save();
            $id_pengajuan = $addPengajuan->id;

            $update_pengajuan = PengajuanDagulir::find($pengajuan->id);
            // foto nasabah
            if ($request->has('foto_nasabah')) {
                $image = $request->file('foto_nasabah');
                $fileNameNasabah = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();
                $filePath = public_path() . '/upload/' . $id_pengajuan. '/' . $dagulir_id;
                if (!File::isDirectory($filePath)) {
                    File::makeDirectory($filePath, 493, true);
                }
                $image->move($filePath, $fileNameNasabah);
                $update_pengajuan->foto_nasabah = $fileNameNasabah;

            }
            if ($request->has('ktp_pasangan')) {
                $image = $request->file('ktp_pasangan');
                $fileNamePasangan = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();
                $filePath = public_path() . '/upload/' . $id_pengajuan. '/' . $dagulir_id;
                if (!File::isDirectory($filePath)) {
                    File::makeDirectory($filePath, 493, true);
                }
                $image->move($filePath, $fileNamePasangan);
                $update_pengajuan->foto_pasangan = $fileNamePasangan;

            }
            if ($request->has('ktp_nasabah')) {
                $image = $request->file('ktp_nasabah');
                $fileNameKtpNasabah = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();
                $filePath = public_path() . '/upload/' . $id_pengajuan. '/' . $dagulir_id;
                if (!File::isDirectory($filePath)) {
                    File::makeDirectory($filePath, 493, true);
                }
                $image->move($filePath, $fileNameKtpNasabah);
                $update_pengajuan->foto_ktp = $fileNameKtpNasabah;

            }
            // ktp nasabah
            $update_pengajuan->update();

            $tempNasabah = TemporaryService::getNasabahData($request->idCalonNasabah);

            $dataNasabah = $tempNasabah->toArray();
            $dataNasabah['id_pengajuan'] = $id_pengajuan;

            // jawaban ijin usaha
            JawabanTextModel::create([
                'id_pengajuan' => $id_pengajuan,
                'id_jawaban' => 76,
                'opsi_text' => $request->ijin_usaha,
                'skor_penyelia' => null,
                'skor_pbp' => null,
                'skor' => null,
            ]);

            //untuk jawaban yg teks, number, persen, long text
            foreach ($request->id_level as $key => $value) {
                if ($value != null) {
                    $dataJawabanText = new JawabanTextModel;
                    $dataJawabanText->id_pengajuan = $id_pengajuan;
                    $dataJawabanText->id_jawaban = $request->get('id_level')[$key];
                    if ($request->get('id_level')[$key] != '131' && $request->get('id_level')[$key] != '143' && $request->get('id_level')[$key] != '90' && $request->get('id_level')[$key] != '138') {
                        $dataJawabanText->opsi_text = str_replace($find, '', $request->get('informasi')[$key]);
                    } else {
                        $dataJawabanText->opsi_text = $request->get('informasi')[$key];
                    }
                    $dataJawabanText->save();
                }
            }

            $dataJawabanText = new JawabanTextModel;
            $dataJawabanText->id_pengajuan = $id_pengajuan;
            $dataJawabanText->id_jawaban = 110;
            $dataJawabanText->opsi_text = $request->kategori_jaminan_tambahan;
            $dataJawabanText->save();

            // untuk upload file baru
            foreach ($request->upload_file as $key => $value) {
                if (is_array($value)) {
                    for ($i = 0; $i < count($value); $i++) {
                        $filename = auth()->user()->id . '-' . time() . '-' . $value[$i]->getClientOriginalName();
                        $relPath = "upload/{$id_pengajuan}/{$key}";
                        $path = public_path("upload/{$id_pengajuan}/{$key}/");

                        File::isDirectory(public_path($relPath)) or File::makeDirectory(public_path($relPath), recursive: true);
                        $value[$i]->move($path, $filename);

                        JawabanTextModel::create([
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $key,
                            'opsi_text' => $filename,
                            'skor_penyelia' => null,
                            'skor_pbp' => null,
                            'skor' => null,
                        ]);
                    }
                } else {
                    $filename = auth()->user()->id . '-' . time() . '-' . $value->getClientOriginalName();
                    $relPath = "upload/{$id_pengajuan}/{$key}";
                    $path = public_path("upload/{$id_pengajuan}/{$key}/");

                    File::isDirectory(public_path($relPath)) or File::makeDirectory(public_path($relPath), recursive: true);
                    $value->move($path, $filename);

                    JawabanTextModel::create([
                        'id_pengajuan' => $id_pengajuan,
                        'id_jawaban' => $key,
                        'opsi_text' => $filename,
                        'skor_penyelia' => null,
                        'skor_pbp' => null,
                        'skor' => null,
                    ]);
                }
            }
            //untuk upload file dari temp
            $tempFiles = JawabanTemp::where('type', 'file')->where('id_temporary_calon_nasabah', $request->id_nasabah)->get();
            foreach ($tempFiles as $tempFile) {
                if (!array_key_exists($tempFile->id_jawaban, $request->upload_file)) {
                    $tempPath = public_path("upload/temp/{$tempFile->id_jawaban}/{$tempFile->opsi_text}");
                    $newPath = str_replace('temp/', "{$id_pengajuan}/", $tempPath);
                    $relPath = "upload/{$id_pengajuan}/{$tempFile->id_jawaban}";

                    // check file exists
                    if (file_exists($tempPath)) {
                        File::isDirectory(public_path($relPath)) or File::makeDirectory(public_path($relPath), recursive: true);
                        File::move($tempPath, $newPath);
                        if ($tempFile->id_jawaban != null) {
                            JawabanTextModel::create([
                                'id_pengajuan' => $id_pengajuan,
                                'id_jawaban' => $tempFile->id_jawaban,
                                'opsi_text' => $tempFile->opsi_text,
                                'skor_penyelia' => null,
                                'skor_pbp' => null,
                                'skor' => null,
                            ]);
                        }
                    }
                }

                $tempFile->delete();
            }

            /**
             * Find score average
             * 1. declare array variable needs
             * 2. remove empty data from array
             * 3. merge array variables to one array
             * 4. sum score
             * 5. find average score
             */

            // item level 2
            $dataLev2 = [];
            if ($request->dataLevelDua != null) {
                $dataLev2 = $request->dataLevelDua;
            }

            // item level 3
            $dataLev3 = [];
            if ($request->dataLevelTiga != null) {
                // item level 3
                $dataLev3 = $request->dataLevelTiga;
                unset($dataLev3[134]);
            }

            // item level 4
            $dataLev4 = [];
            if ($request->dataLevelEmpat != null) {
                $dataLev4 = $request->dataLevelEmpat;
            }

            $mergedDataLevel = array_merge($dataLev2, $dataLev3, $dataLev4);
            // sum score
            $totalScore = 0;
            $totalDataNull = 0;
            $arrTes = [];
            for ($i = 0; $i < count($mergedDataLevel); $i++) {
                if ($mergedDataLevel[$i]) {
                    // jika data tersedia
                    $data = getDataLevel($mergedDataLevel[$i]);
                    array_push($arrTes, $data);
                    if (is_numeric($data[0])) {
                        if ($data[0] > 0) {
                            if (array_key_exists(1, $data)) {
                                if ($data[1] == 71 || $data[1] == 186) {
                                    if ($data[0] == '1') {
                                        $statusSlik = true;
                                    }
                                }
                            }
                            $totalScore += $data[0];
                        }
                        else {
                            $totalDataNull++;
                        }
                    } else
                        $totalDataNull++;
                } else
                    $totalDataNull++;
            }
            // find avg
            $avgResult = round($totalScore / (count($mergedDataLevel) - $totalDataNull), 2);
            $status = "";
            $updateData = PengajuanModel::find($id_pengajuan);
            if ($avgResult > 0 && $avgResult <= 2) {
                $status = "merah";
            } elseif ($avgResult > 2 && $avgResult <= 3) {
                // $updateData->status = "kuning";
                $status = "kuning";
            } elseif ($avgResult > 3) {
                $status = "hijau";
            } else {
                $status = "merah";
            }

            for ($i = 0; $i < count($mergedDataLevel); $i++) {
                if ($mergedDataLevel[$i] != null) {
                    $data = getDataLevel($mergedDataLevel[$i]);
                    if (is_numeric($data[0])) {
                        if ($data[0] > 0) {
                            if (array_key_exists(1, $data)) {
                                JawabanPengajuanModel::insert([
                                    'id_pengajuan' => $id_pengajuan,
                                    'id_jawaban' => $data[1],
                                    'skor' => $data[0],
                                ]);
                            }
                        }
                    } else {
                        if (array_key_exists(1, $data)) {
                            JawabanPengajuanModel::insert([
                                'id_pengajuan' => $id_pengajuan,
                                'id_jawaban' => $data[1]
                            ]);
                        }
                    }
                }
            }

            if (!$statusSlik) {
                $updateData->posisi = 'Proses Input Data';
                $updateData->status_by_sistem = $status;
                $updateData->average_by_sistem = $avgResult;
            } else {
                $updateData->posisi = 'Ditolak';
                $updateData->status_by_sistem = "merah";
                $updateData->average_by_sistem = "1.0";
            }
            $updateData->update();

            //save pendapat per aspek
            foreach ($request->get('id_aspek') as $key => $value) {
                if ($request->get('pendapat_per_aspek')[$key] == '') {
                    # code...
                } else {
                    $addPendapat = new PendapatPerAspek;
                    $addPendapat->id_pengajuan = $id_pengajuan;
                    $addPendapat->id_staf = Auth::user()->id;
                    $addPendapat->id_aspek = $value;
                    $addPendapat->pendapat_per_aspek = $request->get('pendapat_per_aspek')[$key];
                    $addPendapat->save();
                }
            }

            if ($request->get('komentar_staff') == '') {
                $addKomentar = new KomentarModel;
                $addKomentar->id_pengajuan = $id_pengajuan;
                $addKomentar->komentar_staff = '';
                $addKomentar->id_staff = Auth::user()->id;
                $addKomentar->save();
            } else {
                $addKomentar = new KomentarModel;
                $addKomentar->id_pengajuan = $id_pengajuan;
                $addKomentar->komentar_staff = $request->get('komentar_staff');
                $addKomentar->id_staff = Auth::user()->id;
                $addKomentar->save();
            }

            // Log Pengajuan Baru
            $namaNasabah = $pengajuan->nama;

            $this->logPengajuan->store('Staff dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' melakukan proses pembuatan data pengajuan atas nama ' . $namaNasabah . '.', $id_pengajuan, Auth::user()->id, Auth::user()->nip);

            DB::commit();
            event(new EventMonitoring('store pengajuan'));

            if (!$statusSlik){
                Alert::success('Success', 'Data berhasil disimpan.');
                return redirect()->route('dagulir.pengajuan.index');
            }
            else {
                alert()->error('Terjadi Kesalahan', 'Pengajuan ditolak.');
                return redirect()->route('dagulir.pengajuan.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            return redirect()->route('dagulir.pengajuan.index')->withError('Terjadi kesalahan.' . $e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            return $e->getMessage();
            return redirect()->route('dagulir.pengajuan.index')->withError('Terjadi kesalahan' . $e->getMessage());
        }
    }

    public function checkPenyeliaKredit(Request $request) {
        DB::beginTransaction();
        try {
            $statusPenyelia = PengajuanModel::find($request->id_pengajuan);
            if ($statusPenyelia) {
                $statusPenyelia->posisi = "Review Penyelia";
                $statusPenyelia->id_penyelia = $request->select_penyelia;
                if (!$statusPenyelia->tanggal_review_penyelia) {
                    $statusPenyelia->tanggal_review_penyelia = date(now());
                }
                $statusPenyelia->update();

                // Log Pengajuan melanjutkan dan mendapatkan
                $dagulir = PengajuanDagulir::select('nama')->find($statusPenyelia->dagulir_id);
                $namaNasabah = 'undifined';
                if ($dagulir)
                    $namaNasabah = $dagulir->nama;

                $penyelia = User::find($request->select_penyelia);
                $this->logPengajuan->store('Staff dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' menindak  lanjuti pengajuan atas nama ' . $namaNasabah . ' ke penyelia dengan NIP ' . $penyelia->nip . ' atas nama ' . $this->getNameKaryawan($penyelia->nip) . ' .', $statusPenyelia->id, Auth::user()->id, Auth::user()->nip);

                DB::commit();
                Alert::success('success', 'Berhasil mengganti posisi');
                return redirect()->back();
            } else {
                alert()->error('error','Data pengajuan tidak ditemukan.');
                return redirect()->back();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }

    // insert komentar
    public function getInsertKomentar(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 'Penyelia Kredit' || $role == 'PBO' || $role == 'PBP' || $role == 'Pincab') {
            DB::beginTransaction();
            try {
                if ($role == 'Pincab') {
                    $idKomentar = KomentarModel::where('id_pengajuan', $request->id_pengajuan)->first();
                    KomentarModel::where('id', $idKomentar->id)->update(
                        [
                            'komentar_pincab' => $request->komentar_pincab_keseluruhan,
                            'id_pincab' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                }
                else {
                    $finalArray = array();
                    $finalArray_text = array();
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
                    // get skor ratio coverage opsi
                    $jawaban = JawabanModel::select('id', 'skor')
                                            ->where('id_pengajuan', $request->id_pengajuan)
                                            ->where('id_jawaban', 158) // 158  = id_option ratio coverage opsi
                                            ->first();
                    $total_input_data = (count($request->skor_penyelia) - $totalDataNull);
                    if ($jawaban) {
                        $sum_select += $jawaban->skor;
                        $total_input_data++;
                    }
                    $average = ($sum_select) / $total_input_data;
                    $result = round($average, 2);
                    $status = "";
                    $updateData = PengajuanModel::find($request->id_pengajuan);

                    if ($result > 0 && $result <= 2) {
                        $status = "merah";
                    } elseif ($result >= 2 && $result <= 3) {
                        $status = "kuning";
                    } elseif ($result > 3) {
                        $status = "hijau";
                    } else {
                        $status = "merah";
                    }

                    if ($role == 'Penyelia Kredit') {
                        foreach ($request->get('id_option') as $key => $value) {
                            JawabanPengajuanModel::where('id_jawaban', $value)->where('id_pengajuan', $request->get('id_pengajuan'))
                                ->update([
                                    'skor_penyelia' => $request->get('skor_penyelia')[$key] ? $request->get('skor_penyelia')[$key] : null
                                ]);
                        }
                    } else if ($role == 'PBO') {
                        foreach ($request->get('id_option') as $key => $value) {
                            JawabanPengajuanModel::where('id_jawaban', $value)->where('id_pengajuan', $request->get('id_pengajuan'))
                                ->update([
                                    'skor_pbo' => $request->get('skor_penyelia')[$key] ? $request->get('skor_penyelia')[$key] : null
                                ]);
                        }
                    } else {
                        foreach ($request->get('id_option') as $key => $value) {
                            JawabanPengajuanModel::where('id_jawaban', $value)->where('id_pengajuan', $request->get('id_pengajuan'))
                                ->update([
                                    'skor_pbp' => $request->get('skor_penyelia')[$key] ? $request->get('skor_penyelia')[$key] : null
                                ]);
                        }
                    }

                    $updateData->status = $status;
                    if ($role == 'Penyelia Kredit')
                        $updateData->average_by_penyelia = $result;
                    else if ($role == 'PBO')
                        $updateData->average_by_pbo = $result;
                    else
                        $updateData->average_by_pbp = $result;

                    $updateData->update();

                    $idKomentar = KomentarModel::where('id_pengajuan', $request->id_pengajuan)->first();

                    if ($role == 'Penyelia Kredit') {
                        KomentarModel::where('id', $idKomentar->id)->update(
                            [
                                'komentar_penyelia' => $request->komentar_penyelia_keseluruhan,
                                'id_penyelia' => Auth::user()->id,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]
                        );
                    } else if ($role == 'PBO') {
                        KomentarModel::where('id', $idKomentar->id)->update(
                            [
                                'komentar_pbo' => $request->komentar_pbo_keseluruhan,
                                'id_pbo' => Auth::user()->id,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]
                        );
                    } else {
                        KomentarModel::where('id', $idKomentar->id)->update(
                            [
                                'komentar_pbp' => $request->komentar_pbp_keseluruhan,
                                'id_pbp' => Auth::user()->id,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]
                        );
                    }

                    $countDK = DetailKomentarModel::where('id_komentar', $idKomentar->id)->count();
                    if ($countDK > 0) {
                        foreach ($request->id_item as $key => $value) {
                            $dk = DetailKomentarModel::where('id_komentar', $idKomentar->id)->where('id_user', Auth::user()->id)->where('id_item', $value)->first();
                            if ($dk) {
                                $dk->komentar = $_POST['komentar_penyelia'][$key];
                                $dk->save();
                            }
                        }
                    } else {
                        foreach ($request->id_item as $key => $value) {
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
                    if ($role == 'Penyelia Kredit')
                        $countpendapat = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_penyelia', Auth::user()->id)->count();
                    else if ($role == 'PBO')
                        $countpendapat = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_pbo', Auth::user()->id)->count();
                    else
                        $countpendapat = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_pbp', Auth::user()->id)->count();

                    if ($countpendapat > 0) {
                        if ($role == 'Penyelia Kredit') {
                            foreach ($request->get('id_aspek') as $key => $value) {
                                $pendapatperaspekpenyelia = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_aspek', $value)->where('id_penyelia', Auth::user()->id)->first();
                                $pendapatperaspekpenyelia->pendapat_per_aspek = $_POST['pendapat_per_aspek'][$key];
                                $pendapatperaspekpenyelia->save();
                            }
                        } else if ($role == 'PBO') {
                            foreach ($request->get('id_aspek') as $key => $value) {
                                $pendapatperaspekpenyelia = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_aspek', $value)->where('id_pbo', Auth::user()->id)->first();
                                $pendapatperaspekpenyelia->pendapat_per_aspek = $_POST['pendapat_per_aspek'][$key];
                                $pendapatperaspekpenyelia->save();
                            }
                        } else {
                            foreach ($request->get('id_aspek') as $key => $value) {
                                $pendapatperaspekpenyelia = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_aspek', $value)->where('id_pbp', Auth::user()->id)->first();
                                $pendapatperaspekpenyelia->pendapat_per_aspek = $_POST['pendapat_per_aspek'][$key];
                                $pendapatperaspekpenyelia->save();
                            }
                        }
                    } else {
                        if ($role == 'Penyelia Kredit') {
                            foreach ($request->get('id_aspek') as $key => $value) {
                                $pendapatperaspekpenyelia = new PendapatPerAspek;
                                $pendapatperaspekpenyelia->id_pengajuan = $request->get('id_pengajuan');
                                $pendapatperaspekpenyelia->id_penyelia = Auth::user()->id;
                                $pendapatperaspekpenyelia->id_aspek = $value;
                                $pendapatperaspekpenyelia->pendapat_per_aspek = $request->get('pendapat_per_aspek')[$key];
                                $pendapatperaspekpenyelia->save();
                            }
                        } else if ($role == 'PBO') {
                            foreach ($request->get('id_aspek') as $key => $value) {
                                $pendapatperaspekpenyelia = new PendapatPerAspek;
                                $pendapatperaspekpenyelia->id_pengajuan = $request->get('id_pengajuan');
                                $pendapatperaspekpenyelia->id_pbo = Auth::user()->id;
                                $pendapatperaspekpenyelia->id_aspek = $value;
                                $pendapatperaspekpenyelia->pendapat_per_aspek = $request->get('pendapat_per_aspek')[$key];
                                $pendapatperaspekpenyelia->save();
                            }
                        } else {
                            foreach ($request->get('id_aspek') as $key => $value) {
                                $pendapatperaspekpenyelia = new PendapatPerAspek;
                                $pendapatperaspekpenyelia->id_pengajuan = $request->get('id_pengajuan');
                                $pendapatperaspekpenyelia->id_pbp = Auth::user()->id;
                                $pendapatperaspekpenyelia->id_aspek = $value;
                                $pendapatperaspekpenyelia->pendapat_per_aspek = $request->get('pendapat_per_aspek')[$key];
                                $pendapatperaspekpenyelia->save();
                            }
                        }
                    }
                }
                $plafonUsulan = PlafonUsulan::where('id_pengajuan', $request->id_pengajuan)->first();

                if ($plafonUsulan == null)
                    $plafonUsulan = new PlafonUsulan();
                if($role == 'Penyelia Kredit'){
                    $plafonUsulan->id_pengajuan = $request->id_pengajuan;
                    $plafonUsulan->plafon_usulan_penyelia = str_replace('.', '', $request->plafon_usulan_penyelia ?? 0);
                    $plafonUsulan->jangka_waktu_usulan_penyelia = $request->jangka_waktu_usulan_penyelia;
                    $plafonUsulan->save();
                } else if($role == 'PBO'){
                    $plafonUsulan->id_pengajuan = $request->id_pengajuan;
                    $plafonUsulan->plafon_usulan_pbo = str_replace('.', '', $request->plafon_usulan_pbo ?? 0);
                    $plafonUsulan->jangka_waktu_usulan_pbo = $request->jangka_waktu_usulan_pbo;
                    $plafonUsulan->save();
                } else if($role == 'PBP'){
                    $plafonUsulan->id_pengajuan = $request->id_pengajuan;
                    $plafonUsulan->plafon_usulan_pbp = str_replace('.', '', $request->plafon_usulan_pbp ?? 0);
                    $plafonUsulan->jangka_waktu_usulan_pbp = $request->jangka_waktu_usulan_pbp;
                    $plafonUsulan->save();
                } else{
                    $plafonUsulan->id_pengajuan = $request->id_pengajuan;
                    $plafonUsulan->plafon_usulan_pincab = str_replace('.', '', $request->plafon_usulan_pincab ?? 0);
                    $plafonUsulan->jangka_waktu_usulan_pincab = $request->jangka_waktu_usulan_pincab;
                    $plafonUsulan->save();
                }

                // Log Pengajuan review
                $dagulir = PengajuanDagulir::find($updateData->dagulir_id);
                $namaNasabah = 'undifined';

                if ($dagulir)
                    $namaNasabah = $dagulir->nama;

                $this->logPengajuan->store($role . ' dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' melakukan review terhadap pengajuan atas nama ' . $namaNasabah, $updateData->id, Auth::user()->id, Auth::user()->nip);

                DB::commit();
                event(new EventMonitoring('review pengajuan'));

                Alert::success('success', 'Berhasil Mereview');
                return redirect()->route('dagulir.pengajuan.index');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->back()->withError('Terjadi kesalahan.' . $e->getMessage());
            } catch (QueryException $e) {
                DB::rollBack();
                return redirect()->back()->withError('Terjadi kesalahan.' . $e->getMessage());
            }
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }

    // get detail jawaban dan skor pengajuan
    public function getDetailJawaban($id)
    {
        if (auth()->user()->role == 'Penyelia Kredit' || auth()->user()->role == 'PBO' ||
            auth()->user()->role == 'PBP' || auth()->user()->role == 'Pincab') {
            $param['pageTitle'] = "Dashboard";
            $param['dataAspek'] = ItemModel::where('level', 1)->where('nama', '!=', 'Data Umum')->get();
            $param['itemSlik'] = ItemModel::join('option as o', 'o.id_item', 'item.id')
                ->join('jawaban as j', 'j.id_jawaban', 'o.id')
                ->join('pengajuan as p', 'p.id', 'j.id_pengajuan')
                ->where('p.id', $id)
                ->where('nama', 'SLIK')
                ->first();
            $param['itemSP'] = ItemModel::where('level', 1)->where('nama', '=', 'Data Umum')->first();
            $param['itemKTPSu'] = ItemModel::where('level', 1)->where('nama', '=', 'Data Umum')->first();
            $param['itemKTPIs'] = ItemModel::where('level', 1)->where('nama', '=', 'Data Umum')->first();

            $pengajuan = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.dagulir_id',
                'pengajuan.skema_kredit'
            )
            ->find($id);
            $param['dataUmum'] = $pengajuan;
            $param['dataUmumNasabah'] = PengajuanDagulir::find($pengajuan->dagulir_id);

            $param['kec_ktp'] = Kecamatan::find($param['dataUmumNasabah']->kec_ktp)->kecamatan;
            $param['kab_ktp'] = Kabupaten::find($param['dataUmumNasabah']->kotakab_ktp)->kabupaten;
            $param['desa_ktp'] = '';
            if ($param['dataUmumNasabah']->desa_ktp != null) {
                $param['desa_ktp'] = Desa::find($param['dataUmumNasabah']->desa_ktp)->desa;
            }
            $param['kec_dom'] = Kecamatan::find($param['dataUmumNasabah']->kec_dom)->kecamatan;
            $param['kab_dom'] = Kabupaten::find($param['dataUmumNasabah']->kotakab_dom)->kabupaten;
            $param['kec_usaha'] = Kecamatan::find($param['dataUmumNasabah']->kec_usaha)->kecamatan;
            $param['kab_usaha'] = Kabupaten::find($param['dataUmumNasabah']->kotakab_usaha)->kabupaten;
            $param['alamat_usaha'] = $param['dataUmumNasabah']->alamat_usaha;

            $param['allKab'] = Kabupaten::get();
            $param['allKec'] = Kecamatan::where('id_kabupaten', $param['dataUmumNasabah']->kotakab_ktp)->get();
            $param['allDesa'] = Desa::where('id_kecamatan', $param['dataUmumNasabah']->kec_ktp)->get();
            $param['pendapatDanUsulanStaf'] = KomentarModel::select('komentar_staff')->where('id_pengajuan', $id)->first();
            $param['pendapatDanUsulanPenyelia'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_penyelia')->first();
            if (auth()->user()->role == 'PBO' || auth()->user()->role == 'PBP' || auth()->user()->role == 'Pincab')
                $param['pendapatDanUsulanPBO'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_pbo')->first();
            if (auth()->user()->role == 'PBP' || auth()->user()->role == 'Pincab')
                $param['pendapatDanUsulanPBP'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_pbp')->first();
            if (auth()->user()->role == 'Pincab')
                $param['pendapatDanUsulanPincab'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_pincab')->first();
            if ($param['dataUmumNasabah']->skema_kredit == 'KKB') {
                $param['dataPO'] = DB::table('data_po')
                    ->where('id_pengajuan', $id)
                    ->first();
            }
            $param['skema'] = $param['dataUmumNasabah']->skema_kredit;
            $dokumenUsaha = DB::table('item')
                ->where('nama', 'LIKE', '%NIB%')
                ->orWhere('nama', 'LIKE', '%Surat Keterangan Usaha%')
                ->orWhere('nama', 'LIKE', '%NPWP%')
                ->get('id');
            $countDoc = 0;
            foreach ($dokumenUsaha as $idDoc) {
                $count = DB::table('jawaban_text')
                    ->where('id_pengajuan', $id)
                    ->where('id_jawaban', $idDoc->id)
                    ->count();
                $countDoc += $count;
            }
            $param['countIjin'] = $countDoc;
            $param['alasanPengembalian'] = AlasanPengembalianData::where('id_pengajuan', $id)
                ->join('users', 'users.id', 'alasan_pengembalian_data.id_user')
                ->select('users.nip', 'alasan_pengembalian_data.*')
                ->get();
            $param['jenis_usaha'] = config('dagulir.jenis_usaha');
            $param['tipe'] = config('dagulir.tipe_pengajuan');

            $param['itemSlik'] = ItemModel::join('option as o', 'o.id_item', 'item.id')
                ->join('jawaban as j', 'j.id_jawaban', 'o.id')
                ->join('pengajuan as p', 'p.id', 'j.id_pengajuan')
                ->where('p.id', $id)
                ->where('nama', 'SLIK')
                ->first();

            $param['itemSP'] = ItemModel::where('level', 1)->where('nama', '=', 'Data Umum')->first();
            $param['itemKTPSu'] = ItemModel::where('level', 1)->where('nama', '=', 'Data Umum')->first();
            $param['itemKTPIs'] = ItemModel::where('level', 1)->where('nama', '=', 'Data Umum')->first();
            $param['itemKTPNas'] = ItemModel::where('nama', 'Foto KTP Nasabah')->first();
            $param['itemNIB'] = ItemModel::where('nama', 'Dokumen NIB')->first();
            $param['itemNPWP'] = ItemModel::where('nama', 'Dokumen NPWP')->first();
            $param['itemSKU'] = ItemModel::where('nama', 'Dokumen Surat Keterangan Usaha')->first();
            $param['multipleFiles'] = $this->isMultipleFiles;
            $param['dataDesa'] = Desa::all();
            $param['dataKecamatan'] = Kecamatan::all();
            $param['dataKabupaten'] = Kabupaten::all();
            $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->where('nama', '!=', 'Data Umum')->get();
            $param['plafonUsulan'] = PlafonUsulan::where('id_pengajuan', $id)->first();

            return view('dagulir.pengajuan-kredit.detail-pengajuan-jawaban', $param);
        } else {
            alert()->error('Terjadi Kesalahan', 'Tidak memiliki hak akses');
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }

    public function getDetailJawabanPincab($id)
    {
        if (auth()->user()->role == 'Pincab') {
            $param['pageTitle'] = "Dashboard";

            $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->where('nama', '!=', 'Data Umum')->get();
            $param['itemSlik'] = ItemModel::join('option as o', 'o.id_item', 'item.id')
                ->join('jawaban as j', 'j.id_jawaban', 'o.id')
                ->join('pengajuan as p', 'p.id', 'j.id_pengajuan')
                ->where('p.id', $id)
                ->where('nama', 'SLIK')
                ->first();
            $param['itemSP'] = ItemModel::where('level', 1)->where('nama', '=', 'Data Umum')->first();

            $nasabah = PengajuanModel::select('pengajuan_dagulir.*', 'kabupaten.id as kabupaten_id', 'kabupaten.kabupaten', 'kecamatan.id as kecamatan_id', 'kecamatan.id_kabupaten', 'kecamatan.kecamatan', 'desa.id as desa_id', 'desa.id_kabupaten', 'desa.id_kecamatan', 'desa.desa')
                ->join('pengajuan_dagulir', 'pengajuan_dagulir.id', 'pengajuan.dagulir_id')
                ->leftJoin('kabupaten', 'kabupaten.id', 'pengajuan_dagulir.kotakab_ktp')
                ->leftJoin('kecamatan', 'kecamatan.id', 'pengajuan_dagulir.kec_ktp')
                ->leftJoin('desa', 'desa.id', 'pengajuan_dagulir.desa_ktp')
                ->where('pengajuan.id', $id)
                ->first();
            $param['dataNasabah'] = $nasabah;
            $param['dataDesa'] = Desa::where('id', $nasabah->desa_id)->first();
            $param['dataKecamatan'] = Kecamatan::where('id', $nasabah->kec_ktp)->first();
            $param['dataKabupaten'] = Kabupaten::where('id', $nasabah->kotakab_ktp)->first();
            $param['dataKabupatenDom'] = Kabupaten::where('id', $nasabah->kotakab_dom)->first();
            $param['dataKecamatanDom'] = Kecamatan::where('id', $nasabah->kec_dom)->first();
            $param['dataKabupatenUsaha'] = Kabupaten::where('id', $nasabah->kotakab_usaha)->first();
            $param['dataKecamatanUsaha'] = Kecamatan::where('id', $nasabah->kec_usaha)->first();
            // return $param['dataKecamatanDom'];
            $param['jenis_usaha'] = config('dagulir.jenis_usaha');

            $param['dataUmum'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang', 'pengajuan.skema_kredit', 'pengajuan.average_by_sistem', 'pengajuan.average_by_penyelia', 'pengajuan.average_by_pbo', 'pengajuan.average_by_pbp')
                ->find($id);
            $param['comment'] = KomentarModel::where('id_pengajuan', $id)->first();

            $param['alasanPengembalian'] = AlasanPengembalianData::where('id_pengajuan', $id)
                                                                ->join('users', 'users.id', 'alasan_pengembalian_data.id_user')
                                                                ->select('users.nip', 'alasan_pengembalian_data.*')
                                                                ->get();

            $param['pendapatDanUsulan'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_staff', 'komentar_penyelia', 'komentar_pincab', 'komentar_pbo', 'komentar_pbp')->first();
            $param['plafonUsulan'] = PlafonUsulan::where('id_pengajuan', $id)->select(
                'plafon_usulan_penyelia',
                'jangka_waktu_usulan_penyelia',
                'plafon_usulan_pbo',
                'jangka_waktu_usulan_pbo',
                'plafon_usulan_pbp',
                'jangka_waktu_usulan_pbp',
                'plafon_usulan_pincab',
                'jangka_waktu_usulan_pincab'
                )->first();
            $dokumenUsaha = DB::table('item')
                ->where('nama', 'LIKE', '%NIB%')
                ->orWhere('nama', 'LIKE', '%Surat Keterangan Usaha%')
                ->orWhere('nama', 'LIKE', '%NPWP%')
                ->get('id');
            $countDoc = 0;
            foreach ($dokumenUsaha as $idDoc) {
                $count = DB::table('jawaban_text')
                    ->where('id_pengajuan', $id)
                    ->where('id_jawaban', $idDoc->id)
                    ->count();
                $countDoc += $count;
            }
            $param['countIjin'] = $countDoc;
            $logPengajuan = DB::table('log_pengajuan')->selectRaw("DISTINCT(date(created_at)) as tgl")->where('id_pengajuan', $id)->get();
            $log = array();
            if($logPengajuan){
                foreach($logPengajuan as $item){
                    $itemLog = DB::table('log_pengajuan')
                        ->where('id_pengajuan', $id)
                        ->whereDate('created_at', $item->tgl)
                        ->get();
                    $itemsLog = array();

                    foreach($itemLog as $itemLogPengajuan){
                        array_push($itemsLog, $itemLogPengajuan);
                    }
                    array_push($log, [
                        'tgl' => $item->tgl,
                        'data' => $itemLog
                    ]);
                }
            } else {
                $log = [];
            }
            $param['logPengajuan'] = $log;
            $param['rolesPemroses'] = $this->repo->getDataPemroses($nasabah);

            return view('dagulir.pengajuan-kredit.review-pincab-new', $param);

        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }

    public function storeSipde($id_pengajuan) {
        DB::beginTransaction();
        try {
            $pengajuan = PengajuanModel::with('pendapatPerAspek')->find($id_pengajuan);
            $pengajuan_dagulir = PengajuanDagulir::find($pengajuan->dagulir_id);
            $data = sipde_token();
            $body = [
                "nama" => $pengajuan_dagulir->nama,
                "nik" => $pengajuan_dagulir->nik,
                "tempat_lahir" => $pengajuan_dagulir->tempat_lahir,
                "tanggal_lahir" => $pengajuan_dagulir->tanggal_lahir,
                "telp" => $pengajuan_dagulir->telp,
                "jenis_usaha" => $pengajuan_dagulir->jenis_usaha,
                "nominal_pengajuan" => $pengajuan_dagulir->nominal,
                "tujuan_penggunaan" => $pengajuan_dagulir->tujuan_penggunaan,
                "jangka_waktu" => $pengajuan_dagulir->jangka_waktu,
                "ket_agunan" => $pengajuan_dagulir->ket_agunan,
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
                "jenis_badan_hukum" => $pengajuan_dagulir->jenis_badan_hukum,
                // "jenis_badan_hukum" => "Berbadan Hukum",
                "tempat_berdiri" => $pengajuan_dagulir->tempat_berdiri,
                "tanggal_berdiri" => $pengajuan_dagulir->tanggal_berdiri,
                "email" => $pengajuan_dagulir->email,
                "nama_pj" => $pengajuan_dagulir->nama_pj_ketua ??  null,
            ];
            $pengajuan_dagulir = Http::withHeaders([
                'Authorization' => 'Bearer ' .$data['token'],
            ])->post(config('dagulir.host').'/pengajuan.json', $body)->json();

            if (array_key_exists('data', $pengajuan_dagulir)) {
                if ($pengajuan_dagulir['data']['status_code'] == 200) {
                    $update_pengajuan_dagulir = PengajuanDagulir::find($pengajuan->dagulir_id);
                    $update_pengajuan_dagulir->kode_pendaftaran = $pengajuan_dagulir['data']['kode_pendaftaran'];
                    $update_pengajuan_dagulir->status = 1;
                    $update_pengajuan_dagulir->update();

                    // Log Pengajuan review
                    $dagulir = PengajuanDagulir::find($update_pengajuan_dagulir->dagulir_id);
                    $namaNasabah = 'undifined';

                    if ($dagulir)
                        $namaNasabah = $dagulir->nama;

                    // $role = Auth::user()->role;
                    // $this->logPengajuan->store($role . ' dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' mengirimkan data dagulir dengan pengajuan atas nama ' . $namaNasabah, $pengajuan->id, Auth::user()->id, Auth::user()->nip);

                    DB::commit();

                    $response = [
                        'status' => 'success',
                        'kode_pendaftaran' => $pengajuan_dagulir['data']['kode_pendaftaran'],
                    ];
                    return $response;
                }
                else {
                    return $pengajuan_dagulir['data']['message'];
                }
                // return redirect()->route('dagulir.index')->withStatus('Berhasil mengirimkan data.');
            }
            else {
                $message = 'Terjadi kesalahan.';
                if (array_key_exists('error', $pengajuan_dagulir)) $message .= ' '.$pengajuan_dagulir['error'];

                return $message;
                // return redirect()->route('dagulir.index')->withError($message);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            // return redirect()->route('dagulir.index')->withError($e->getMessage());
        }
    }

    private function getStatusBody($kode_pendaftaran, $status, $lampiran_analisa = null, $jangka_waktu = null, $realisasi_dana = null) {
        $body = [];
        if ($status == 1) {
            // Survei
            $body = [
                "kode_pendaftaran" => $kode_pendaftaran,
                "status" => $status,
                "lampiran_analisa" => "",
                "jangka_waktu" => "",
                "realisasi_dana" => ""
            ];
        }
        if ($status == 2) {
            // Analisa
            $body = [
                "kode_pendaftaran" => $kode_pendaftaran,
                "status" => $status,
                "lampiran_analisa" => $lampiran_analisa,
                "jangka_waktu" => "",
                "realisasi_dana" => ""
            ];
        }
        if ($status == 3) {
            // Disetujui
            $body = [
                "kode_pendaftaran" => $kode_pendaftaran,
                "status" => $status,
                "lampiran_analisa" => "",
                "jangka_waktu" => "",
                "realisasi_dana" => "",
            ];
        }
        if ($status == 4) {
            // Ditolak
            $body = [
                "kode_pendaftaran" => $kode_pendaftaran,
                "status" => $status,
                "lampiran_analisa" => "",
                "jangka_waktu" => "",
                "realisasi_dana" => "",
            ];
        }
        if ($status == 5) {
            // REALISASI KREDIT
            $body = [
                "kode_pendaftaran" => $kode_pendaftaran,
                "status" => $status,
                "lampiran_analisa" => "",
                "jangka_waktu" => $jangka_waktu,
                "realisasi_dana" => $realisasi_dana,
            ];
        }
        if ($status == 6) {
            // SELESAI
            $body = [
                "kode_pendaftaran" => $kode_pendaftaran,
                "status" => $status,
                "lampiran_analisa" => "",
                "jangka_waktu" => "",
                "realisasi_dana" => "",
            ];
        }
        if ($status == 7) {
            // DIBATALKAN
            $body = [
                "kode_pendaftaran" => $kode_pendaftaran,
                "status" => $status,
                "lampiran_analisa" => "",
                "jangka_waktu" => "",
                "realisasi_dana" => "",
            ];
        }
        if ($status == 8) {
            // DITINDAKLANJUTI
            $body = [
                "kode_pendaftaran" => $kode_pendaftaran,
                "status" => $status,
                "lampiran_analisa" => "",
                "jangka_waktu" => "",
                "realisasi_dana" => "",
            ];
        }

        return $body;
    }

    public function  updateStatus($kode_pendaftaran, $status, $lampiran_analisa = null, $jangka_waktu = null, $realisasi_dana = null) {
        $data = sipde_token();
        $body = $this->getStatusBody($kode_pendaftaran, $status, $lampiran_analisa = null, $jangka_waktu = null, $realisasi_dana = null);

        if (!empty($body)) {
            $host = config('dagulir.host');
            DB::beginTransaction();
            try {
                $pengajuan_dagulir = Http::withHeaders([
                    'Authorization' => 'Bearer ' .$data['token'],
                ])->post($host.'/update_status.json', $body)->json();

                if ($pengajuan_dagulir) {
                    if (array_key_exists('data', $pengajuan_dagulir)) {
                        $response = $pengajuan_dagulir['data'];
                        // Check status code
                        if (array_key_exists('status_code', $response)) {
                            if ($response['status_code'] == 200) {
                                // Update status
                                DB::table('pengajuan_dagulir')
                                ->where('kode_pendaftaran', $kode_pendaftaran)
                                ->update([
                                    'status' => $status,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);

                                DB::commit();
                                return $response['status_code'];
                            }
                            else {
                                return array_key_exists('message', $response) ? $response['message'] : 'failed';
                            }
                        }
                        return $response;
                    }
                    return $pengajuan_dagulir;
                }
                else {
                    return $pengajuan_dagulir;
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $e->getMessage();
            }
        }
        else {
            return 'empty body';
        }
    }

    public function getDocuments($id_pengajuan) {
        $result = [];
        ini_set('max_execution_time', '300');
        try {
            $pengajuan = PengajuanModel::with([
                                            'dagulir' => function($query) {
                                                $query->select('id', 'foto_nasabah');
                                            }
                                        ])
                                        ->select('id', 'dagulir_id', 'pk')
                                        ->find($id_pengajuan);
            $dagulir_id = $pengajuan->dagulir_id;
            // Foto nasabah
            $filename = $pengajuan->dagulir->foto_nasabah;
            $foto_nasabah = public_path("upload/$id_pengajuan/$dagulir_id/$filename");
            if (file_exists($foto_nasabah)) {
                $foto_nasabah_ext = explode('.', $filename)[1];
                $foto_nasabah_base64 = "data:@image/$foto_nasabah_ext;base64,".base64_encode(file_get_contents($foto_nasabah));
            }

            // Foto usaha
            $jawaban_usaha = JawabanTextModel::select('id', 'id_jawaban AS item_id', 'opsi_text AS file')
                                        ->where('id_pengajuan', $pengajuan->id)
                                        ->where('id_jawaban', 154) // Foto usaha item id
                                        ->orderBy('id')
                                        ->first();
            $foto_usaha_base64 = null;
            if ($jawaban_usaha) {
                $item_id = $jawaban_usaha->item_id;
                $filename = $jawaban_usaha->file;
                $foto_usaha = public_path("upload/$id_pengajuan/$item_id/$filename");
                if (file_exists($foto_usaha)) {
                    $foto_usaha_ext = explode('.', $filename)[1];
                    $foto_usaha_base64 = "data:@image/$foto_usaha_ext;base64,".base64_encode(file_get_contents($foto_usaha));
                }
            }

            // Foto agunan
            $jawaban_agunan = JawabanTextModel::select('id', 'id_jawaban AS item_id', 'opsi_text AS file')
                                        ->where('id_pengajuan', $pengajuan->id)
                                        ->where('id_jawaban', 148) // Foto agunan item id
                                        ->orderBy('id')
                                        ->first();
            $foto_agunan_base64 = null;
            if ($jawaban_agunan) {
                $item_id = $jawaban_agunan->item_id;
                $filename = $jawaban_agunan->file;
                $foto_agunan = public_path("upload/$id_pengajuan/$item_id/$filename");
                if (file_exists($foto_agunan)) {
                    $foto_agunan_ext = explode('.', $filename)[1];
                    $foto_agunan_base64 = "data:@image/$foto_agunan_ext;base64,".base64_encode(file_get_contents($foto_agunan));
                }
            }

            $result = [
                'foto_nasabah' => $foto_nasabah_base64,
                'foto_tempat_usaha' => $foto_usaha_base64,
                'foto_agunan' => $foto_agunan_base64,
            ];
            return $result;
        } catch (\Exception $e) {
            $result = [
                'status' => 'failed',
                'message' => $e->getMessage(),
            ];
            return $result;
        }
    }

    public function syaratDokumen($kode_pendaftaran, $file_pk_base64) {
        $dagulir = PengajuanDagulir::select('pengajuan_dagulir.id', 'p.id AS pengajuan_id')
                                    ->join('pengajuan AS p', 'p.dagulir_id', 'pengajuan_dagulir.id')
                                    ->where('pengajuan_dagulir.kode_pendaftaran', $kode_pendaftaran)
                                    ->first();
        if ($dagulir) {
            // Get foto
            $filesArr = $this->getDocuments($dagulir->pengajuan_id);
            if (array_key_exists('message', $filesArr)) {
                // Failed to get documents
                return $filesArr['message'];
            }
            else {
                if (!$filesArr['foto_nasabah']) {
                    return 'Foto nasabah tidak ditemukan';
                }
                else if (!$filesArr['foto_tempat_usaha']) {
                    return 'Foto tempat usaha tidak ditemukan';
                }
                else if (!$filesArr['foto_agunan']) {
                    return 'Foto agunan tidak ditemukan';
                }
                else {
                    $data = sipde_token();
                    $body = [
                        "kode_pendaftaran" => $kode_pendaftaran,
                        "foto_nasabah" => $filesArr['foto_nasabah'],
                        "foto_tempat_usaha" => $filesArr['foto_tempat_usaha'],
                        "foto_agunan" => $filesArr['foto_agunan'],
                        "akad_kredit" => $file_pk_base64, // PK
                    ];
                    if (!empty($body)) {
                        $host = config('dagulir.host');
                        try {
                            $upload_syarat = Http::withHeaders([
                                'Authorization' => 'Bearer ' .$data['token'],
                            ])->post($host.'/syarat_dokumen.json', $body)->json();

                            if ($upload_syarat) {
                                if (array_key_exists('data', $upload_syarat)) {
                                    $response = $upload_syarat['data'];
                                    // Check status code
                                    if (array_key_exists('status_code', $response)) {
                                        if ($response['status_code'] == 200) {
                                            // Update status
                                            return $response['status_code'];
                                        }
                                        else {
                                            return array_key_exists('message', $response) ? $response['message'] : 'failed';
                                        }
                                    }
                                    return $response;
                                }
                                if (array_key_exists('error', $upload_syarat)) {
                                    return 'API Error: '.$upload_syarat['error'];
                                }
                                return $upload_syarat;
                            }
                            else {
                                return $upload_syarat;
                            }
                        } catch (\Exception $e) {
                            DB::rollBack();
                            return $e->getMessage();
                        }
                    }
                    else {
                        return 'empty body';
                    }
                }
            }
        }
        else {
            return 'pengajuan tidak ditemukan';
        }
    }

    public function index(Request $request)
    {
        $id_cabang = Auth::user()->id_cabang;
        $id_user = Auth::user()->id;
        $param['cabang'] = DB::table('cabang')
            ->get();
        $role = auth()->user()->role;
        // paginate
        $search = $request->get('q');
        $limit = $request->has('page_length') ? $request->get('page_length') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        if ($role == 'Staf Analis Kredit') {
            $pengajuan_dagulir = $this->repo->get($search,$limit,$page, 'Staf Analis Kredit', $id_user);
        } elseif ($role == 'Penyelia Kredit') {
            $pengajuan_dagulir = $this->repo->get($search,$limit,$page, 'Penyelia Kredit', $id_user);
        } elseif ($role == 'Pincab') {
            $pengajuan_dagulir = $this->repo->get($search,$limit,$page, 'Pincab', $id_user);
        } else {
            $pengajuan_dagulir = $this->repo->get($search,$limit,$page, 'Staf Analis Kredit', $id_user);
        }

        // return $pengajuan_dagulir;
        return view('dagulir.index',[
            'data' => $pengajuan_dagulir
        ]);
    }

    public function sendToPincab(Request $request)
    {
        $id = $request->get('id_pengajuan');
        try {
            $pengajuan = PengajuanModel::find($id);
            $komentar = KomentarModel::where('id_pengajuan',$id)->first();
            if ($pengajuan) {
                if ($komentar->komentar_penyelia == null) {
                    alert()->warning('Waning','Data pengajuan belum di review,tidak dapat melanjutkan ke pincab.');
                    return redirect()->route('dagulir.index');
                }
                $pincab = User::select('id')
                        ->where('id_cabang', $pengajuan->id_cabang)
                        ->where('role', 'Pincab')
                        ->first();
                if ($pincab) {
                    $pengajuan->posisi = "Pincab";
                    $pengajuan->id_pincab = $pincab->id;
                    $pengajuan->tanggal_review_pincab = date('Y-m-d');
                    $pengajuan->update();

                    Alert::success('success', 'Berhasil mengganti posisi');
                    return redirect()->back();
                } else {
                    alert()->error('Error','User pincab tidak ditemukan pada cabang ini');

                    return redirect()->back();
                }
            } else {
                alert()->error('Error','Data pengajuan tidak ditemukan');
                return back()->withError('Data pengajuan tidak ditemukan.');
            }
        } catch (Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }

    public function accPengajuan($id, Request $request)
    {
        DB::beginTransaction();
        try {
            if (auth()->user()->role == 'Pincab') {
                $pengajuan = PengajuanModel::find($id);
                $currentPosisi = $pengajuan->posisi;
                $komentarPincab = KomentarModel::where('id_pengajuan', $id)->first();
                if ($pengajuan) {
                    $idKomentar = KomentarModel::where('id_pengajuan', $pengajuan->id)->first();
                    KomentarModel::where('id', $idKomentar->id)->update(
                        [
                            'komentar_pincab' => $request->pendapat_usulan,
                            'id_pincab' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                    $pengajuan->id_pincab = auth()->user()->id;
                    $pengajuan->tanggal_review_pincab = date('Y-m-d');
                    $pengajuan->posisi = "Selesai";
                    $pengajuan->tanggal_review_pincab = date(now());
                    $pengajuan->update();

                    $plafonUsulan = PlafonUsulan::where('id_pengajuan', $id)->first();
                    $plafon_acc = intval(str_replace('.','', $request->get('nominal_disetujui')));
                    $tenor_acc = intval($request->get('jangka_waktu_disetujui'));

                    if ($plafonUsulan) {
                        $plafonUsulan->plafon_usulan_pincab = $plafon_acc;
                        $plafonUsulan->jangka_waktu_usulan_pincab = $tenor_acc;
                        $plafonUsulan->updated_at = date('Y-m-d H:i:s');
                        $plafonUsulan->update();
                    }

                    $nasabah = PengajuanDagulir::select('kode_pendaftaran', 'status', 'nama', 'nominal', 'jangka_waktu')->find($pengajuan->dagulir_id);
                    $namaNasabah = 'undifined';
                    if ($nasabah)
                        $namaNasabah = $nasabah->nama;
                    // HIT Pengajuan endpoint dagulir
                    $storeSIPDE = $this->storeSipde($id);

                    $kode_pendaftaran = false;
                    if (is_array($storeSIPDE)) {
                        $kode_pendaftaran = array_key_exists('kode_pendaftaran', $storeSIPDE) ? $storeSIPDE['kode_pendaftaran'] : false;
                    }
                    $delay = 1500000; // 1.5 sec
                    if ($storeSIPDE == 'success' || $kode_pendaftaran) {
                        // HIT update status survei endpoint dagulir
                        $survei = $this->updateStatus($kode_pendaftaran, 1);
                        if ($currentPosisi == 'Pincab') {
                            if (is_array($survei)) {
                                // Fail block
                                if ($survei['message'] != 'Update Status Gagal. Anda tidak bisa mengubah status, karena status saat ini adalah SURVEY') {
                                    DB::rollBack();
                                    return redirect()->back()->withError($survei);
                                }
                            }
                            else {
                                if ($survei != 200) {
                                    DB::rollBack();
                                    return redirect()->back()->withError($survei);
                                }
                            }
                            usleep($delay);
                        }

                        // HIT update status analisa endpoint dagulir
                        if ($nasabah->status != 2) {
                            $lampiran_analisa = lampiranAnalisa();
                            $analisa = $this->updateStatus($kode_pendaftaran, 2, $lampiran_analisa);
                            if (is_array($analisa)) {
                                // Fail block
                                DB::rollBack();
                                return redirect()->back()->withError($analisa);
                            }
                            else {
                                if ($survei != 200 || $survei != '200') {
                                    DB::rollBack();
                                    return redirect()->back()->withError($analisa);
                                }
                            }
                            usleep($delay);
                        }

                        // HIT update status disetujui endpoint dagulir
                        if ($nasabah->status != 3) {
                            $setuju = $this->updateStatus($kode_pendaftaran, 3);
                            if (is_array($setuju)) {
                                // Fail block
                                DB::rollBack();
                                return redirect()->back()->withError($setuju);
                            }
                            else {
                                if ($setuju != 200) {
                                    DB::rollBack();
                                    return redirect()->back()->withError($setuju);
                                }
                            }
                        }

                        DB::commit();
                        event(new EventMonitoring('menyetujui pengajuan'));
                        Alert::success('success', 'Berhasil menyetujui pengajuan');
                        return redirect()->route('dagulir.index')->withStatus('Berhasil menyetujui pengajuan.');
                    }
                    else {
                        DB::rollBack();

                        return redirect()->back()->withError($storeSIPDE);
                    }
                }
                else {
                    return 'Data pengajuan tidak ditemukan.';
                    return redirect()->back()->withError('Data pengajuan tidak ditemukan.');
                }
            } else {
                alert()->error('Error','Tidak memiliki hak akses');
                return redirect()->back()->withError('Tidak memiliki hak akses.');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function decPengajuan($id)
    {
        DB::beginTransaction();
        try {
            $pengajuan = PengajuanModel::find($id);
            $currentPosisi = $pengajuan->posisi;
            $komentarPincab = KomentarModel::where('id_pengajuan', $id)->first();
            if (auth()->user()->role == 'Pincab') {
                if ($komentarPincab->komentar_pincab != null) {
                    $pengajuan->posisi = "Ditolak";
                    $pengajuan->tanggal_review_pincab = date(now());
                    $pengajuan->update();

                    $nasabah = PengajuanDagulir::select('nama')->find($pengajuan->dagulir_id);
                    $delay = 1500000; // 1.5 sec

                    // HIT update status survei endpoint dagulir
                    $survei = $this->updateStatus($nasabah->kode_pendaftaran, 1);
                    if ($currentPosisi == 'Pincab') {
                        if (is_array($survei)) {
                            // Fail block
                            if ($survei['message'] != 'Update Status Gagal. Anda tidak bisa mengubah status, karena status saat ini adalah SURVEY') {
                                DB::rollBack();
                                return redirect()->back()->withError($survei);
                            }
                        }
                        else {
                            if ($survei != 200) {
                                DB::rollBack();
                                return redirect()->back()->withError($survei);
                            }
                        }
                        usleep($delay);
                    }

                    // HIT update status analisa endpoint dagulir
                    if ($nasabah->status != 2) {
                        $lampiran_analisa = lampiranAnalisa();
                        $analisa = $this->updateStatus($nasabah->kode_pendaftaran, 2, $lampiran_analisa);
                        if (is_array($analisa)) {
                            // Fail block
                            DB::rollBack();
                            return redirect()->back()->withError($analisa);
                        }
                        else {
                            if ($survei != 200 || $survei != '200') {
                                DB::rollBack();
                                return redirect()->back()->withError($analisa);
                            }
                        }
                        usleep($delay);
                    }

                    // HIT update status ditolak endpoint dagulir
                    if ($nasabah->status != 3) {
                        $ditolak = $this->updateStatus($nasabah->kode_pendaftaran, 3);
                        if (is_array($ditolak)) {
                            // Fail block
                            DB::rollBack();
                            return redirect()->back()->withError($ditolak);
                        }
                        else {
                            if ($ditolak != 200) {
                                DB::rollBack();
                                return redirect()->back()->withError($ditolak);
                            }
                        }
                    }

                    $namaNasabah = 'undifined';
                    if ($nasabah)
                        $namaNasabah = $nasabah->nama;

                    $this->logPengajuan->store('Pincab dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' menolak pengajuan atas nama ' . $namaNasabah . '.', $id, Auth::user()->id, Auth::user()->nip);

                    DB::commit();

                    event(new EventMonitoring('tolak pengajuan'));
                    Alert::success('success', 'Berhasil menolak pengajuan');
                    return redirect()->route('dagulir.index');
                } else {
                    alert()->error('Error','Belum di review Pincab');
                    return redirect()->back()->withError('Belum di review Pincab.');
                }
            } else {
                alert()->error('Error','Tidak memiliki hak akses');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    function CetakPDF($id) {
        $pengajuan = PengajuanModel::find($id);
        $param['dataAspek'] = ItemModel::select('*')->where('level',1)->get();
        $param['dataNasabah'] = PengajuanDagulir::find($pengajuan->dagulir_id);
        $param['dataUmum'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang', 'pengajuan.skema_kredit')->find($id);
        $param['komentar'] = KomentarModel::where('id_pengajuan', $id)->first();

        $param['jenis_usaha'] = config('dagulir.jenis_usaha');


        $pdf = Pdf::loadview('dagulir.pengajuan-kredit.cetak.cetak-surat',$param);

        $fileName =  time().'.'. 'pdf' ;
        $pdf->save(public_path() . '/' . $fileName);

        $pdf = public_path($fileName);
        $file = "data:@file/pdf;base64,".base64_encode(file_get_contents($pdf));

        // remove white space
        $result = trim($file, "\n\r\t\v\x00");
        return $result;
    }
    function CetakPK($id) {
        $count = DB::table('log_cetak_kkb')
        ->where('id_pengajuan', $id)
        ->count('tgl_cetak_pk');
        if ($count < 1) {
            DB::table('log_cetak_kkb')
            ->where('id_pengajuan', $id)
            ->update([
                'tgl_cetak_pk' => now()
            ]);
        }

        $dataNasabah = DB::table('pengajuan_dagulir')->select('pengajuan_dagulir.*', 'kabupaten.id as kabupaten_id', 'kabupaten.kabupaten', 'kecamatan.id as kecamatan_id', 'kecamatan.id_kabupaten', 'kecamatan.kecamatan', 'desa.id as desa_id', 'desa.id_kabupaten', 'desa.id_kecamatan', 'desa.desa', 'pengajuan.*')
        ->join('kabupaten', 'kabupaten.id', 'pengajuan_dagulir.kotakab_ktp')
        ->join('kecamatan', 'kecamatan.id', 'pengajuan_dagulir.kec_ktp')
        ->join('desa', 'desa.id', 'pengajuan_dagulir.desa_ktp')
        ->join('pengajuan', 'pengajuan.dagulir_id', 'pengajuan_dagulir.id')
        ->where('pengajuan.id', $id)
        ->first();

        $param['dataNasabah'] = $dataNasabah;

        $param['dataUmum'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang')
        ->find($id);

        $param['dataCabang'] = DB::table('cabang')
            ->where('id', $param['dataUmum']->id_cabang)
            ->first();

        $param['tglCetak'] = DB::table('log_cetak_kkb')
        ->where('id_pengajuan', $id)
        ->first();

        $kodePincab = $dataNasabah->id_pincab;
        $kodePenyelia = $dataNasabah->id_penyelia;
        $param['dataPincab'] = User::where('id', $kodePincab)->get();
        $param['dataPenyelia'] = User::where('id', $kodePenyelia)->get();

        $indexBulan = intval(date('m', strtotime($param['tglCetak']->tgl_cetak_pk))) - 1;
        $param['tgl'] = date('d', strtotime($param['tglCetak']->tgl_cetak_pk)) . ' ' . $this->bulan[$indexBulan] . ' ' . date('Y', strtotime($param['tglCetak']->tgl_cetak_pk));

        $param['installment'] = DB::table('jawaban_text')
        ->where('id_pengajuan', $id)
        ->where('id_jawaban', 140)
        ->first() ?? '0';

        return view('dagulir.cetak.cetak-pk', $param);
    }
    public function cetakSPPk($id)
    {
        $count = DB::table('log_cetak_kkb')
        ->where('id_pengajuan', $id)
            ->count('*');
        if ($count < 1) {
            DB::table('log_cetak_kkb')
            ->insert([
                'id_pengajuan' => $id,
                'tgl_cetak_sppk' => now()
            ]);
        } else {
            DB::table('log_cetak_kkb')
            ->where('id_pengajuan', $id)
                ->update([
                    'tgl_cetak_sppk' => now()
                ]);
        }

        $dataNasabah = DB::table('pengajuan_dagulir')->select('kabupaten.id as kabupaten_id', 'kabupaten.kabupaten', 'kecamatan.id as kecamatan_id', 'kecamatan.id_kabupaten', 'kecamatan.kecamatan', 'desa.id as desa_id', 'desa.id_kabupaten', 'desa.id_kecamatan', 'desa.desa', 'pengajuan_dagulir.*', 'pengajuan.*')
        ->join('kabupaten', 'kabupaten.id', 'pengajuan_dagulir.kotakab_ktp')
        ->join('kecamatan', 'kecamatan.id', 'pengajuan_dagulir.kec_ktp')
        ->join('desa', 'desa.id', 'pengajuan_dagulir.desa_ktp')
        ->join('pengajuan', 'pengajuan.dagulir_id', 'pengajuan_dagulir.id')
        ->where('pengajuan.id', $id)
        ->first();
        // return $dataNasabah;
        $param['dataNasabah'] = $dataNasabah;

        $dataUmum =
        DB::table('pengajuan_dagulir')->select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang')
        ->join('pengajuan', 'pengajuan.dagulir_id', 'pengajuan_dagulir.id')
        ->where('pengajuan.id', $id)
        ->first();
        // return $dataUmum;
        $param['dataUmum'] = $dataUmum;


        $param['dataCabang'] = DB::table('cabang')
                ->where('id', $dataUmum->id_cabang)
                ->first();

        $tglCetak = DB::table('log_cetak_kkb')
        ->where('id_pengajuan', $id)
        ->first();
        $param['tglCetak'] = $tglCetak;

        $kodePincab = $dataNasabah->id_pincab;
        $kodePenyelia = $dataNasabah->id_penyelia;
        $param['dataPincab'] = User::where('id', $kodePincab)->get();
        $param['dataPenyelia'] = User::where('id', $kodePenyelia)->get();

        $indexBulan = intval(date('m', strtotime($param['tglCetak']->tgl_cetak_sppk))) - 1;
        $param['tgl'] = date('d', strtotime($param['tglCetak']->tgl_cetak_sppk)) . ' ' . $this->bulan[$indexBulan] . ' ' . date('Y', strtotime($param['tglCetak']->tgl_cetak_sppk));

        $param['installment'] = DB::table('jawaban_text')
        ->where('id_pengajuan', $id)
            ->where('id_jawaban', 140)
            ->first() ?? '0';

        return view('dagulir.cetak.cetak-sppk', $param);
    }

    public function kembalikanDataKePosisiSebelumnya(Request $request){
        DB::beginTransaction();
        try{
            $dataPengajuan = PengajuanModel::find($request->id_pengajuan);
            $alasan = $request->alasan;
            $dari = $dataPengajuan->posisi;
            $ke = '';
            $backto = $request->backto;

            if ($backto == 'staf') {
                $ke = 'Proses Input Data';
            }
            else if ($backto == 'penyelia') {
                $ke = 'Review Penyelia';
            }
            else if ($backto == 'pbo') {
                $ke = 'PBO';
            }
            else if ($backto == 'pbp') {
                $ke = 'PBP';
            }

            if ($ke != '') {
                $dataPengajuan->posisi = $ke;
                $dataPengajuan->save();
    
                AlasanPengembalianData::insert([
                    'id_pengajuan' => $dataPengajuan->id,
                    'id_user' => auth()->user()->id,
                    'dari' => $dari,
                    'ke' => $ke,
                    'alasan' => $alasan,
                    'created_at' => now()
                ]);
                DB::commit();

                event(new EventMonitoring('kembalikan data pengajuan'));
                return redirect()->back()->withStatus('Berhasil mengembalikan data ke ' . $ke . '.');
            }
            else{
                return redirect()->back()->withError('Data tidak ditemukan');
            }
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan. ' . $e->getMessage());
        } catch(QueryException $e){
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan. ' . $e->getMessage());
        }
    }

    public function postFileDagulir(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $message = null;
            switch ($request->tipe_file) {
                // File SPPK Handler
                case 'SPPK':
                    $message = 'File SPPK berhasil diupload';
                    $folderSPPK = public_path() . '/upload/' . $id . '/sppk/';
                    $fileSPPK = $request->sppk;
                    $filenameSPPK = date('YmdHis') . '.' . $fileSPPK->getClientOriginalExtension();
                    $pathSPPK = realpath($folderSPPK);
                    if (!($pathSPPK !== true and is_dir($pathSPPK))) {
                        mkdir($folderSPPK, 0755, true);
                    }
                    $fileSPPK->move($folderSPPK, $filenameSPPK);
                    DB::table('pengajuan')
                        ->where('id', $id)
                        ->update([
                            'sppk' => $filenameSPPK
                        ]);
                    DB::commit();
                    Alert::success('success', $message);
                    return redirect()->route('dagulir.pengajuan.index');
                    break;
                    // File PK Handler
                case 'PK':
                    $message = 'File PK berhasil diupload';
                    $kode_pendaftaran = $request->get('kode_pendaftaran');
                    $folderPK = public_path() . '/upload/' . $id . '/pk/';
                    $filePK = $request->pk;
                    $filenamePK = date('YmdHis') . '.' . $filePK->getClientOriginalExtension();
                    $mime = $filePK->getClientMimeType();
                    $file_pk_base64 = "data:$mime;base64,".base64_encode(file_get_contents($filePK));
                    $pathPK = realpath($folderPK);
                    if (!($pathPK !== true and is_dir($pathPK))) {
                        mkdir($folderPK, 0755, true);
                    }
                    $filePK->move($folderPK, $filenamePK);
                    DB::table('log_cetak_kkb')
                    ->where('id_pengajuan', $id)
                    ->update([
                        'no_pk' => $request->get('no_pk'),
                        'no_loan' => $request->get('no_loan'),
                    ]);
                    DB::table('pengajuan')
                    ->where('id', $id)
                        ->update([
                            'pk' => $filenamePK,
                    ]);
                    $realisasi = $this->updateStatus($kode_pendaftaran, 5);

                    if (is_array($realisasi)) {
                        DB::rollBack();
                        alert()->error('Terjadi Kesalahan', json_encode($realisasi));
                        return redirect()->back();
                    }
                    else {
                        if ($realisasi == 200) {
                            // Realisasi (Upload dokumen)
                            $upload = $this->syaratDokumen($kode_pendaftaran, $file_pk_base64);
                            if (!is_array($upload)) {
                                if ($upload == 200) {
                                    // Update to SELESAI
                                    $update_selesai = $this->updateStatus($kode_pendaftaran, 6);
                                    if (!is_array($update_selesai)) {
                                        if ($update_selesai == 200) {
                                            DB::commit();
                                            Alert::success('success', $message);
                                            return redirect()->route('dagulir.pengajuan.index');
                                        }
                                    }
                                    else {
                                        DB::rollBack();
                                        alert()->error('Terjadi Kesalahan', $update_selesai);
                                        return redirect()->back();
                                    }
                                }
                                else {
                                    DB::rollBack();
                                    alert()->error('Terjadi Kesalahan', $upload);
                                    return redirect()->back();
                                }
                            }
                            else {
                                DB::rollBack();
                                alert()->error('Terjadi Kesalahan', $upload);
                                return redirect()->back();
                            }
                        }
                        else {
                            DB::rollBack();
                            alert()->error('Terjadi Kesalahan', $realisasi);
                            return redirect()->back();
                        }
                    }
                    break;
            }
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Terjadi Kesalahan', $e->getMessage());
            return redirect()->route('dagulir.pengajuan.index');
        } catch (QueryException $e) {
            DB::rollBack();
            alert()->error('Terjadi Kesalahan', $e->getMessage());
            return redirect()->route('dagulir.pengajuan.index');
        }
    }

    public function cetakDagulir($id)
    {
        $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->get();
        $dataNasabah = DB::table('pengajuan_dagulir')->select('pengajuan_dagulir.*', 'kabupaten.id as kabupaten_id', 'kabupaten.kabupaten', 'kecamatan.id as kecamatan_id', 'kecamatan.id_kabupaten', 'kecamatan.kecamatan', 'desa.id as desa_id', 'desa.id_kabupaten', 'desa.id_kecamatan', 'desa.desa')
        ->join('kabupaten', 'kabupaten.id', 'pengajuan_dagulir.kotakab_ktp')
        ->join('kecamatan', 'kecamatan.id', 'pengajuan_dagulir.kec_ktp')
        ->join('desa', 'desa.id', 'pengajuan_dagulir.desa_ktp')
        ->join('pengajuan', 'pengajuan.dagulir_id', 'pengajuan_dagulir.id')
        ->where('pengajuan.id', $id)
        ->first();
        $param['dataNasabah'] = $dataNasabah;
        $param['dataUmum'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang', 'pengajuan.skema_kredit')
        ->find($id);
        $param['komentar'] = KomentarModel::where('id_pengajuan', $id)->first();
        $param['jenis_usaha'] = config('dagulir.jenis_usaha');

        return view('dagulir.cetak.cetak-surat', $param);
    }

    public function edit($id) {
        /**
         * 1. Load Data Umum
         * 2. Load Data per Aspek (include jawaban)
        */
        $pengajuanRepo = new PengajuanRepository;
        $data = $pengajuanRepo->getWithJawaban($id);
        $param['dataPengajuan'] = $data;

        $param['dataKabupaten'] = Kabupaten::all();
        $param['dataKecamatan'] = Kecamatan::where('id_kabupaten', $data->dagulir->kotakab_ktp)->get();
        $param['dataDesa'] = Desa::where('id_kecamatan', $data->dagulir->kec_ktp)->get();
        $param['dataKecamatanDomisili'] = Kecamatan::where('id_kabupaten', $data->dagulir->kotakab_dom)->get();
        $param['dataKecamatanUsaha'] = Kecamatan::where('id_kabupaten', $data->dagulir->kotakab_usaha)->get();
        $dataAspek = ItemModel::select('*')->where('level', 1)->where('nama', '!=', 'Data Umum')->get();
        foreach ($dataAspek as $key => $value) {
            // Pendapat per aspek
            $pendapat = PendapatPerAspek::select('id', 'pendapat_per_aspek')->where('id_pengajuan', $id)
                                        ->whereNotNull('id_staf')
                                        ->where('id_aspek', $value->id)
                                        ->first();
            $value->pendapat = $pendapat;
            // check level 2
            $dataLevelDua = ItemModel::where('level', 2)
                                    ->where('id_parent', $value->id)
                                    ->get();
            
            foreach ($dataLevelDua as $key2 => $lev2) {
                // Get jawaban text
                $jawaban = JawabanTextModel::where('id_pengajuan', $id)
                                                ->where('id_jawaban', $lev2->id)
                                                ->first();
                $lev2->jawaban = $jawaban;
                // Get jawaban option
                $dataJawaban = OptionModel::where('option', '!=', '-')
                                            ->where('id_item', $lev2->id)
                                            ->get();
                foreach ($dataJawaban as $answer) {
                    $jawaban = JawabanModel::where('id_pengajuan', $id)
                                            ->where('id_jawaban', $answer->id)
                                            ->first();
                    $answer->jawaban = $jawaban;
                }
                $dataOption = OptionModel::where('option', '=', '-')
                    ->where('id_item', $lev2->id)
                    ->get();
                // check level 3
                $dataLevelTiga = ItemModel::where('level', 3)
                    ->where('id_parent', $lev2->id)
                    ->get();

                foreach ($dataLevelTiga as $lev3) {
                    // Get jawaban text
                    $jawaban = JawabanTextModel::where('id_pengajuan', $id)
                                                ->where('id_jawaban', $lev3->id)
                                                ->first();
                    $lev3->jawaban = $jawaban;

                    // check jawaban level tiga
                    $dataJawabanLevelTiga = OptionModel::where('option', '!=', '-')
                                                        ->where('id_item', $lev3->id)
                                                        ->get();
                    foreach ($dataJawabanLevelTiga as $answer) {
                        $jawaban = JawabanModel::where('id_pengajuan', $id)
                                        ->where('id_jawaban', $answer->id)
                                        ->first();
                        $answer->jawaban = $jawaban;
                    }
                    $dataOptionTiga = OptionModel::where('option', '=', '-')
                                                ->where('id_item', $lev3->id)
                                                ->get();

                    // check level empat
                    $dataLevelEmpat = ItemModel::where('level', 4)
                                            ->where('id_parent', $lev3->id)
                                            ->get();
                    foreach ($dataLevelEmpat as $lev4) {
                        $jawaban = JawabanTextModel::where('id_pengajuan', $id)
                                                    ->where('id_jawaban', $lev4->id)
                                                    ->first();
                        $lev4->jawaban = $jawaban;
                        // check level empat
                        $dataJawabanLevelEmpat = OptionModel::where('option', '!=', '-')
                                                            ->where('id_item', $lev4->id)
                                                            ->get();
                        foreach ($dataJawabanLevelEmpat as $answer) {
                            $jawaban = JawabanModel::where('id_pengajuan', $id)
                                            ->where('id_jawaban', $answer->id)
                                            ->first();
                            $answer->jawaban = $jawaban;
                        }
                        $dataOptionEmpat = OptionModel::where('option', '=', '-')
                                                        ->where('id_item', $lev4->id)
                                                        ->get();
                        $lev4->dataJawabanLevelEmpat = $dataJawabanLevelEmpat;
                        $lev4->dataOptionEmpat = $dataOptionEmpat;
                    }

                    $lev3->dataJawabanLevelTiga = $dataJawabanLevelTiga;
                    $lev3->dataOptionTiga = $dataOptionTiga;
                    $lev3->dataLevelEmpat = $dataLevelEmpat;
                }

                $lev2->dataJawaban = $dataJawaban;
                $lev2->dataOption = $dataOption;
                $lev2->dataLevelTiga = $dataLevelTiga;
            }

            $value->dataLevelDua = $dataLevelDua;
        }

        $param['pendapat'] = KomentarModel::select('id', 'komentar_staff')
                                        ->where('id_pengajuan', $id)
                                        ->orderBy('id', 'DESC')
                                        ->first();
        $param['dataAspek'] = $dataAspek;
        $param['itemSlik'] = ItemModel::with('option')->where('nama', 'SLIK')->first();
        $param['itemSP'] = ItemModel::where('nama', 'Surat Permohonan')->first();
        $param['itemP'] = ItemModel::where('nama', 'Laporan SLIK')->first();
        $param['itemKTPNas'] = ItemModel::where('nama', 'Foto KTP Nasabah')->first();
        $param['itemNIB'] = ItemModel::where('nama', 'Dokumen NIB')->first();
        if ($param['itemNIB']) {
            $jawaban = JawabanTextModel::where('id_pengajuan', $id)
                                        ->where('id_jawaban', $param['itemNIB']->id)
                                        ->first();
            $param['itemNIB']->jawaban = $jawaban;
        }
        $param['itemNPWP'] = ItemModel::where('nama', 'Dokumen NPWP')->first();
        if ($param['itemNPWP']) {
            $jawaban = JawabanTextModel::where('id_pengajuan', $id)
                                        ->where('id_jawaban', $param['itemNPWP']->id)
                                        ->first();
            $param['itemNPWP']->jawaban = $jawaban;
        }
        $param['itemSKU'] = ItemModel::where('nama', 'Dokumen Surat Keterangan Usaha')->first();
        if ($param['itemSKU']) {
            $jawaban = JawabanTextModel::where('id_pengajuan', $id)
                                        ->where('id_jawaban', $param['itemSKU']->id)
                                        ->first();
            $param['itemSKU']->jawaban = $jawaban;
        }
        $param['jawabanSlik'] = JawabanModel::select('id', 'id_jawaban', 'skor')
                                            ->where('id_pengajuan', $id)
                                            ->whereIn('id_jawaban', [71,72,73,74])
                                            ->first();
        $param['jawabanLaporanSlik'] = \App\Models\JawabanTextModel::where('id_pengajuan', $data->id)
                                            ->where('id_jawaban', 146)
                                            ->first();
        $param['dataDetailJawaban'] = JawabanPengajuanModel::select('id', 'id_jawaban')
                                                ->where('id_pengajuan', $id)
                                                ->get();
        $param['jenis_usaha'] = config('dagulir.jenis_usaha');
        $param['tipe'] = config('dagulir.tipe_pengajuan');

        return view('dagulir.pengajuan-kredit.edit-pengajuan-kredit', $param);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $updatePengajuan = PengajuanModel::find($id);
            $dagulir = PengajuanDagulir::find($updatePengajuan->dagulir_id);
            $uniqueEmail = $request->get('email') != '' && $request->get('email') != $dagulir->email ? '|unique:pengajuan_dagulir,email' : '';
            $uniqueNIK = $request->get('nik_nasabah') != '' && $request->get('nik_nasabah') != $dagulir->nik ? '|unique:pengajuan_dagulir,nik' : '';
            $uniqueTelp = $request->get('telp') != '' && $request->get('telp') != $dagulir->telp ? '|unique:pengajuan_dagulir,telp' : '';
            $find = array('Rp.', '.', ',');
            $request->validate([
                'nama_lengkap' => 'required',
                'email' => 'required'.$uniqueEmail,
                'nik_nasabah' => 'required'.$uniqueNIK,
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'telp' => 'required'.$uniqueTelp,
                'jenis_usaha' => 'required',
                'nominal_pengajuan' => 'required',
                'tujuan_penggunaan' => 'required',
                'jangka_waktu' => 'required',
                'status' => 'required|not_in:0',
                'desa' => 'required|not_in:0',
                'kecamatan_sesuai_ktp' => 'required|not_in:0',
                'kode_kotakab_ktp' => 'required|not_in:0',
                'alamat_sesuai_ktp' => 'required',
                'kecamatan_domisili' => 'required|not_in:0',
                'kode_kotakab_domisili' => 'required|not_in:0',
                'alamat_domisili' => 'required',
                'kecamatan_usaha' => 'required|not_in:0',
                'kode_kotakab_usaha' => 'required|not_in:0',
                'alamat_usaha' => 'required',
                'tipe_pengajuan' => 'required|not_in:0',
                'jenis_badan_hukum' => 'required|not_in:0',
                'ket_agunan' => 'required|not_in:0'
            ]);
            $updatePengajuan->id_cabang = auth()->user()->id_cabang;
            $updatePengajuan->progress_pengajuan_data = $request->progress;
            $updatePengajuan->save();
            $id_pengajuan = $updatePengajuan->id;

            $find = array('Rp.', '.', ',');

            $dagulir->kode_pendaftaran = null;
            $dagulir->nama = $request->get('nama_lengkap');
            $dagulir->email = $request->get('email');
            $dagulir->nik = $request->get('nik_nasabah');
            $dagulir->nama_pj_ketua = $request->has('nama_pj') ? $request->get('nama_pj') : null;
            $dagulir->tempat_lahir =  $request->get('tempat_lahir');
            $dagulir->tanggal_lahir = $request->get('tanggal_lahir');
            $dagulir->telp = $request->get('telp');
            $dagulir->jenis_usaha = $request->get('jenis_usaha');
            $dagulir->ket_agunan = $request->get('ket_agunan');
            $dagulir->hubungan_bank = $request->get('hub_bank');
            $dagulir->hasil_verifikasi = $request->get('hasil_verifikasi');
            $dagulir->nominal = formatNumber($request->get('nominal_pengajuan'));
            $dagulir->tujuan_penggunaan = $request->get('tujuan_penggunaan');
            $dagulir->jangka_waktu = $request->get('jangka_waktu');
            $dagulir->kode_bank_pusat = 1;
            $dagulir->kode_bank_cabang = auth()->user()->id_cabang;
            $dagulir->desa_ktp = $request->get('desa');
            $dagulir->kec_ktp = $request->get('kecamatan_sesuai_ktp');
            $dagulir->kotakab_ktp = $request->get('kode_kotakab_ktp');
            $dagulir->alamat_ktp = $request->get('alamat_sesuai_ktp');
            $dagulir->kec_dom = $request->get('kecamatan_domisili');
            $dagulir->kotakab_dom = $request->get('kode_kotakab_domisili');
            $dagulir->alamat_dom = $request->get('alamat_domisili');
            $dagulir->kec_usaha = $request->get('kecamatan_usaha');
            $dagulir->kotakab_usaha = $request->get('kode_kotakab_usaha');
            $dagulir->alamat_usaha = $request->get('alamat_usaha');
            $dagulir->tipe = $request->get('tipe_pengajuan');
            $npwp = null;
            if ($request->informasi) {
                if (array_key_exists('79', $request->informasi)) {
                    $npwp = str_replace(['.','-'], '', $request->informasi[79]);
                }
            }
            $dagulir->npwp = $npwp;
            $dagulir->jenis_badan_hukum = $request->get('jenis_badan_hukum');
            $dagulir->tempat_berdiri = $request->get('tempat_berdiri');
            $dagulir->tanggal_berdiri = $request->get('tanggal_berdiri');
            $dagulir->tanggal = now();
            $dagulir->user_id = Auth::user()->id;
            $dagulir->status = 8;
            $dagulir->status_pernikahan = $request->get('status');
            $dagulir->nik_pasangan = $request->has('nik_pasangan') ? $request->get('nik_pasangan') : null;
            $dagulir->created_at = now();
            $dagulir->from_apps = 'pincetar';
            $dagulir->save();

            $finalArray = array();
            $finalArray_text = array();
            $rata_rata = array();

            if (!isset($request->id_kategori_jaminan_tambahan)) {
                $dataJawabanText = new JawabanTextModel;
                $dataJawabanText->id_jawaban = 110;
                $dataJawabanText->id_pengajuan = $id_pengajuan;
                $dataJawabanText->opsi_text = $request->kategori_jaminan_tambahan;
                $dataJawabanText->save();
            } else {
                $dataJawabanText = JawabanTextModel::where('id_pengajuan', $id_pengajuan)
                                                    ->where('id', $request->id_kategori_jaminan_tambahan)
                                                    ->first();
                if ($dataJawabanText) {
                    $dataJawabanText->opsi_text = $request->kategori_jaminan_tambahan;
                    $dataJawabanText->save();
                }
            }

            if ($request->ijin_usaha == 'tidak_ada_legalitas_usaha') {
                $dokumenUsaha = DB::table('item')
                    ->where('nama', 'LIKE', '%NIB%')
                    ->orWhere('nama', 'LIKE', '%Surat Keterangan Usaha%')
                    ->orWhere('nama', 'LIKE', '%NPWP%')
                    ->get();
                foreach ($dokumenUsaha as $idDoc) {
                    DB::table('jawaban_text')
                        ->where('id_pengajuan', $id_pengajuan)
                        ->where('id_jawaban', $idDoc->id)
                        ->delete();
                }
            }
            if ($request->isNpwp == 0) {
                $dokumenUsaha = DB::table('item')
                    ->orWhere('nama', 'LIKE', '%NPWP%')
                    ->get();
                foreach ($dokumenUsaha as $idDoc) {
                    DB::table('jawaban_text')
                        ->where('id_pengajuan', $id_pengajuan)
                        ->where('id_jawaban', $idDoc->id)
                        ->delete();
                }
            }
            // ijin usaha
            $jawabanIjinUsaha = JawabanTextModel::where('id_pengajuan', $id_pengajuan)->where('id_jawaban', 76)->first();
            if ($jawabanIjinUsaha) {
                $jawabanIjinUsaha->id_pengajuan = $id_pengajuan;
                $jawabanIjinUsaha->id_jawaban =  76;
                $jawabanIjinUsaha->opsi_text = $request->ijin_usaha;
                $jawabanIjinUsaha->save();
            }
            else {
                $dataJawabanText = new JawabanTextModel;
                $dataJawabanText->id_pengajuan = $id_pengajuan;
                $dataJawabanText->id_jawaban =  76;
                $dataJawabanText->opsi_text = $request->ijin_usaha;
                $dataJawabanText->save();
            }

            if (count($request->file()) > 0) {
                foreach ($request->file('update_file') as $key => $value) {
                    if (
                        str_contains($value->getMimeType(), 'text') ||
                        str_contains($value->getMimeType(), 'x-empty')
                    ) continue;

                    if ($request->id_update_file[$key] != null) {
                        $image = $value;
                        $imageName = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();

                        $imageLama = JawabanTextModel::where('id_jawaban', $request->get('id_update_file')[$key])
                            ->select('opsi_text', 'id_jawaban')
                            ->where('opsi_text', '!=', null)
                            ->orderBy('id', 'desc')
                            ->get();
                        // return $imageLama;
                        foreach ($imageLama as $imageKey => $imageValue) {
                            $pathLama = public_path() . '/upload/' . $id_pengajuan . '/' . $imageValue->id_jawaban . '/' . $imageValue->opsi_text;
                            File::delete($pathLama);
                        }

                        $filePath = public_path() . '/upload/' . $id_pengajuan . '/' . $request->id_file_text[$key];
                        // $filePath = public_path() . '/upload';
                        if (!File::isDirectory($filePath)) {
                            File::makeDirectory($filePath, 493, true);
                        }

                        $image->move($filePath, $imageName);

                        $imgUpdate = DB::table('jawaban_text');
                        $imgUpdate->where('id', $request->get('id_update_file')[$key])->update(['opsi_text' => $imageName]);
                    } else {
                        $image = $request->file('update_file')[$key];
                        $imageName = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();

                        $filePath = public_path() . '/upload/' . $id_pengajuan . '/' . $request->id_file_text[$key];

                        if (!File::isDirectory($filePath)) {
                            File::makeDirectory($filePath, 493, true);
                        }

                        $image->move($filePath, $imageName);

                        $dataJawabanText = new JawabanTextModel;
                        $dataJawabanText->id_pengajuan = $id_pengajuan;
                        $dataJawabanText->id_jawaban =  $request->id_file_text[$key];
                        $dataJawabanText->opsi_text = $imageName;
                        $dataJawabanText->save();
                    }
                }
            }

            // Delete multiple deleted file
            array_map(
                fn ($fileId) => JawabanTextModel::find($fileId)?->delete(),
                $request->id_delete_file ?? []
            );

            foreach ($request->id_jawaban_text as $key => $value) {
                if ($value) {
                    if (array_key_exists($key, $request->informasi) && array_key_exists($key, $request->id_text)) {
                        if ($request->id_jawaban_text[$key] != null && $request->informasi[$key] != null) {
                            if ($request->informasi[$key] == null) continue;
    
                            if ($request->id_jawaban_text[$key] == null && $request->informasi[$key] != null) {
                                if (isset($request->id_text[$key]) && isset($request->informasi[$key])) {
                                    // dd($request->id_jawaban_text)
                                    $data_baru = new JawabanTextModel();
                                    $data_baru->id_pengajuan = $id_pengajuan;
                                    $data_baru->id_jawaban = $request->id_text[$key];
                                    if ($request->id_text[$key] == '131' || $request->id_text[$key] == '143' || $request->id_text[$key] == '90' || $request->id_text[$key] == '138') {
                                        $data_baru->opsi_text = $request->informasi[$key];
                                    } else {
                                        $data_baru->opsi_text = str_replace($find, "", $request->informasi[$key]);
                                    }
                                    $data_baru->skor_penyelia = null;
                                    $data_baru->skor = null;
                                    $data_baru->save();
                                }
                            } else {
                                $skor[$key] = $request->skor_penyelia_text[$key];
                                // ccd
                                // ddd($request->id_text[27]);
                                if (isset($request->id_text[$key]) && isset($request->informasi[$key])) {
                                    $skor = array();
                                    if ($request->skor_penyelia_text[$key] == 'null') {
                                        $skor[$key] = null;
                                    } else {
                                        $skor[$key] = $request->skor_penyelia_text[$key];
                                    }
                                    array_push($finalArray_text, array(
                                        'id_pengajuan' => $id_pengajuan,
                                        'id_jawaban' => $request->id_text[$key],
                                        'opsi_text' => ($request->id_text[$key] != '131' && $request->id_text[$key] != '143' && $request->id_text[$key] != '90' && $request->id_text[$key] != '138') ? str_replace($find, "", $request->informasi[$key]) : $request->informasi[$key],
                                        'skor_penyelia' => $skor[$key],
                                        'updated_at' => date("Y-m-d H:i:s"),
                                    ));
                                }
                            }
                        }
                    }
                }
            };

            // data Level dua
            if ($request->dataLevelDua != null) {
                $data = $request->dataLevelDua;
                $result_dua = array_values(array_filter($data));
                foreach ($result_dua as $key => $value) {
                    $data_level_dua = getDataLevel($value);
                    $skor[$key] = $data_level_dua[0];
                    $id_jawaban[$key] = $data_level_dua[1];
                    // if ($skor[$key] != 'kosong') {
                    if ($skor[$key] != 'kosong') {
                        array_push($rata_rata, $skor[$key]);
                    } else {
                        $skor[$key] = null;
                    }
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
                    $data_level_tiga = getDataLevel($value);
                    $skor[$key] = $data_level_tiga[0];
                    $id_jawaban[$key] = $data_level_tiga[1];
                    if ($skor[$key] != 'kosong') {
                        array_push($rata_rata, $skor[$key]);
                    } else {
                        $skor[$key] = null;
                    }
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
                    $data_level_empat = getDataLevel($value);
                    $skor[$key] = $data_level_empat[0];
                    $id_jawaban[$key] = $data_level_empat[1];
                    if ($skor[$key] != 'kosong')
                        array_push($rata_rata, $skor[$key]);
                    else if ($skor[$key] == 'kosong')
                        array_push($rata_rata, 1);
                    else
                        $skor[$key] = null;

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
            // get skor ratio coverage opsi
            $jawaban = JawabanModel::select('id', 'id_jawaban', 'skor')
                                ->where('id_pengajuan', $id_pengajuan)
                                ->where('id_jawaban', 158) // 158  = id_option ratio coverage opsi 
                                ->first();
            if ($jawaban) {
                array_push($rata_rata, $jawaban->skor);
                array_push(
                    $finalArray,
                    array(
                        'id_pengajuan' => $id_pengajuan,
                        'id_jawaban' => $jawaban->id_jawaban,
                        'skor' => $jawaban->skor,
                        'updated_at' => date("Y-m-d H:i:s"),
                    )
                );
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
                /*
                1. variabel a = query select k table jawaban where(id, id_jawaban)
                2. jika variabel a itu ada maka proses update
                3. jika variabel a itu null maka insert / data baru
                */
                $data = DB::table('jawaban');

                if (!empty($request->id[$i])) {
                    if (is_numeric($finalArray[$i]['skor']))
                        $data->where('id', $request->id[$i])->update($finalArray[$i]);
                    else {
                        $data->where('id', $request->id[$i])->update([
                            'id_pengajuan' => $finalArray[$i]['id_pengajuan'],
                            'id_jawaban' => $finalArray[$i]['id_jawaban'],
                            'skor' => is_numeric($finalArray[$i]['skor']) ? $finalArray[$i]['skor'] : null,
                            'updated_at' => $finalArray[$i]['updated_at'],
                        ]);
                    }
                } else {
                    $data->insert($finalArray[$i]);
                }
            }

            for ($i = 0; $i < count($request->id_text); $i++) {
                /*
                1. variabel a = query select k table jawaban where(id, id_jawaban)
                2. jika variabel a itu ada maka proses update
                3. jika variabel a itu null maka insert / data baru
                */
                $data = DB::table('jawaban_text');
                if (array_key_exists($i, $request->id_jawaban_text) && array_key_exists($i, $request->id_text)) {
                    $index = $request->id_text[$i];
                    if ($request->id_jawaban_text[$i] != null && $request->id_text[$i] != null) {
                        $data->where('id', $request->get('id_jawaban_text')[$i])->update(['opsi_text' => ($request->id_text[$i] != '131' && $request->id_text[$i] != '143' && $request->id_text[$i] != '90' && $request->id_text[$i] != '138') ? str_replace($find, "", $request->informasi[$index]) : $request->informasi[$index]]);
                    }
                }
            }

            foreach ($request->pendapat_per_aspek as $key => $value) {
                $data = DB::table('pendapat_dan_usulan_per_aspek');
                if ($value != null) {
                    $data->where('id', $request->get('id_aspek')[$key])->update(['pendapat_per_aspek' => $value]);
                } else {
                    $data->insert([
                        'id_pengajuan' => $id_pengajuan,
                        'id_staf' => auth()->user()->id,
                        'id_penyelia' => null,
                        'id_pincab' => null,
                        'id_aspek' => $request->get('id_aspek')[$key],
                        'pendapat_per_aspek' => $value,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            if ($request->get('id_komentar_staff_text') != null) {
                $id_komentar_staff = $request->get('id_komentar_staff_text');
                $updateKomentar = KomentarModel::find($id_komentar_staff);
                $updateKomentar->komentar_staff = $request->get('komentar_staff');
                $updateKomentar->update();
            } else {
                $addKomentar = new KomentarModel;
                $addKomentar->id_pengajuan = $id_pengajuan;
                $addKomentar->komentar_staff = $request->get('komentar_staff');
                $addKomentar->id_staff = Auth::user()->id;
                $addKomentar->save();
            }

            $updateData->posisi = 'Proses Input Data';
            $updateData->status_by_sistem = $status;
            $updateData->average_by_sistem = $result;
            $updateData->update();

            // Log Edit Pengajuan
            $namaNasabah = $request->get('nama_lengkap');

            $this->logPengajuan->store('Staff dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' melakukan proses perubahan data pengajuan atas nama ' . $namaNasabah, $id, Auth::user()->id, Auth::user()->nip);

            DB::commit();
            Alert::success('success', 'Berhasil memperbarui data');
            return redirect()->route('dagulir.pengajuan.index');
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Terjadi Kesalahan', $e->getMessage());
            return redirect()->back();
        } catch (QueryException $e) {
            DB::rollBack();
            alert()->error('Terjadi Kesalahan', $e->getMessage());
            return redirect()->back();
        }
    }
}
