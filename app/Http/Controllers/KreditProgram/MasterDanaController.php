<?php

namespace App\Http\Controllers\KreditProgram;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\DanaCabang;
use App\Models\MasterDana;
use App\Models\PengajuanDagulir;
use App\Models\PengajuanModel;
use App\Models\PlafonUsulan;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MasterDanaController extends Controller
{
    function index() {

        $update_data = MasterDana::latest()->first();
        return view('dagulir.master-dana.dana.index',[
            'update_data' => $update_data,
        ]);
    }

    function update(Request $request, $id) {
        $request->validate([
            'dana_idle' => 'required',
            'dana_modal' => 'required',
        ]);
        try {
            $update = MasterDana::find($id);
            if ($update) {
                $update->dana_idle = formatNumber($request->get('dana_idle'));
                $update->dana_modal = formatNumber($request->get('dana_modal'));
                $update->update();
            }else{
                $insert = new MasterDana;
                $insert->dana_idle = formatNumber($request->get('dana_idle'));
                $insert->dana_modal = formatNumber($request->get('dana_modal'));
                $insert->save();
            }
            alert()->success('Berhasil','Data berhasil diperbarui!')->autoclose(1500);
            return redirect()->route('master-dana.index');
        } catch (Exception $th) {
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        } catch (QueryException $th){
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        }
    }

    function danaCabang(){
        $getCabang = Cabang::orderBy('kode_cabang', 'ASC')->where('kode_cabang','!=','000')->get();
        $dana_cabang = DanaCabang::with('cabang')->latest()->paginate(10);
        return view('dagulir.master-dana.cabang.index',[
            'cabang' => $getCabang,
            'dana_cabang' => $dana_cabang
        ]);
    }

    function storeCabang(Request $request) {
        $request->validate([
            'cabang' => 'required',
            'dana_idle' => 'required'
        ]);
        try {
            $check_dana = DanaCabang::where('id_cabang',$request->get('cabang'))->first();
            $dana_idle = MasterDana::latest()->first()->dana_idle;
            if ($dana_idle < formatNumber($request->get('dana_idle'))) {
                alert()->warning('Warning','Dana yang tersedia tidak mencukupi.');
                return redirect()->route('master-dana.cabang.index');
            }

            $data_pengajuan = PengajuanDagulir::with('pengajuan')
                                        ->where('status','6')
                                        ->where('kode_bank_cabang',$request->get('cabang'))
                                        ->get();
            $nominal_plafon = 0;
            foreach ($data_pengajuan as $key => $value) {
            $plafon = PlafonUsulan::where('id_pengajuan',$value->pengajuan->id)->first()->plafon_usulan_pincab;
                $nominal_plafon += $plafon;
            }

            if ($check_dana) {
                alert()->warning('Warning','Dana sudah tersedia.');
                return redirect()->route('master-dana.cabang.index');
            }else{
                $dana_cabang = new DanaCabang;
                $dana_cabang->id_cabang = $request->get('cabang');
                $dana_cabang->dana_modal = formatNumber($request->get('dana_idle'));
                $dana_cabang->dana_idle = formatNumber($request->get('dana_idle'));
                $dana_cabang->plafon_akumulasi = $nominal_plafon;
                $dana_cabang->baki_debet = $nominal_plafon;
                $dana_cabang->save();

                $total_dana_idle = DanaCabang::first()->sum('dana_idle');
                // $total_dana_modal = DanaCabang::first()->sum('dana_modal');
                $current_dana_modal = MasterDana::first()->dana_modal;
                $total_dana_master = $current_dana_modal - $total_dana_idle;

                $master_dana = MasterDana::first();
                $master_dana->dana_idle = $total_dana_master;
                $master_dana->update();
            }
            alert()->success('Berhasil','Berhasil menambahkan data');
            return redirect()->route('master-dana.cabang.index');
        } catch (Exception $th) {
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        } catch (QueryException $th){
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        }
    }

    function alihDana() {
        $getCabang = DanaCabang::with('cabang')->get();
        return view('dagulir.master-dana.alih-dana.index',[
            'cabang' => $getCabang
        ]);
    }

    function alihDanaPost(Request $request) {
        $request->validate([
            'cabang_dari' => 'required|not_in:0',
            'cabang_ke' => 'required|not_in:0',
        ]);
        try {
            $update_cabang_dari = DanaCabang::where('id_cabang',$request->get('cabang_dari'))->first();
            $update_cabang_dari->dana_idle = $update_cabang_dari->dana_idle - formatNumber($request->get('dana_idle'));
            $update_cabang_dari->update();

            $update_cabang_ke = DanaCabang::where('id_cabang',$request->get('cabang_ke'))->first();
            $update_cabang_ke->dana_idle = formatNumber($request->get('total_dana'));
            $update_cabang_ke->update();

            $cabang_dari = Cabang::find($request->get('cabang_dari'))->cabang;
            $cabang_ke = Cabang::find($request->get('cabang_ke'))->cabang;
            alert()->success('Berhasil','Berhasil melakukan perpindahan dana dari cabang : '.$cabang_dari.' ke cabang :'.$cabang_ke.'Sebesar : '.$request->get('total_dana'));
            return redirect()->route('master-dana.alih-dana');
        } catch (Exception $e) {
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        } catch (QueryException $e){
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        }
    }

    function getDari(Request $request) {
        $data_dari = DanaCabang::where('id_cabang',$request->get('id'))->first()->dana_idle ?? 0;
        return $data_dari;
    }
    function getKe(Request $request) {
        $data_ke = DanaCabang::where('id_cabang',$request->get('id'))->first()->dana_idle ?? 0;
        return $data_ke;
    }

    function cabangLawan(Request $request) {
        $cabang = DanaCabang::with('cabang')->where('id_cabang','!=',$request->get('id'))->get();

        $cabangData = $cabang->map(function ($danaCabang) {
            return [
                'id' => $danaCabang->cabang->id,
                'cabang' => $danaCabang->cabang->cabang, // Change this to the actual column name in your 'cabang' table
            ];
        });

        return $cabangData;
    }
}
