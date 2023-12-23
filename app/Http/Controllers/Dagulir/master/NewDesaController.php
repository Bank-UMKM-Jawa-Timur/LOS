<?php

namespace App\Http\Controllers\Dagulir\master;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \App\Http\Requests\DesaRequest;
use \App\Models\Desa;
use \App\Models\Kabupaten;
use \App\Models\Kecamatan;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class NewDesaController extends Controller
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
        $this->param['parentMenu'] = '/desa';
        $this->param['current'] = 'Desa';
    }

    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Desa';
        $this->param['btnText'] = 'Tambah Desa';
        $this->param['btnLink'] = route('desa.create');

        try {
            $search = $request->get('q');
            $limit = $request->has('page_length') ? $request->get('page_length') : 10;
            $page = $request->has('page') ? $request->get('page') : 1;
            $getDesa = Desa::with('kecamatan', 'kecamatan.kabupaten')->orderBy('id', 'ASC');

            if ($search) {
                $getDesa->where('id', 'LIKE', "%{$search}%")->orWhere('desa', 'LIKE', "%{$search}%");
            }
            $this->param['data'] = $getDesa->paginate($limit);
            $this->param['kabupaten'] = Kabupaten::all();
            $this->param['kecamatan'] = Kecamatan::all();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('dagulir.master.desa.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Desa';
        $this->param['btnText'] = 'List Desa';
        $this->param['btnLink'] = route('desa.index');
        $this->param['allKab'] = Kabupaten::get();
        $this->param['allKec'] = Kecamatan::get();

        return \view('desa.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesaRequest $request)
    {
        /*
        TODO
        1. validasi form
        2. simpan ke db
        3. redirect ke index
        */

        $validated = $request->validated();
        try {
            $data = Desa::where('desa', 'LIKE', "%{$request->desa}%")
            ->where('id_kecamatan', 'LIKE', "%{$request->id_kecamatan}%")
            ->Where('id_kabupaten', 'LIKE', "%{$request->id_kabupaten}%")
            ->first();

            if ($data) {
                alert()->error('error', 'Kecamatan sudah ada.');
                return back()->withError('Terjadi kesalahan.');
            }

            $desa = new desa;
            $desa->id_kabupaten = $validated['id_kabupaten'];
            $desa->id_kecamatan = $validated['id_kecamatan'];
            $desa->desa = $validated['desa'];
            $desa->save();

        } catch (Exception $e) {
            alert()->error('error', 'Terjadi kesalahan.');
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            alert()->error('error', 'Terjadi kesalahan.');
            return back()->withError('Terjadi kesalahan.');
        }
        alert()->success('Berhasil','Berhasil menambahkan data.');
        return redirect()->route('dagulir.master.desa.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['pageTitle'] = 'Edit Desa';
        $desa = Desa::find($id);
        $this->param['desa'] = $desa;
        $this->param['btnText'] = 'List Desa';
        $this->param['btnLink'] = route('desa.index');
        $this->param['allKab'] = Kabupaten::get();
        $this->param['allKec'] = Kecamatan::where('id_kabupaten', $desa->id_kabupaten)->get();
        return view('desa.edit', $this->param);
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
        $id_desa = $request->id_desa;
        $desa = Desa::where('id',$id_desa)->first();

        try {
            $data = Desa::where('desa', 'LIKE', "%{$request->desa}%")
            ->where('id_kecamatan', 'LIKE', "%{$request->id_kecamatan}%")
            ->Where('id_kabupaten', 'LIKE', "%{$request->id_kabupaten}%")
            ->first();

            if ($data) {
                alert()->error('error', 'Kecamatan sudah ada.');
                return back()->withError('Terjadi kesalahan.');
            }
            
            $desa->desa = $request->get('desa');
            $desa->id_kecamatan = $request->get('id_kecamatan');
            $desa->id_kabupaten = $request->get('id_kabupaten');
            $desa->save();
        } catch (\Exception $e) {
            alert()->error('error', 'Terjadi kesalahan.');
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            alert()->error('error', 'Terjadi kesalahan.');
            return redirect()->back()->withError('Terjadi kesalahan.');
        }

        alert()->success('Berhasil', 'Berhasil mengganti data');
        return back();
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
            $id_desa = Request()->id_desa;
            $desa = Desa::where('id',$id_desa)->first();
            $desa->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }
        alert()->success('Berhasil', 'Data berhasil dihapus.');
        return back();
    }

    public function kecamatanByKabupaten($id){
        $data = Kecamatan::where('id_kabupaten', $id)->get();

        return json_encode($data);
    }

    public function getDesaByKecamatanId($id)
    {
        $desa = Desa::where('id_kecamatan', $id)->get();

        return json_encode($desa);
    }
}
