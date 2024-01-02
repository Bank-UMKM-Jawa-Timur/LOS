<?php

namespace App\Http\Controllers;

use App\Models\PengajuanModel;
use App\Repository\DashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $repo;

    public function __construct()
    {
        $this->repo = new DashboardRepository;
    }
    public function index(Request $request)
    {
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }
        $param['cabangs'] = DB::table('cabang')
            ->get();
        $id_cabang = Auth::user()->id_cabang;
        $current_cabang = DB::table('cabang')->select('kode_cabang')->where('id', $id_cabang)->first();
        $kode_cabang = '-';
        if ($current_cabang)
            $kode_cabang = $current_cabang->kode_cabang;
        $param['kode_cabang'] = $kode_cabang;

        $param['skema'] = $this->repo->getDetailSkemaTotal($request);

        $param['cabang'] = $this->repo->getDetailCabangTotal($request);

        return view('dashboard.detail.dashboard-detail', $param);
    }

    public function detailDisetujui(Request $request){
        // return 'masuk';
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }
        $param['cabangs'] = DB::table('cabang')
            ->get();
        $id_cabang = Auth::user()->id_cabang;
        $current_cabang = DB::table('cabang')->select('kode_cabang')->where('id', $id_cabang)->first();
        $kode_cabang = '-';
        if ($current_cabang)
            $kode_cabang = $current_cabang->kode_cabang;
        $param['kode_cabang'] = $kode_cabang;

        $param['cabang'] = $this->repo->getDetailCabangDisetujui($request);

        return view('dashboard.detail.disetujui', $param);
    }
    public function detailDitolak(Request $request){
        // return 'masuk';
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }
        $param['cabangs'] = DB::table('cabang')
            ->get();
        $id_cabang = Auth::user()->id_cabang;
        $current_cabang = DB::table('cabang')->select('kode_cabang')->where('id', $id_cabang)->first();
        $kode_cabang = '-';
        if ($current_cabang)
            $kode_cabang = $current_cabang->kode_cabang;
        $param['kode_cabang'] = $kode_cabang;

        $param['cabang'] = $this->repo->getDetailCabangDitolak($request);

        return view('dashboard.detail.ditolak', $param);
    }
    public function detailDiproses(Request $request){
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }
        $param['cabangs'] = DB::table('cabang')
            ->get();
        $id_cabang = Auth::user()->id_cabang;
        $current_cabang = DB::table('cabang')->select('kode_cabang')->where('id', $id_cabang)->first();
        $kode_cabang = '-';
        if ($current_cabang)
            $kode_cabang = $current_cabang->kode_cabang;
        $param['kode_cabang'] = $kode_cabang;

        $param['cabang'] = $this->repo->getDetailCabangDiproses($request);
        $param['skema'] = $this->repo->getDetailSkemaDiproses($request);

        return view('dashboard.detail.diproses', $param);
    }
    public function detailRankCabang(Request $request){
        // return 'masuk';
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }
        $param['cabangs'] = DB::table('cabang')
            ->get();
        $id_cabang = Auth::user()->id_cabang;
        $current_cabang = DB::table('cabang')->select('kode_cabang')->where('id', $id_cabang)->first();
        $kode_cabang = '-';
        if ($current_cabang)
            $kode_cabang = $current_cabang->kode_cabang;
        $param['kode_cabang'] = $kode_cabang;

        $param['data'] = $this->repo->getDetailRankCabang($request);

        return view('dashboard.detail.rank-cabang', $param);
    }
    public function detailPieChartPosisi(Request $request){
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }
        $id_user = Auth::user()->id;
        $role = Auth::user()->role;

        if ($role == 'Pincab') {
            $param['role'] = "Pincab";
        }
        else if ($role == 'Penyelia Kredit') {
            $param['role'] = "Penyelia";
        }
        else if ($role == 'Kredit Umum') {
            $param['role'] = "Kredit Umum";
        }
        else if ($role == 'Direksi') {
            $param['role'] = "Direksi";
        }
        else if ($role == 'Administrator') {
            $param['role'] = "Admin";
        }
        else if ($role == 'Staf Analis Kredit') {
            $param['role'] = "Staf";
        }
        else if ($role == 'PBO' || $role = 'PBP') {
            $param['role'] = "pbo/pbp";
        }
        $param['dataStaf'] = $this->repo->getDetailChartPosisiStaff($id_user, $role);
        if ($role == 'Pincab' || $role == 'pbo/pbp') {
            $param['penyelia'] = $this->repo->getDetailChartPosisiPenyelia($id_user, $role);
            $param['pincab'] = $this->repo->getDetailChartPosisiPincab($id_user, $role);
            $param['PBOPBP'] = $this->repo->getDetailChartPosisiPBOorPBP($id_user, $role);
        }

        return view('dashboard.detail.pie-chart-posisi', $param);
    }
    public function detailPieChartSkema(Request $request){
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }

        $role = auth()->user()->role;
        $idUser = auth()->user()->id;

        $param['data'] = $this->repo->getDetailChartSkema($idUser, $role);

        return view('dashboard.detail.pie-chart-skema', $param);
    }
    public function detailPieChartSkemaTwo(Request $request){
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }

        $role = auth()->user()->role;
        $idUser = auth()->user()->id;

        $param['cabang'] = $this->repo->getDetailSkemaTotal($request);

        return view('dashboard.detail.pie-chart-skema-two', $param);
    }
    public function detailPieChartPosisiTwo(Request $request){
        $param['pageTitle'] = "Analisa Kredit";
        if (Auth::user()->password_change_at == null) {
            return redirect()->route('change_password');
        }

        $role = auth()->user()->role;
        $idUser = auth()->user()->id;

        $param['cabang'] = $this->repo->getDetailCabangTotal($request);
        return view('dashboard.detail.pie-chart-posisi-two', $param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
