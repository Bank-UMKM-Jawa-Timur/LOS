<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\OptionModel;
use Exception;
use Illuminate\Database\QueryException;
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
    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Master Item';
        $this->param['btnText'] = 'Tambah Item';
        $this->param['btnLink'] = route('master-item.create');

        try {
            $keyword = $request->get('keyword');
            $getItem = ItemModel::select('item.*', 'i.nama as parent_name')
            ->leftJoin('item as i', 'i.id', 'item.id_parent')->orderBy('id','DESC');

            if ($keyword) {
                $getItem->where('item.nama', 'LIKE', "%{$keyword}%");
            }

            $this->param['item'] = $getItem->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return $e;
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

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
        // $this->param['itemsatu'] = ItemModel::select('*')->where('level', 1)->get();

        return \view('master-item.create', $this->param);
    }
    public function dataItemSatu(Request $request)
    {
        $data = ItemModel::where('level', 1)->pluck('id','nama');
        return response()->json($data);
    }
    public function dataItemTiga(Request $request)
    {
        // $data = ItemModel::select('id','nama','level')->orderBy('level', 2)->orderBy('level', )->get();
        $req = $request->itemTiga;
        $data = ItemModel::where('id_parent',$req)->where('level',2)->pluck('id','nama');
        return response()->json($data);
    }
    public function dataItemEmpat(Request $request)
    {
        $req = $request->itemEmpat;
        $data = ItemModel::where('id_parent',$req)->where('level',3)->pluck('id','nama');
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if ($request->get('opsi') != null) {
        //     foreach ($request->get('opsi') as $key => $value) {
        //         $validation['opsi.'.$key.'.opsi_name'] = 'required';
        //         $validation['opsi.'.$key.'.skor'] = 'required';
        //     }
        //     $this->validate($request, $validation);
        // }
        $request->validate([
            // 'opsi_jawaban' => 'required|not_in:0',
            'nama' => 'required'
        ],[
            'required' => 'data harus terisi.',
            'not_in' => 'data harus terisi.',
        ]);
        // return $request;
        try {
            $addItem = new ItemModel;
            $addItem->nama = $request->get('nama');
            $addItem->level = $request->get('level');
            $addItem->opsi_jawaban = $request->get('opsi_jawaban');
            $addItem->is_commentable = $request->get('is_commentable');
            $addItem->status_skor = $request->get('status_skor');

            if ($request->level == 2) {
                $addItem->id_parent = $request->item_turunan;
            }elseif ($request->level == 3) {
                $addItem->id_parent = $request->item_turunan_dua;
            }elseif ($request->level == 4) {
                $addItem->id_parent = $request->item_turunan_tiga;

            }
            // $addItem->id_parent = $request->level != 2 ? $request->item_turunan_dua : $request->item_turunan;
            $addItem->save();

            if ($request->get('opsi_jawaban') == 'option') {
                if ($request->level != 1) {
                    // return 'ada selain 1';
                    if ($request->level == 2) {
                        // return 'ada';
                        // return $request;
                        foreach ($request->get('opsi') as $key => $value) {
                            // return $value['opsi_name'];
                            $addDataOption = new OptionModel;
                            $addDataOption->id_item = $addItem->id;
                            $addDataOption->option = $value['opsi_name'] != null ? $value['opsi_name'] : '-';
                            $addDataOption->skor = $value['skor'];
                            $addDataOption->sub_column = $value['sub_column'];
                            $addDataOption->save();
                        }
                    }elseif ($request->level == 3) {

                        foreach ($request->get('opsi') as $key => $value) {
                            // return $value['opsi_name'];
                            $addDataOption = new OptionModel;
                            $addDataOption->id_item = $addItem->id;
                            $addDataOption->option = $value['opsi_name'] != null ? $value['opsi_name'] : '-';
                            $addDataOption->skor = $value['skor'];
                            $addDataOption->sub_column = $value['sub_column'];
                            $addDataOption->save();
                        }
                    }else{
                        foreach ($request->get('opsi') as $key => $value) {
                            // return $value['opsi_name'];
                            $addDataOption = new OptionModel;
                            $addDataOption->id_item = $addItem->id;
                            $addDataOption->option = $value['opsi_name'] != null ? $value['opsi_name'] : '-';
                            $addDataOption->skor = $value['skor'];
                            $addDataOption->sub_column = $value['sub_column'];
                            $addDataOption->save();
                        }
                    }
                }
            }
            return redirect()->route('master-item.index')->withStatus('Berhasil menambah data.');

        } catch(Exception $e) {
            return back()->withError('Terjadi Kesalahan.' . $e->getMessage());
            return $e;
        }catch (QueryException $e){
            return back()->withError('Terjadi Kesalahan.' . $e->getMessage());
            return $e;
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
        $this->param['pageTitle'] = 'Tambah Master Item';
        $this->param['btnText'] = 'List Item';
        $this->param['btnLink'] = route('master-item.index');

        $this->param['item'] = ItemModel::findOrFail($id);
        $this->param['itemTurunan'] = ItemModel::select('id','nama')->find( $this->param['item']->id_parent);
        $isParent = ItemModel::where('id_parent', $id)->count() > 0 ? true : false;
        $this->param['isParent'] = $isParent;

        $this->param['opsi'] = OptionModel::where('id_item',$id)->get();
        return view('master-item.edit',$this->param);
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
       $request->validate([
           'nama' => 'required',
        //    'option.*' => 'required',
        //    'skor.*' => 'required',
       ]);
        try {
            $updateItem = ItemModel::find($id);
            $updateItem->nama = $request->get('nama');
            $updateItem->opsi_jawaban = $request->get('opsi_jawaban');
            $updateItem->is_commentable = $request->get('is_commentable');
            $updateItem->save();
            if ($request->id_detail != null) {
                foreach ($request->id_detail as $key => $value) {
                    if ($request->id_detail[$key] != 0) {
                        $updateOption = OptionModel::select('option','skor')->where('id',$request->id_detail[$key])->get();
                        OptionModel::where('id',$request->id_detail[$key])->update([
                            'option' => $request->option[$key],
                            'skor' => $request->skor[$key],
                            // 'sub_column' => $request->sub_column[$key],
                        ]);
                    }else{
                        $newOptionItem = new OptionModel;
                        $newOptionItem->id_item = $request->get('id_item');
                        $newOptionItem->option = $request->get('option')[$key];
                        $newOptionItem->skor = $request->get('skor')[$key];
                        // $newOptionItem->sub_column = $request->get('sub_column')[$key];
                        $newOptionItem->save();
                    }

                }
                if (isset($request->id_delete)) {
                    foreach ($request->id_delete as $key => $value) {
                         OptionModel::where('id',$request->id_delete)->delete();
                    }
                }
            }
            return redirect()->route('master-item.index')->withStatus('Berhasil mengupdate data.');

        } catch(Exception $e) {
            return back()->withError('Terjadi Kesalahan.');
        }catch (QueryException $e){
            return back()->withError('Terjadi Kesalahan.');
        }
    }

    public function addEditItem(Request $request)
    {
        $fields = array(
            'option' => 'option',
            'skor' => 'skor',
        );
        $next = $_GET['biggestNo'] + 1;


        return view('master-item.editDetail', ['hapus' => true, 'no' => $next, 'fields' => $fields, 'idDetail' => '0']);
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
            $data = OptionModel::where('id_item',$id)->delete();
            $deleteItem = ItemModel::find($id)->delete();
            return redirect()->route('master-item.index')->withStatus('Berhasil menghapus data.');

        } catch(Exception $e) {
            return $e;
            return redirect()->back()->withStatus('Terjadi Kesalahan.');
        }catch (QueryException $e){
            return $e;
            return redirect()->back()->withStatus('Terjadi Kesalahan.');
        }
    }
}
