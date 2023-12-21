<?php

namespace App\Http\Controllers\Dagulir\master;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \App\Http\Requests\KabupatenRequest;
use \App\Models\Kabupaten;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class NewKabupatenController extends Controller
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
        $this->param['pageTitle'] = 'List Kabupaten';
        $this->param['btnText'] = 'Tambah Kabupaten';
        $this->param['btnLink'] = route('kabupaten.create');

        try {
            $search = $request->get('q');
            $limit = $request->has('page_length') ? $request->get('page_length') : 10;
            $page = $request->has('page') ? $request->get('page') : 1;
            $getKabupaten = DB::table('kabupaten')->orderBy('id', 'ASC');

            if ($search) {
                $getKabupaten->where('id', 'LIKE', "%{$search}%")->orWhere('kabupaten', 'LIKE', "%{$search}%");
            }

            $this->param['data'] = $getKabupaten->paginate($limit);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('dagulir.master.kabupaten.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Kabupaten';
        $this->param['btnText'] = 'List kabupaten';
        $this->param['btnLink'] = route('kabupaten.index');

        return \view('kabupaten.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KabupatenRequest $request)
    {

        /*
        TODO
        1. validasi form
        2. simpan ke db
        3. redirect ke index
        */

        $validated = $request->validated();
        try {
            $kabupaten = new kabupaten;
            $kabupaten->kabupaten = $validated['kabupaten'];
            $kabupaten->save();
        } catch (Exception $e) {
            dd($e);
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            dd($e);
            return back()->withError('Terjadi kesalahan.');
        }
        alert()->success('Berhasil','Berhasil menambahkan data.');
        return redirect()->route('dagulir.master.kabupaten.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['pageTitle'] = 'Edit Kabupaten';
        $this->param['kabupaten'] = Kabupaten::find($id);
        $this->param['btnText'] = 'List Kabupaten';
        $this->param['btnLink'] = route('kabupaten.index');

        return view('kabupaten.edit', $this->param);
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
        $kabupaten = Kabupaten::findOrFail($request->get('id'));

        $validatedData = Validator::make($request->all(),
            [
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
            $kabupaten->kabupaten = $request->get('kabupaten');
            $kabupaten->save();
            alert()->success('Berhasil','Data berhasil diperbarui.');
            return redirect()->route('dagulir.master.kabupaten.index');
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
            $kabupaten = Kabupaten::findOrFail($id);
            $kabupaten->delete();
            alert()->success('Berhasil','Data berhasil diperbarui.');
            return redirect()->route('dagulir.master.kabupaten.index');
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }
    }
}
