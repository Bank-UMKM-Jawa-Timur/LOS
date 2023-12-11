<?php

namespace App\Http\Controllers\Api\Pemprov;

use App\Http\Controllers\Controller;
use App\Models\PengajuanDagulir;
use App\Models\PengajuanModel;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PengajuanController extends Controller
{
    public function store(Request $request) {
        /**
         * 1. Insert to pengajuan table
         * 2. Insert to calon_nasabah table
         * 3. Return json
         */
        $status = '';
        $message = '';
        $req_status = Response::HTTP_OK;

        DB::beginTransaction();
        try {
            $req = $request->all();
            $validator = Validator::make($req, [
                'kode_pendaftaran' => 'required|unique:pengajuan_dagulir,kode_pendaftaran',
                'nama' => 'required',
                'nik' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'telp' => 'required',
                'jenis_usaha' => 'required',
                'nominal' => 'required',
                'tujuan_penggunaan' => 'required',
                'jangka_waktu' => 'required',
                'kode_bank_pusat' => 'required',
                'kode_bank_cabang' => 'required',
                'kec_ktp' => 'required',
                'kotakab_ktp' => 'required',
                'alamat_ktp' => 'required',
                'kec_dom' => 'required',
                'kotakab_dom' => 'required',
                'alamat_dom' => 'required',
                'kec_usaha' => 'required',
                'kotakab_usaha' => 'required',
                'alamat_usaha' => 'required',
                'tipe' => 'required',
                'npwp' => 'required',
                'jenis_badan_hukum' => 'required',
                'tempat_berdiri' => 'required',
                'tanggal_berdiri' => 'required',
                'tanggal' => 'required',
            ], [
                'required' => ':attribute harus diisi.',
                'unique' => ':attribute telah digunakan'
            ], [
                'kode_pendaftaran' => 'Kode Pendaftaran',
                'nama' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat Lahir',
                'tanggal_lahir' => 'Tanggal Lahir',
                'telp' => 'Telp',
                'jenis_usaha' => 'Jenis Usaha',
                'nominal' => 'Nominal',
                'tujuan_penggunaan' => 'Tujuan Penggunaan',
                'jangka_waktu' => 'Jangka Waktu',
                'kode_bank_pusat' => 'Kode Bank Pusat',
                'kode_bank_cabang' => 'Kode Bank Cabang',
                'kec_ktp' => 'Kecamatan KTP',
                'kotakab_ktp' => 'Kota/Kabupaten KTP',
                'alamat_ktp' => 'Alamat KTP',
                'kec_dom' => 'Kecamatan Domisili',
                'kotakab_dom' => 'Kota/Kabupaten Domisili',
                'alamat_dom' => 'Alatmat Domisili',
                'kec_usaha' => 'Kecamatan Usaha',
                'kotakab_usaha' => 'Kota/Kabupaten Usaha',
                'alamat_usaha' => 'Alamat Usaha',
                'tipe' => 'Tipe',
                'npwp' => 'NPWP',
                'jenis_badan_hukum' => 'Jenis Badan Hukum',
                'tempat_berdiri' => 'Tempat Berdiri',
                'tanggal_berdiri' => 'Tanggal Berdiri',
                'tanggal' => 'Tanggal',
            ]);

            if($validator->fails()){
                $req_status = Response::HTTP_UNPROCESSABLE_ENTITY;
                $message = $validator->errors()->all();
                $status = 'gagal';
            } else{
                $userId = User::where('user_dagulir', 1)
                    ->where('id_cabang', $request->get('kode_bank_cabang'))
                    ->first();
                if($userId == null){
                    $req_status = Response::HTTP_UNPROCESSABLE_ENTITY;
                    $message = 'User tidak dapat ditemukan pada bank cabang dengan kode '. $request->get('kode_bank_cabang');
                    $status = 'gagal';
                } else{
                    $insertDagulir = [
                        'kode_pendaftaran' => $request->get('kode_pendaftaran'),
                        'nama' => $request->get('nama'),
                        'nik' => $request->get('nik'),
                        'nama_pj_ketua' => $request->get('nama_pj_ketua') ?? null,
                        'tempat_lahir' => $request->get('tempat_lahir'),
                        'tanggal_lahir' => date('Y-m-d', strtotime($request->get('tanggal_lahir'))),
                        'telp' => $request->get('telp'),
                        'jenis_usaha' => $request->get('jenis_usaha'),
                        'nominal' => $request->get('nominal'),
                        'tujuan_penggunaan' => $request->get('tujuan_penggunaan'),
                        'jangka_waktu' => $request->get('jangka_waktu'),
                        'kode_bank_pusat' => $request->get('kode_bank_pusat'),
                        'kode_bank_cabang' => $request->get('kode_bank_cabang'),
                        'kec_ktp' => $request->get('kec_ktp'),
                        'kotakab_ktp' => $request->get('kotakab_ktp'),
                        'alamat_ktp' => $request->get('alamat_ktp'),
                        'kec_dom' => $request->get('kec_dom'),
                        'kotakab_dom' => $request->get('kotakab_dom'),
                        'alamat_dom' => $request->get('alamat_dom'),
                        'kec_usaha' => $request->get('kec_usaha'),
                        'kotakab_usaha' => $request->get('kotakab_usaha'),
                        'alamat_usaha' => $request->get('alamat_usaha'),
                        'tipe' => $request->get('tipe'),
                        'npwp' => $request->get('npwp'),
                        'jenis_badan_hukum' => $request->get('jenis_badan_hukum'),
                        'tempat_berdiri' => $request->get('tempat_berdiri'),
                        'tanggal_berdiri' => date('Y-m-d', strtotime($request->get('tanggal_berdiri'))),
                        'tanggal' => date('Y-m-d', strtotime($request->get('tanggal'))),
                        'user_id' => $userId->id,
                        'status' => 8, // Ditindaklanjuti
                        'created_at' => now(),
                    ];

                    $pengajuanDagulirId = PengajuanDagulir::insertGetId($insertDagulir);

                    $addPengajuan = new PengajuanModel();
                    $addPengajuan->id_staf = $userId->id;
                    $addPengajuan->tanggal = date(now());
                    $addPengajuan->id_cabang = $request->get('kode_bank_cabang');
                    $addPengajuan->skema_kredit = 'Dagulir';
                    $addPengajuan->dagulir_id = $pengajuanDagulirId;
                    $addPengajuan->save();
    
                    DB::commit();
                    $status = 'berhasil';
                    $message = 'Berhasil menambahkan data pengajuan dagulir.';
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $status = 'gagal';
            $message = $e->getMessage();
            $req_status = Response::HTTP_BAD_REQUEST;
        } catch(QueryException $e){
            DB::rollBack();
            $status = 'gagal';
            $message = $e->getMessage();
            $req_status = Response::HTTP_BAD_REQUEST;
        } finally {
            // 3. Return json
            $response = [
                'status' => $status,
                'message' => $message,
            ];

            return response()->json($response, $req_status);
        }
    }
}
