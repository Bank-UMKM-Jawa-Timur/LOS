<?php

namespace App\Http\Controllers;

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

    function danaCabang(){
        $getCabang = Cabang::orderBy('kode_cabang', 'ASC')->where('kode_cabang','!=','000')->get();
        $dana_cabang = DanaCabang::with('cabang')->latest()->paginate(10);
        return view('dagulir.master-dana.cabang.index',[
            'cabang' => $getCabang,
            'dana_cabang' => $dana_cabang
        ]);
    }

    function update(Request $request, $id) {
        $request->validate([
            'dana_idle' => 'required',
            'dana_modal' => 'required',
        ]);
        try {
            $update = MasterDana::find($id);
            $update->dana_idle = $request->get('dana_idle');
            $update->dana_modal = $request->get('dana_modal');
            $update->update();
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

    function storeCabang(Request $request) {
        $request->validate([
            'cabang' => 'required',
            'dana_modal' => 'required'
        ]);

        try {

            $check_dana = DanaCabang::where('id_cabang',$request->get('cabang'))->first();
            $dana_modal = MasterDana::latest()->first()->dana_modal;
            $total_dana_diterima = $dana_modal - formatNumber($request->get('dana_modal'));

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
                $dana_cabang->dana_modal = $total_dana_diterima;
                $dana_cabang->dana_idle = $total_dana_diterima;
                $dana_cabang->plafon_akumulasi = $nominal_plafon;
                $dana_cabang->baki_debet = $nominal_plafon;
                $dana_cabang->save();

                $master_dana = MasterDana::first();
                $master_dana->dana_modal = $total_dana_diterima;
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
}
