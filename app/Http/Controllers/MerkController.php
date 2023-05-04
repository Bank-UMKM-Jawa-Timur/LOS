<?php

namespace App\Http\Controllers;

use App\Models\MerkModel;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $param;

    public function __construct()
    {
        $this->param['pageIcon'] = 'fa fa-database';
        $this->param['parentMenu'] = '/merk';
        $this->param['current'] = 'Merk';
    }

    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Merk';
        $this->param['btnText'] = 'Tambah Merk';
        $this->param['btnLink'] = route('merk.create');
        $this->param['dataMerk'] = MerkModel::paginate(10);

        return \view('merk.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Merk';
        $this->param['btnText'] = 'List Merk';
        $this->param['btnLink'] = route('merk.index');

        return \view('merk.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        TODO
        1. validasi form
        2. simpan ke db
        3. redirect ke index
        */

        $request->validate([
            'merk' => 'required'
        ], [
            'merk.required' => 'Merk harus diisi.'
        ]);

        try{
            MerkModel::insert([
                    'merk' => $request->merk,
                    'created_at' => now()
                ]);

            return redirect()->route('merk.index')->withStatus('Data berhasil ditambahkan.');
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('merk.index')->withStatus('Terjadi kesalahan. '.$e);
        } catch(QueryException $e){
            DB::rollBack();
            return redirect()->route('merk.index')->withStatus('Terjadi kesalahan. '.$e);
        }
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
        $this->param['pageTitle'] = 'Edit Merk';
        $merk = MerkModel::find($id);
        $this->param['merk'] = $merk;
        $this->param['btnText'] = 'List Merk';
        $this->param['btnLink'] = route('merk.index');
        
        return view('merk.edit', $this->param);
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
        $merk = MerkModel::findOrFail($id);

        $validate = $request->validate([
            'merk' => 'required'
        ], [
            'merk.required' => 'Merk harus diisi.'
        ]);

        try{
            $merk->merk = $request->merk;
            $merk->updated_at = now();
            $merk->save();

            return redirect()->route('merk.index')->withStatus('Data berhasil diubah.');
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('merk.index')->withStatus('Terjadi kesalahan. '.$e);
        } catch(QueryException $e){
            DB::rollBack();
            return redirect()->route('merk.index')->withStatus('Terjadi kesalahan. '.$e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $merk = MerkModel::findOrFail($id);
            $merk->delete();

            return redirect()->route('merk.index')->withStatus('Data berhasil dihapus.');
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('merk.index')->withStatus('Terjadi kesalahan. '.$e);
        } catch(QueryException $e){
            DB::rollBack();
            return redirect()->route('merk.index')->withStatus('Terjadi kesalahan. '.$e);
        }
    }
}
