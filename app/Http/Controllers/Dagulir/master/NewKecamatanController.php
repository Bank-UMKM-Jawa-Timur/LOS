<?php

namespace App\Http\Controllers\Dagulir\master;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \App\Http\Requests\KecamatanRequest;
use \App\Models\Kecamatan;
use \App\Models\Kabupaten;
use Exception;
use Illuminate\Database\QueryException;

class NewKecamatanController extends Controller
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
        $this->param['parentMenu'] = '/kabupaten';
        $this->param['current'] = 'Kabupaten';
    }

    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Kecamatan';
        $this->param['btnText'] = 'Tambah Kecamatan';
        $this->param['btnLink'] = route('kecamatan.create');

        try {
            $search = $request->get('q');
            $limit = $request->has('page_length') ? $request->get('page_length') : 10;
            $page = $request->has('page') ? $request->get('page') : 1;
            $getKecamatan = Kecamatan::with('kabupaten')->orderBy('id', 'ASC');
            if ($search) {
                $getKecamatan->where('id', 'LIKE', "%{$search}%")->orWhere('kecamatan', 'LIKE', "%{$search}%");
            }

            $this->param['data'] = $getKecamatan->paginate($limit);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('dagulir.master.kecamatan.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Kecamatan';
        $this->param['btnText'] = 'List Kecamatan';
        $this->param['btnLink'] = route('kecamatan.index');
        $this->param['allKab'] = Kabupaten::get();


        return \view('kecamatan.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KecamatanRequest $request)
    {
        /*
        TODO
        1. validasi form
        2. simpan ke db
        3. redirect ke index
        */

        $validated = $request->validated();
        try {
            $kecamatan = new kecamatan;
            $kecamatan->kecamatan = $validated['kecamatan'];
            $kecamatan->id_kabupaten = $validated['id_kabupaten'];
            $kecamatan->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('kecamatan.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['pageTitle'] = 'Edit Kecamatan';
        $this->param['kecamatan'] = kecamatan::find($id);
        $this->param['btnText'] = 'List Kecamatan';
        $this->param['btnLink'] = route('kecamatan.index');
        $this->param['allKab'] = Kabupaten::get();

        return view('kecamatan.edit', $this->param);
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
        $kecamatan = Kecamatan::findOrFail($id);

        $validatedData = $request->validate(
            [
                'kecamatan' => 'required',
                'id_kabupaten' => 'required',
            ],
        );

        try {
            $kecamatan->kecamatan = $request->get('kecamatan');
            $kecamatan->id_kabupaten = $request['id_kabupaten'];
            $kecamatan->save();
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('kecamatan.index')->withStatus('Data berhasil diperbarui.');
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
            $kecamatan = Kecamatan::findOrFail($id);
            $kecamatan->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('kecamatan.index')->withStatus('Data berhasil dihapus.');
    }

    public function getKecamatanByKabupatenId($id)
    {
        $kecamatan = Kecamatan::where('id_kabupaten', $id)->get();

        return json_encode($kecamatan);
    }
}
