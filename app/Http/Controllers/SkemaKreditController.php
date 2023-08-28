<?php

namespace App\Http\Controllers;

use App\Models\SkemaKreditModel;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkemaKreditController extends Controller
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

    public function index()
    {
        $this->param['pageTitle'] = 'List Skema Kredit';
        $this->param['btnText'] = 'Tambah Skema';
        $this->param['btnLink'] = route('skema-kredit.create');
        $this->param['dataSkemaKredit'] = SkemaKreditModel::paginate(10);

        return \view('skema-kredit.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Skema';
        $this->param['btnText'] = 'List Skema Kredit';
        $this->param['btnLink'] = route('skema-kredit.index');
        $this->param['dataSkemaKredit'] = SkemaKreditModel::all();

        return \view('skema-kredit.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama produk kredit harus diisi.',
        ]);

        try{
            SkemaKreditModel::insert([
                'name' => $request->name,
                'created_at' => now()
            ]);

            return redirect()->route('skema-kredit.index')->withStatus('Data berhasil ditambahkan.');
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('skema-kredit.index')->withStatus('Terjadi kesalahan. '.$e->getMessage());
        } catch(QueryException $e){
            DB::rollBack();
            return redirect()->route('skema-kredit.index')->withStatus('Terjadi kesalahan. '.$e->getMessage());
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
        $this->param['pageTitle'] = 'Edit Skema Kredit';
        $this->param['name'] = SkemaKreditModel::find($id);
        $this->param['btnText'] = 'List Produk Kredit';
        $this->param['btnLink'] = route('skema-kredit.index');

        return view('skema-kredit.edit', $this->param);
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
        $name = SkemaKreditModel::findOrFail($id);

        $validatedData = $request->validate(
            [
                'name' => 'required',
            ],
        );

        try {
            $name->name = $request->get('name');
            $name->save();

            
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('skema-kredit.index')->withStatus('Data berhasil diperbarui.');
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
            $name = SkemaKreditModel::findOrFail($id);
            $name->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('skema-kredit.index')->withStatus('Data berhasil dihapus.');
    }
}
