<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\PengajuanModel;
use App\Repository\NotificationsRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    private $notifRepo;

    public function __construct()
    {
        $this->notifRepo = new NotificationsRepository;
    }
    public function index(Request $request) {
        $this->notifRepo = new NotificationsRepository;
        $search = $request->get('q');
        $limit = $request->has('page_length') ? $request->get('page_length') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $data = $this->notifRepo->list(auth()->user()->id, $search, $limit);

        return view('dagulir.notification.index', compact('data'));
    }

    public function getDetail(Request $request){
        DB::beginTransaction();
        try{
            $id = $request->get('id');
            $this->notifRepo->read($id);
            $pengajuanId = DB::table('notifications')->where('id', $id)->first()->object_id;
            
            $dataDetail = $this->notifRepo->detailNotif($pengajuanId);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil membaca notifikasi',
                'data' => $dataDetail
            ]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        } catch(QueryException $e){
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request){
        DB::beginTransaction();
        try{
            $id = $request->get('id');
            $this->notifRepo->delete($id);
            DB::commit();

            return redirect()->route('dagulir.notification.index');
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('dagulir.notification.index');
        } catch(QueryException $e){
            DB::rollBack();
            return redirect()->route('dagulir.notification.index');
        }
    }
}
