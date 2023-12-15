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
use App\Services\TemporaryService;
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

        return view('dagulir.pengajuan.add-pengajuan-kredit', $param);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama_lengkap' => 'required',
            'nik_nasabah' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'telp' => 'required',
            'jenis_usaha' => 'required',
            'nominal_pengajuan' => 'required',
            'tujuan_penggunaan' => 'required',
            'jangka_waktu' => 'required',
            'status' => 'required|not_in:0',
            'desa_id' => 'required|not_ind:0',
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

            // Jawaban untuk file
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
            $pengajuan->id_slik = (int)$request->get('id_slik');
            $pengajuan->kode_bank_cabang = auth()->user()->id_cabang;
            $pengajuan->desa_ktp = $request->get('desa_id');
            $pengajuan->kec_ktp = $request->get('kecamatan_sesuai_ktp');
            $pengajuan->desa_id = $request->get('desa');
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

            $update_pengajuan = PengajuanDagulir::find($pengajuan->id);
            // Start File Slik
            if ($request->has('file_slik')) {
                $image = $request->file('file_slik');
                $fileNameSlik = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();
                $filePath = public_path() . '/upload/' . $pengajuan->id . '/' .$pengajuan->id_slik;
                if (!File::isDirectory($filePath)) {
                    File::makeDirectory($filePath, 493, true);
                }
                $image->move($filePath, $fileNameSlik);
            }
            // foto nasabah
            if ($request->has('foto_nasabah')) {
                $image = $request->file('foto_nasabah');
                $fileNameNasabah = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();
                $filePath = public_path() . '/upload/' . $pengajuan->id;
                if (!File::isDirectory($filePath)) {
                    File::makeDirectory($filePath, 493, true);
                }
                $image->move($filePath, $fileNameNasabah);
                $update_pengajuan->foto_nasabah = $fileNameNasabah;

            }
            if ($request->has('ktp_pasangan')) {
                $image = $request->file('ktp_pasangan');
                $fileNamePasangan = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();
                $filePath = public_path() . '/upload/' . $pengajuan->id;
                if (!File::isDirectory($filePath)) {
                    File::makeDirectory($filePath, 493, true);
                }
                $image->move($filePath, $fileNamePasangan);
                $update_pengajuan->foto_pasangan = $fileNamePasangan;

            }
            if ($request->has('ktp_nasabah')) {
                $image = $request->file('ktp_nasabah');
                $fileNameKtpNasabah = auth()->user()->id . '-' . time() . '-' . $image->getClientOriginalName();
                $filePath = public_path() . '/upload/' . $pengajuan->id;
                if (!File::isDirectory($filePath)) {
                    File::makeDirectory($filePath, 493, true);
                }
                $image->move($filePath, $fileNameKtpNasabah);
                $update_pengajuan->foto_ktp = $fileNameKtpNasabah;

            }
            // ktp nasabah
            $update_pengajuan->update();
            // End File Slik

            $addPengajuan = new PengajuanModel;
            $addPengajuan->id_staf = auth()->user()->id;
            $addPengajuan->tanggal = date(now());
            $addPengajuan->id_cabang = auth()->user()->id_cabang;
            $addPengajuan->progress_pengajuan_data = $request->progress;
            $addPengajuan->skema_kredit = 'Dagulir';
            $addPengajuan->dagulir_id = $pengajuan->id;
            $addPengajuan->save();
            $id_pengajuan = $addPengajuan->id;
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
                    // $dataJawabanText->opsi_text = $request->get('informasi')[$key] == null ? '-' : $request->get('informasi')[$key];
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

            if (!$statusSlik)
                return redirect()->route('dagulir.pengajuan.index')->withStatus('Data berhasil disimpan.');
            else
                return redirect()->route('dagulir.pengajuan.index')->withError('Pengajuan ditolak');
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
                return redirect()->back()->withStatus('Berhasil mengganti posisi.');
            } else {
                return back()->withError('Data pengajuan tidak ditemukan.');
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
                    $average = ($sum_select) / (count($request->skor_penyelia) - $totalDataNull);
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
                }

                // Log Pengajuan review
                $dagulir = PengajuanDagulir::find($updateData->dagulir_id);
                $namaNasabah = 'undifined';

                if ($dagulir)
                    $namaNasabah = $dagulir->nama;

                $this->logPengajuan->store($role . ' dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' melakukan review terhadap pengajuan atas nama ' . $namaNasabah, $updateData->id, Auth::user()->id, Auth::user()->nip);

                DB::commit();
                event(new EventMonitoring('review pengajuan'));

                return redirect()->route('dagulir.pengajuan.index')->withStatus('Berhasil Mereview');
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
            if ($param['dataUmumNasabah']->desa_id != null) {
                $param['desa_ktp'] = Desa::find($param['dataUmumNasabah']->desa_id)->desa;
            }
            $param['kec_dom'] = Kecamatan::find($param['dataUmumNasabah']->kec_dom)->kecamatan;
            $param['kab_dom'] = Kabupaten::find($param['dataUmumNasabah']->kotakab_dom)->kabupaten;
            $param['kec_usaha'] = Kecamatan::find($param['dataUmumNasabah']->kec_usaha)->kecamatan;
            $param['kab_usaha'] = Kabupaten::find($param['dataUmumNasabah']->kotakab_usaha)->kabupaten;

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

            return view('dagulir.pengajuan.detail-pengajuan-jawaban', $param);
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
                $update_pengajuan_dagulir = PengajuanDagulir::find($pengajuan->dagulir_id);
                $update_pengajuan_dagulir->kode_pendaftaran = $pengajuan_dagulir['data']['kode_pendaftaran'];
                // $update_pengajuan_dagulir->nominal_realisasi = $this->formatNumber($request->nominal_realisasi);
                // $update_pengajuan_dagulir->jangka_waktu = $request->jangka_waktu;
                $update_pengajuan_dagulir->status = 1;
                $update_pengajuan_dagulir->update();

                // Log Pengajuan review
                $dagulir = PengajuanDagulir::find($update_pengajuan_dagulir->dagulir_id);
                $namaNasabah = 'undifined';

                if ($dagulir)
                    $namaNasabah = $dagulir->nama;

                $role = Auth::user()->role;
                $this->logPengajuan->store($role . ' dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' mengirimkan data dagulir dengan pengajuan atas nama ' . $namaNasabah, $pengajuan->id, Auth::user()->id, Auth::user()->nip);

                DB::commit();

                return 'success';
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

        // Log Pengajuan review
        $dagulir = PengajuanDagulir::select('id', 'nama')
                                    ->where('kode_pendaftaran', $kode_pendaftaran)
                                    ->first();
        $pengajuan = PengajuanModel::select('id')
                                    ->where('dagulir_id', $dagulir->id)
                                    ->first();
        $namaNasabah = 'undifined';

        if ($dagulir)
            $namaNasabah = $dagulir->nama;

        $role = Auth::user()->role;
        $this->logPengajuan->store($role . ' dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' melakukan update status terhadap pengajuan atas nama ' . $namaNasabah, $pengajuan->id, Auth::user()->id, Auth::user()->nip);

        return $pengajuan_dagulir;
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

        return view('dagulir.index',[
            'data' => $pengajuan_dagulir
        ]);
    }

    public function sendToPincab($id)
    {
        try {
            $pengajuan = PengajuanModel::find($id);
            if ($pengajuan) {
                $pincab = User::select('id')
                        ->where('id_cabang', $pengajuan->id_cabang)
                        ->where('role', 'Pincab')
                        ->first();
                if ($pincab) {
                    $pengajuan->posisi = "Pincab";
                    $pengajuan->id_pincab = $pincab->id;
                    $pengajuan->tanggal_review_pincab = date('Y-m-d');
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

    public function accPengajuan($id)
    {
        DB::beginTransaction();
        try {
            $statusPincab = PengajuanModel::find($id);
            $komentarPincab = KomentarModel::where('id_pengajuan', $id)->first();
            if (auth()->user()->role == 'Pincab') {
                if ($komentarPincab->komentar_pincab != null) {
                    $statusPincab->posisi = "Selesai";
                    $statusPincab->tanggal_review_pincab = date(now());
                    $statusPincab->update();

                    $nasabah = PengajuanDagulir::select('kode_pendaftaran','nama', 'nominal', 'jangka_waktu')->find($statusPincab->dagulir_id);
                    $namaNasabah = 'undifined';
                    if ($nasabah)
                        $namaNasabah = $nasabah->nama;

                    $this->logPengajuan->store('Pincab dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' menyetujui pengajuan atas nama ' . $namaNasabah . '.', $id, Auth::user()->id, Auth::user()->nip);

                    // HIT Pengajuan endpoint dagulir
                    $storeSIPDE = $this->storeSipde($id);

                    if ($storeSIPDE == 'success') {
                        // HIT update status survei endpoint dagulir
                        $this->updateStatus($nasabah->kode_pendaftaran, 1, null, $nasabah->jangka_waktu, $nasabah->nominal);

                        // HIT update status analisa endpoint dagulir
                        $lampiran_analisa = "data:application/pdf;base64,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CmVuZG9iagoKOSAwIG9iago8PC9UeXBlL0ZvbnQvU3VidHlwZS9UcnVlVHlwZS9CYXNlRm9udC9CQUFBQUErQXJpYWwtQm9sZE1UCi9GaXJzdENoYXIgMAovTGFzdENoYXIgMTEKL1dpZHRoc1s3NTAgNzIyIDYxMCA4ODkgNTU2IDI3NyA2NjYgNjEwIDMzMyAyNzcgMjc3IDU1NiBdCi9Gb250RGVzY3JpcHRvciA3IDAgUgovVG9Vbmljb2RlIDggMCBSCj4+CmVuZG9iagoKMTAgMCBvYmoKPDwKL0YxIDkgMCBSCj4+CmVuZG9iagoKMTEgMCBvYmoKPDwvRm9udCAxMCAwIFIKL1Byb2NTZXRbL1BERi9UZXh0XT4+CmVuZG9iagoKMSAwIG9iago8PC9UeXBlL1BhZ2UvUGFyZW50IDQgMCBSL1Jlc291cmNlcyAxMSAwIFIvTWVkaWFCb3hbMCAwIDU5NSA4NDJdL0dyb3VwPDwvUy9UcmFuc3BhcmVuY3kvQ1MvRGV2aWNlUkdCL0kgdHJ1ZT4+L0NvbnRlbnRzIDIgMCBSPj4KZW5kb2JqCgoxMiAwIG9iago8PC9Db3VudCAxL0ZpcnN0IDEzIDAgUi9MYXN0IDEzIDAgUgo+PgplbmRvYmoKCjEzIDAgb2JqCjw8L1RpdGxlPEZFRkYwMDQ0MDA3NTAwNkQwMDZEMDA3OTAwMjAwMDUwMDA0NDAwNDYwMDIwMDA2NjAwNjkwMDZDMDA2NT4KL0Rlc3RbMSAwIFIvWFlaIDU2LjcgNzczLjMgMF0vUGFyZW50IDEyIDAgUj4+CmVuZG9iagoKNCAwIG9iago8PC9UeXBlL1BhZ2VzCi9SZXNvdXJjZXMgMTEgMCBSCi9NZWRpYUJveFsgMCAwIDU5NSA4NDIgXQovS2lkc1sgMSAwIFIgXQovQ291bnQgMT4+CmVuZG9iagoKMTQgMCBvYmoKPDwvVHlwZS9DYXRhbG9nL1BhZ2VzIDQgMCBSCi9PdXRsaW5lcyAxMiAwIFIKPj4KZW5kb2JqCgoxNSAwIG9iago8PC9BdXRob3I8RkVGRjAwNDUwMDc2MDA2MTAwNkUwMDY3MDA2NTAwNkMwMDZGMDA3MzAwMjAwMDU2MDA2QzAwNjEwMDYzMDA2ODAwNkYwMDY3MDA2OTAwNjEwMDZFMDA2RTAwNjkwMDczPgovQ3JlYXRvcjxGRUZGMDA1NzAwNzIwMDY5MDA3NDAwNjUwMDcyPgovUHJvZHVjZXI8RkVGRjAwNEYwMDcwMDA2NTAwNkUwMDRGMDA2NjAwNjYwMDY5MDA2MzAwNjUwMDJFMDA2RjAwNzIwMDY3MDAyMDAwMzIwMDJFMDAzMT4KL0NyZWF0aW9uRGF0ZShEOjIwMDcwMjIzMTc1NjM3KzAyJzAwJyk+PgplbmRvYmoKCnhyZWYKMCAxNgowMDAwMDAwMDAwIDY1NTM1IGYgCjAwMDAwMTE5OTcgMDAwMDAgbiAKMDAwMDAwMDAxOSAwMDAwMCBuIAowMDAwMDAwMjI0IDAwMDAwIG4gCjAwMDAwMTIzMzAgMDAwMDAgbiAKMDAwMDAwMDI0NCAwMDAwMCBuIAowMDAwMDExMTU0IDAwMDAwIG4gCjAwMDAwMTExNzYgMDAwMDAgbiAKMDAwMDAxMTM2OCAwMDAwMCBuIAowMDAwMDExNzA5IDAwMDAwIG4gCjAwMDAwMTE5MTAgMDAwMDAgbiAKMDAwMDAxMTk0MyAwMDAwMCBuIAowMDAwMDEyMTQwIDAwMDAwIG4gCjAwMDAwMTIxOTYgMDAwMDAgbiAKMDAwMDAxMjQyOSAwMDAwMCBuIAowMDAwMDEyNDk0IDAwMDAwIG4gCnRyYWlsZXIKPDwvU2l6ZSAxNi9Sb290IDE0IDAgUgovSW5mbyAxNSAwIFIKL0lEIFsgPEY3RDc3QjNEMjJCOUY5MjgyOUQ0OUZGNUQ3OEI4RjI4Pgo8RjdENzdCM0QyMkI5RjkyODI5RDQ5RkY1RDc4QjhGMjg+IF0KPj4Kc3RhcnR4cmVmCjEyNzg3CiUlRU9GCg==";
                        $this->updateStatus($nasabah->kode_pendaftaran, 2, $lampiran_analisa, $nasabah->jangka_waktu, $nasabah->nominal);
    
                        // HIT update status disetujui endpoint dagulir
                        $this->updateStatus($nasabah->kode_pendaftaran, 3, null, $nasabah->jangka_waktu, $nasabah->nominal);

                        DB::commit();
                        event(new EventMonitoring('menyetujui pengajuan'));

                        return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                    }
                    else {
                        DB::rollBack();
                        return redirect()->back()->withError('Terjadi kesalahan saat mengirimkan data SIPDE.');
                    }
                } else {
                    return redirect()->back()->withError('Belum di review Pincab.');
                }
            } else {
                return redirect()->back()->withError('Tidak memiliki hak akses.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function decPengajuan($id)
    {
        DB::beginTransaction();
        try {
            $statusPincab = PengajuanModel::find($id);
            $komentarPincab = KomentarModel::where('id_pengajuan', $id)->first();
            if (auth()->user()->role == 'Pincab') {
                if ($komentarPincab->komentar_pincab != null) {
                    $statusPincab->posisi = "Ditolak";
                    $statusPincab->tanggal_review_pincab = date(now());
                    $statusPincab->update();

                    $nasabah = PengajuanDagulir::select('nama')->find($statusPincab->dagulir_id);
                    $namaNasabah = 'undifined';
                    if ($nasabah)
                        $namaNasabah = $nasabah->nama;

                    $this->logPengajuan->store('Pincab dengan NIP ' . Auth::user()->nip . ' atas nama ' . $this->getNameKaryawan(Auth::user()->nip) . ' menolak pengajuan atas nama ' . $namaNasabah . '.', $id, Auth::user()->id, Auth::user()->nip);

                    DB::commit();

                    event(new EventMonitoring('tolak pengajuan'));
                    return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                } else {
                    return redirect()->back()->withError('Belum di review Pincab.');
                }
            } else {
                return redirect()->back()->withError('Tidak memiliki hak akses.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
