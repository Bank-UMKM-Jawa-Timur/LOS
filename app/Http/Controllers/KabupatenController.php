<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\KabupatenRequest;
use \App\Models\Kabupaten;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class KabupatenController extends Controller
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
            $keyword = $request->get('keyword');
            $getKabupaten = Kabupaten::orderBy('id', 'ASC');

            if ($keyword) {
                $getKabupaten->where('id', 'LIKE', "%{$keyword}%")->orWhere('kabupaten', 'LIKE', "%{$keyword}%");
            }

            $this->param['kabupaten'] = $getKabupaten->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('kabupaten.index', $this->param);
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
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('kabupaten.index')->withStatus('Data berhasil disimpan.');
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
        $kabupaten = Kabupaten::findOrFail($id);

        $validatedData = $request->validate(
            [
                'kabupaten' => 'required',
            ],
        );

        try {
            $kabupaten->kabupaten = $request->get('kabupaten');
            $kabupaten->save();

            
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('kabupaten.index')->withStatus('Data berhasil diperbarui.');
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
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('kabupaten.index')->withStatus('Data berhasil dihapus.');
    }
}
