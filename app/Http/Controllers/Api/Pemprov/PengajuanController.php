<?php

namespace App\Http\Controllers\Api\Pemprov;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();
        try {
            // 1. Insert to pengajuan table
            $pengajuan = [
                'tanggal' => $request->get('tanggal'),
                'id_cabang' => $request->get('id_cabang'),
                'skema_kredit' => $request->get('skema_kredit'),
            ];

            $idPengajuan = DB::table('pengajuan')->insertGetId($pengajuan);

            // 2. Insert to pengajuan table
            $nasabah = [
                'nama' => $request->get('nama_nasabah'),
                'alamat_rumah' => $request->get('alamat_rumah'),
                'alamat_usaha' => $request->get('alamat_usaha'),
                'no_ktp' => $request->get('no_ktp'),
                'tempat_lahir' => $request->get('tempat_lahir'),
                'tanggal_lahir' => date('Y-m-d', strtotime($request->get('tanggal_lahir'))),
                'status' => $request->get('status_menikah'),
                'sektor_kredit' => $request->get('sektor_kredit'),
                'jenis_usaha' => $request->get('jenis_usaha'),
                'jumlah_kredit' => $request->get('nominal'),
                'tenor_yang_diminta' => $request->get('tenor'),
                'tujuan_kredit' => $request->get('tujuan_kredit'),
                'jaminan_kredit' => $request->get('jaminan'),
                'hubungan_bank' => $request->get('hubungan_bank'),
                'verifikasi_umum' => $request->get('hasil_verifikasi'),
                'id_user' => 1,
                'id_desa' => 3505012001,
                'id_kecamatan' => 350501,
                'id_kabupaten' => 3505,
            ];
            DB::table('calon_nasabah')->insert($nasabah);

            $status = 'success';
            $message = 'Successfully store data';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $status = 'failed';
            $message = $e->getMessage();
        } finally {
            // 3. Return json
            $response = [
                'status' => $status,
                'message' => $message,
            ];

            return response()->json($response);
        }
    }
}
