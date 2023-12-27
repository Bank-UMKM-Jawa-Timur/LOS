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

        $param['dataDetailPosisi'] = $this->repo->getDetailPosisi($request);

        $param['dataDetailSkema'] = $this->repo->getDataSkema($request);

        // dd($param);

        return view('dashboard.detail.dashboard-detail', $param);
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
