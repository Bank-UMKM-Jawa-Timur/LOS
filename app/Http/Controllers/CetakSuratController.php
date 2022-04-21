<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonNasabah;
use App\Models\ItemModel;

class CetakSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->params['nasabah'] = CalonNasabah::get();
        return view('cetak.cetak-surat', $this->params);
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
        // $this->params['nasabah'] = CalonNasabah::find($id);
        // return view('cetak.cetak-surat', $this->params);
        echo "asd";
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

    public function cetak($id)
    {
        $this->params['nasabah'] = CalonNasabah::find($id);
        $this->params['aspek'] = ItemModel::whereNull('id_parent')->get();
        // ddd($this->params['aspek']);
        return view('cetak.cetak-surat', $this->params);
    }
}
