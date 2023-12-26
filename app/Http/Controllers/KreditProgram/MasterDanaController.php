<?php

namespace App\Http\Controllers\KreditProgram;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\DanaCabang;
use App\Models\MasterDana;
use App\Models\MasterDDAngsuran;
use App\Models\MasterDDLoan;
use App\Models\PengajuanDagulir;
use App\Models\PengajuanModel;
use App\Models\PlafonUsulan;
use App\Repository\MasterDanaRepository;
use Exception;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sabberworm\CSS\RuleSet\RuleSet;

class MasterDanaController extends Controller
{
    function index() {

        $update_data = MasterDana::latest()->first();
        $repo = new MasterDanaRepository;
        $total_dana = 0;
        $total_idle = 0;
        $total = 0;
        foreach ($repo->getMasterDD() as $key => $value) {
            $total_dana += $value->dana_modal;
            $total_idle += $value->dana_idle;
            $total = $total_dana + $total_idle;
        }
        $total_idle_current = $update_data->dana_modal - $total;
        $update_data->dana_idle = $total_idle_current;
        $update_data->update();

        $dana_modal = MasterDana::first();
        return view('dagulir.master-dana.dana.index',[
            'dana_modal' => $dana_modal,
            'dana_idle' => $total_idle_current,
        ]);
    }

    function update(Request $request, $id) {
        $request->validate([
            'dana_modal' => 'required',
        ]);
        try {
            $update = MasterDana::find($id);
            if ($update) {
                $repo = new MasterDanaRepository;
                $total_dana = 0;
                $total_idle = 0;
                $total = 0;
                foreach ($repo->getMasterDD() as $key => $value) {
                    $total_dana += $value->dana_modal;
                    $total_idle += $value->dana_idle;
                    $total = $total_dana + $total_idle;
                }
                if (formatNumber($request->get('dana_modal')) <= $total) {
                    alert()->warning('Peringatan','Dana tidak sesuai.');
                    return redirect()->back();
                }
                $update->dana_modal = formatNumber($request->get('dana_modal'));
                $update->update();

            }else{
                $insert = new MasterDana;
                $insert->dana_idle = formatNumber($request->get('dana_modal'));
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

    function danaCabang(Request $request){

        $current_cabang = DanaCabang::select('id_cabang')->pluck('id_cabang');
        $query = Cabang::orderBy('kode_cabang', 'ASC')->where('kode_cabang','!=','000');
        if ($current_cabang) {
            $getCabang = $query->whereNotIn('id',$current_cabang)->get();
        }
        $getCabang = $query->get();

        $status = 0;
        $repo = new MasterDanaRepository;
        $total_dana = 0;
        foreach ($repo->getMasterDD() as $key => $value) {
            $total_dana += $value->dana_modal;
        }
        $total_idle_current = $total_dana;
        $total_dana = MasterDana::first()->dana_modal;
        if ($total_idle_current <= $total_dana) {
            $status = 1;
        }

        $limit = $request->has('page_length') ? $request->get('page_length') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $search = $request->get('q');

        $repo = new MasterDanaRepository;
        $dana_cabang = $repo->getDanaCabang($search,$page,$limit);
        return view('dagulir.master-dana.cabang.index',[
            'cabang' => $getCabang,
            'dana_cabang' => $dana_cabang,
            'status' => $status
        ]);
    }

    function storeDana(Request $request) {
        $request->validate([
            'cabang' => 'required',
            'dana_modal' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $current = MasterDana::first();
            $repo = new MasterDanaRepository;
            $total_dana = 0;
            $total_idle = 0;
            $total = 0;
            foreach ($repo->getMasterDD() as $key => $value) {
                $total_dana += $value->dana_modal;
                $total_idle += $value->dana_idle;
                $total = $total_dana + $total_idle;
            }
            $total_idle_current = $current->dana_modal - $total;
            if ($total_idle_current <= formatNumber($request->get('dana_modal'))) {
                DB::commit();
                alert()->warning('warning','Dana yang tersedia tidak mencukupi.');
                return redirect()->route('master-dana.cabang.index');
            }
            // dana cabang
            $repo = new MasterDanaRepository;
            $data = $repo->getDari($request->get('cabang'));
            $current_dana_modal = $data->dana_modal + formatNumber($request->get('dana_modal'));
            $current_dana_idle = $data->dana_idle + formatNumber($request->get('dana_modal'));
            $update = DanaCabang::find($request->get('id'));
            $update->dana_modal = $current_dana_modal;
            $update->dana_idle = $current_dana_idle;
            $update->update();
            // Update total idle master dana
            $repo = new MasterDanaRepository;
            $total_dana = 0;
            $total_idle = 0;
            $total = 0;
            foreach ($repo->getMasterDD() as $key => $value) {
                $total_dana += $value->dana_modal;
                $total_idle += $value->dana_idle;
                $total = $total_dana + $total_idle;
            }
            $total_idle_current = $current->dana_modal - $total;
            $current->dana_idle = $total_idle_current;
            $current->update();
            DB::commit();
            alert()->success('Berhasil','Berhasil menambahkan data');
            return redirect()->route('master-dana.cabang.index');
        } catch (Exception $th) {
            return $th;
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        } catch (QueryException $th){
            return $th;
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        }
    }

    function storeCabang(Request $request) {
        $request->validate([
            'cabang' => 'required',
            'dana_modal' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $check_dana = DanaCabang::where('id_cabang',$request->get('cabang'))->first();
            $current = MasterDana::first();
            $repo = new MasterDanaRepository;
            $total_dana = 0;
            $total_idle = 0;
            $total = 0;
            foreach ($repo->getMasterDD() as $key => $value) {
                $total_dana += $value->dana_modal;
                $total_idle += $value->dana_idle;
                $total = $total_dana + $total_idle;
            }
            $total_idle_current = $current->dana_modal - $total;
            if ($total_idle_current < formatNumber($request->get('dana_modal'))) {
                DB::commit();
                alert()->warning('warning','Dana yang tersedia tidak mencukupi.');
                return redirect()->route('master-dana.cabang.index');
            }

            if ($check_dana) {
                DB::commit();
                alert()->warning('Warning','Dana sudah tersedia.');
                return redirect()->route('master-dana.cabang.index');
            }else{
                // dana cabang
                $loan_akumulasi = MasterDDLoan::where('id_cabang')->sum('plafon');
                $loan_debet = MasterDDLoan::where('id_cabang')->sum('baki_debet');

                $total_data_idle = formatNumber($request->get('dana_modal')) - $loan_debet;
                $dana_cabang = new DanaCabang;
                $dana_cabang->id_cabang = $request->get('cabang');
                $dana_cabang->dana_modal = formatNumber($request->get('dana_modal'));
                $dana_cabang->dana_idle = $total_data_idle;
                $dana_cabang->plafon_akumulasi = $loan_akumulasi;
                $dana_cabang->baki_debet = $loan_debet;
                $dana_cabang->save();

                // Update total idle master dana
                $repo = new MasterDanaRepository;
                $total_dana = 0;
                $total_idle = 0;
                $total = 0;
                foreach ($repo->getMasterDD() as $key => $value) {
                    $total_dana += $value->dana_modal;
                    $total_idle += $value->dana_idle;
                    $total = $total_dana + $total_idle;
                }
                $total_idle_current = $current->dana_modal - $total;
                $current->dana_idle = $total_idle_current;
                $current->update();
            }
            DB::commit();
            alert()->success('Berhasil','Berhasil menambahkan data');
            return redirect()->route('master-dana.cabang.index');
        } catch (Exception $th) {
            return $th;
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.index');
        } catch (QueryException $th){
            return $th;
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
            if (formatNumber($request->get('dana_modal_setelah_dari')) < 0) {
                DB::commit();
                alert()->warning('Perhatian','Dana tidak mencukupi.');
                return redirect()->route('master-dana.alih-dana');
            }
            $update_cabang_dari = DanaCabang::where('id_cabang',$request->get('cabang_dari'))->first();
            $update_cabang_dari->dana_modal = formatNumber($request->get('dana_modal_setelah_dari'));
            $update_cabang_dari->dana_idle = formatNumber($request->get('dana_idle_setelah_dari'));
            $update_cabang_dari->update();

            $update_cabang_ke = DanaCabang::where('id_cabang',$request->get('cabang_ke'))->first();
            $update_cabang_ke->dana_modal = formatNumber($request->get('dana_modal_setelah_ke'));
            $update_cabang_ke->dana_idle = formatNumber($request->get('dana_idle_setelah_ke'));
            $update_cabang_ke->update();

            $cabang_dari = Cabang::find($request->get('cabang_dari'))->cabang;
            $cabang_ke = Cabang::find($request->get('cabang_ke'))->cabang;
            DB::commit();
            alert()->success('Berhasil','Berhasil melakukan perpindahan dana dari cabang : '.$cabang_dari.' ke cabang :'.$cabang_ke.'');
            return redirect()->route('master-dana.alih-dana');
        } catch (Exception $e) {
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.alih-dana');
        } catch (QueryException $e){
            alert()->error('error','Terjadi Kesalahan');
            return redirect()->route('master-dana.alih-dana');
        }
    }

    function getDari(Request $request) {
        $repo = new MasterDanaRepository;
        $data_dari = $repo->getDari($request->get('id'));
        return $data_dari;
    }
    function getKe(Request $request) {
        $repo = new MasterDanaRepository;
        $data_ke = $repo->getDari($request->get('id'));
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
