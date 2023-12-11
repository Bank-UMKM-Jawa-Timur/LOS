<?php

namespace App\Http\Controllers\Dagulir;

use App\Http\Controllers\Controller;
use App\Models\PengajuanDagulir;
use App\Repository\PengajuanDegulirRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DagulirController extends Controller
{

    private $repo;
    public function __construct()
    {
        $this->repo = new PengajuanDegulirRepository;
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

    function review($id)  {
        $pengajuan_degulir = $this->repo->detail($id);

        return view('dagulir.form.review',[
            'data' => $pengajuan_degulir
        ]);
    }
}
