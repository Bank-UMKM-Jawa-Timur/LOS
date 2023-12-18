<?php

namespace App\Http\Controllers\Dagulir\master;

use App\Http\Controllers\Controller;

use App\Models\MerkModel;
use App\Models\TipeModel;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class NewTipeController extends Controller
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
        $this->param['parentMenu'] = '/tipe';
        $this->param['current'] = 'Tipe';
    }

    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Tipe';
        $this->param['btnText'] = 'Tambah Tipe';
        $this->param['btnLink'] = route('tipe.create');
        $this->param['dataMerk'] = MerkModel::all();
        $search = $request->get('q');
        $limit = $request->has('page_length') ? $request->get('page_length') : 10;
        $getTipe = TipeModel::orderBy('id');
        if ($search) {
            $getTipe->where('tipe', 'LIKE', "%{$search}%");
        }
        $this->param['data'] = $getTipe->paginate($limit);

        return \view('dagulir.master.tipe.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Tipe';
        $this->param['btnText'] = 'List Tipe';
        $this->param['btnLink'] = route('tipe.index');
        $this->param['dataMerk'] = MerkModel::all();

        return \view('tipe.create', $this->param);
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
            'id_merk' => 'required',
            'tipe' => 'required'
        ], [
            'id_merk.required' => 'Merk harus diisi.',
            'tipe.required' => 'Tipe harus diisi.'
        ]);

        try {
            TipeModel::insert([
                'id_merk' => $request->id_merk,
                'tipe' => $request->tipe,
                'created_at' => now()
            ]);

            return redirect()->route('tipe.index')->withStatus('Data berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('tipe.index')->withStatus('Terjadi kesalahan. ' . $e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('tipe.index')->withStatus('Terjadi kesalahan. ' . $e->getMessage());
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
        $this->param['pageTitle'] = 'Edit Tipe';
        $tipe = TipeModel::find($id);
        $this->param['tipe'] = $tipe;
        $this->param['btnText'] = 'List Tipe';
        $this->param['btnLink'] = route('tipe.index');
        $this->param['dataMerk'] = MerkModel::all();

        return view('tipe.edit', $this->param);
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
        $tipe = TipeModel::findOrFail($id);

        $request->validate([
            'id_merk' => 'required',
            'tipe' => 'required'
        ], [
            'id_merk.required' => 'Merk harus diisi.',
            'tipe.required' => 'Tipe harus diisi.'
        ]);
        try {
            $tipe->id_merk = $request->id_merk;
            $tipe->tipe = $request->tipe;
            $tipe->updated_at = now();
            $tipe->save();

            return redirect()->route('tipe.index')->withStatus('Data berhasil diubah.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('tipe.index')->withStatus('Terjadi kesalahan. ' . $e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('tipe.index')->withStatus('Terjadi kesalahan. ' . $e->getMessage());
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
        try {
            $tipe = TipeModel::findOrFail($id);
            $tipe->delete();

            return redirect()->route('tipe.index')->withStatus('Data berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('tipe.index')->withStatus('Terjadi kesalahan. ' . $e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('tipe.index')->withStatus('Terjadi kesalahan. ' . $e->getMessage());
        }
    }
}
