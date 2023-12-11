<?php

namespace App\Http\Controllers\Dagulir;

use App\Http\Controllers\Controller;
use App\Models\PengajuanDagulir;
use App\Models\PengajuanModel;
use App\Services\TemporaryService;
use Exception;
use App\Repository\MasterItemRepository;
use App\Repository\PengajuanDagulirRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DagulirController extends Controller
{

    private $repo;
    public function __construct()
    {
        $this->repo = new PengajuanDagulirRepository;
    }

    public function index(Request $request)
    {
        // paginate
        $limit = $request->has('page_length') ? $request->get('page_length') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        // search
        $search = $request->get('q');
        $pengajuan_degulir = $this->repo->get($search,$limit,$page);

        return view('dagulir.index',[
            'data' => $pengajuan_degulir
        ]);
    }

    public function review($id)  {
        $pengajuan_degulir = $this->repo->detail($id);
        $itemRepo = new MasterItemRepository;
        $item = $itemRepo->get([13]);
        // return $item;

        return view('dagulir.form.review',[
            'data' => $pengajuan_degulir,
            'items' => $item,
        ]);
    }

    public function updateReview(Request $request) {
        $statusSlik = false;
        $findRupiah = array('Rp ', '.', ',') ;
        $request->validate([
            ''
        ]);
        try {
            DB::beginTransaction();
            $updatePengajuan = PengajuanModel::where('dagulir_id',$request->get('dagulir_id'))->first();
            $updatePengajuan->progress_pengajuan_data = $request->progress;
            $updatePengajuan->update();

            // Tempory
            $tempNasabah = TemporaryService::getNasabahData($request->idCalonNasabah);
            DB::table('temporary_calon_nasabah')
                ->where('id_user', $request->user()->id)
                ->first('id_user');

        } catch (Exception $e) {
            //throw $th;
        }
    }


}
