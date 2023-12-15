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
            'nik_nasabah' => 'required',
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

            if (!$statusSlik){
                Alert::success('success', 'Data berhasil disimpan');
                return redirect()->route('dagulir.pengajuan-kredit.index')->withStatus('Data berhasil disimpan.');
            }
            else {
                Alert::error('error', 'Pengajuan ditolak');
                return redirect()->route('dagulir.pengajuan-kredit.index')->withError('Pengajuan ditolak');
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

                Alert::success('success', 'Berhasil Mereview');
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
            if ($param['dataUmumNasabah']->desa_ktp != null) {
                $param['desa_ktp'] = Desa::find($param['dataUmumNasabah']->desa_ktp)->desa;
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

            return view('dagulir.pengajuan-kredit.detail-pengajuan-jawaban', $param);
        } else {
            Alert::error('error', 'Tidak memiliki hak akses');
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }

    public function getDetailJawabanPincab($id)
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
                'pengajuan.tanggal_review_pincab',
                'pengajuan.dagulir_id',
                'pengajuan.skema_kredit'
            )
            ->find($id);
            $param['dataUmum'] = $pengajuan;
            $param['dataUmumNasabah'] = PengajuanDagulir::find($pengajuan->dagulir_id);

            // return $param['dataUmumNasabah'];

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
            $param['pendapatDanUsulan'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_staff', 'komentar_penyelia', 'komentar_pincab', 'komentar_pbo', 'komentar_pbp')->first();
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
            $param['comment'] = KomentarModel::where('id_pengajuan', $id)->first();
            return view('dagulir.pengajuan-kredit.review-pincab', $param);
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

    public function sendToPincab(Request $request)
    {
        // return $request;
        $id = $request->get('id_pengajuan');
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

                    Alert::success('success', 'Berhasil mengganti posisi');
                    return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                } else {
                    Alert::error('error', 'User pincab tidak ditemukan pada cabang ini');
                    return back()->withError('User pincab tidak ditemukan pada cabang ini.');
                }
            } else {
                Alert::error('error', 'Data pengajuan tidak ditemukan');
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
                        $lampiran_analisa = lampiranAnalisa();
                        $this->updateStatus($nasabah->kode_pendaftaran, 2, $lampiran_analisa, $nasabah->jangka_waktu, $nasabah->nominal);

                        // HIT update status disetujui endpoint dagulir
                        $this->updateStatus($nasabah->kode_pendaftaran, 3, null, $nasabah->jangka_waktu, $nasabah->nominal);

                        DB::commit();
                        event(new EventMonitoring('menyetujui pengajuan'));

                        Alert::success('success', 'Berhasil mengganti posisi');
                        return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                    }
                    else {
                        DB::rollBack();
                        return redirect()->back()->withError('Terjadi kesalahan saat mengirimkan data SIPDE.');
                    }
                } else {
                    Alert::error('error', 'Belum di review pincab');
                    return redirect()->back()->withError('Belum di review Pincab.');
                }
            } else {
                Alert::error('error', 'Tidak memiliki hak akses');
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
                    Alert::success('success', 'Berhasil mengganti posisi');
                    return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                } else {
                    Alert::error('error', 'Belum di review Pincab');
                    return redirect()->back()->withError('Belum di review Pincab.');
                }
            } else {
                Alert::error('error', 'Tidak memiliki hak akses');
                return redirect()->back()->withError('Tidak memiliki hak akses.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
