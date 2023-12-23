<?php

namespace App\Http\Controllers\Dagulir\master;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \App\Http\Requests\KecamatanRequest;
use \App\Models\Kecamatan;
use \App\Models\Kabupaten;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

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
            $this->param['allKab'] = Kabupaten::all();
            // return $this->param['allKab'];
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

            $data =  Kecamatan::where('kecamatan','LIKE', "%{$request->kecamatan}%")
            ->Where('id_kabupaten','LIKE', "%{$request->kabupaten}%")
            ->first();

            if ($data) {
                alert()->error('error', 'Kecamatan sudah ada.');
                return back()->withError('Terjadi kesalahan.');
            }

            $kecamatan = new kecamatan;
            $kecamatan->kecamatan = $validated['kecamatan'];
            $kecamatan->id_kabupaten = $validated['id_kabupaten'];
            $kecamatan->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }
        alert()->success('Berhasil','Berhasil menambahkan data');
        return redirect()->route('dagulir.master.kecamatan.index')->withStatus('Data berhasil disimpan.');
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
        $kecamatan = Kecamatan::findOrFail($request->get('id'));
        $validatedData = Validator::make($request->all(),
            [
                'kecamatan' => 'required',
                'kabupaten' => 'required',
            ],
        );
        if ($validatedData->fails()) {
            $html = "<ul style='list-style: none;'>";
            foreach($validatedData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ul>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error');
            return redirect()->route('dagulir.master.kabupaten.index');
        }

        try {
            $kecamatan->kecamatan = $request->get('kecamatan');
            $kecamatan->id_kabupaten = $request->get('kabupaten');
            $kecamatan->save();

            alert()->success('Berhasil','Berhasil mengganti data');
            return redirect()->route('dagulir.master.kecamatan.index');
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
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
            $kecamatan = Kecamatan::findOrFail($id);
            $kecamatan->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        alert()->success('Berhasil','Berhasil berhasil dihapus.');
        return redirect()->route('dagulir.master.kecamatan.index');
    }

    public function getKecamatanByKabupatenId($id)
    {
        $kecamatan = Kecamatan::where('id_kabupaten', $id)->get();

        return json_encode($kecamatan);
    }

    function kabupaten() {
        $kabupaten = Kabupaten::get();
        return $kabupaten;
    }
}
