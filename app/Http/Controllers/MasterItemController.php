<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->param['pageIcon'] = 'fa fa-database';
        $this->param['parentMenu'] = '/master-item';
        $this->param['current'] = 'Master Item';
    }
    public function index()
    {
        $this->param['pageTitle'] = 'List Master Item';
        $this->param['btnText'] = 'Tambah Item';
        $this->param['btnLink'] = route('master-item.create');

        // try {
        //     $keyword = $request->get('keyword');
        //     $getKabupaten = Kabupaten::orderBy('id', 'ASC');

        //     if ($keyword) {
        //         $getKabupaten->where('id', 'LIKE', "%{$keyword}%")->orWhere('kabupaten', 'LIKE', "%{$keyword}%");
        //     }

        //     $this->param['kabupaten'] = $getKabupaten->paginate(10);
        // } catch (\Illuminate\Database\QueryException $e) {
        //     return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        // }
        // catch (Exception $e) {
        //     return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        // }

        return \view('master-item.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Master Item';
        $this->param['btnText'] = 'List Item';
        $this->param['btnLink'] = route('master-item.index');

        return \view('master-item.create', $this->param);
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
