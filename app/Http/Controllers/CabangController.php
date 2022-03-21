<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\CabangRequest;
use \App\Models\Cabang;
use \App\Models\Kabupaten;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
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
        $this->param['parentMenu'] = '/cabang';
        $this->param['current'] = 'Kantor Cabang';
    }
    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Kantor Cabang';
        $this->param['btnText'] = 'Tambah Cabang';
        $this->param['btnLink'] = route('cabang.create');

        try {
            $keyword = $request->get('keyword');
            $getCabang = Cabang::orderBy('kode_cabang', 'ASC');

            if ($keyword) {
                $getCabang->where('kode_cabang', 'LIKE', "%{$keyword}%")->orWhere('cabang', 'LIKE', "%{$keyword}%");
            }

            $this->param['cabang'] = $getCabang->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('cabang.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Kantor Cabang';
        $this->param['btnText'] = 'List Kantor Cabang';
        $this->param['btnLink'] = route('cabang.index');


        return \view('cabang.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CabangRequest $request)
    {
        $validated = $request->validated();
        try {
            $cabang = new Cabang;
            $cabang->kode_cabang = $validated['kode_cabang'];
            $cabang->cabang = $validated['cabang'];
            $cabang->alamat = $validated['alamat'];
            $cabang->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('cabang.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['pageTitle'] = 'Edit Kantor Cabang';
        $this->param['cabang'] = Cabang::find($id);
        $this->param['btnText'] = 'List Cabang';
        $this->param['btnLink'] = route('cabang.index');

        return view('cabang.edit', $this->param);
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
        $kode_cabang = Cabang::find($id);
        $isUniqueKodeCabang = $kode_cabang->kode_cabang == $request->kode_cabang ? '' : '|unique:cabang';
        $validatedData = $request->validate(
            [
                'kode_cabang' => 'required'.$isUniqueKodeCabang,
                'cabang' => 'required',
                'alamat' => 'required',
            ],
        );

        try {
            $cabang = Cabang::findOrFail($id);
            $cabang->kode_cabang = $request->get('kode_cabang');
            $cabang->cabang = $request->get('cabang');
            $cabang->alamat = $request['alamat'];
            $cabang->save();


        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('cabang.index')->withStatus('Data berhasil diperbarui.');
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
            $cabang = Cabang::findOrFail($id);
            $cabang->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('cabang.index')->withStatus('Data berhasil dihapus.');
    }
}
