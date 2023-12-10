<?php

namespace App\Http\Controllers\Api\Pemprov;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Doctrine\DBAL\Query\QueryException;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CabangController extends Controller
{
    public function listCabang(){
        $data = [];
        $message = '';
        $status = '';
        $req_status = Response::HTTP_OK;

        try{
            $data = Cabang::select('id', 'cabang')
                ->orderBy('id', 'asc')
                ->get();
            $status = 'berhasil';
            $message = 'Berhasil menampilkan list cabang';
        } catch(Exception $e){
            $status = 'gagal';
            $message = $e->getMessage();
            $req_status = Response::HTTP_BAD_REQUEST;
        } catch(QueryException $e){
            $status = 'gagal';
            $message = $e->getMessage();
            $req_status = Response::HTTP_BAD_REQUEST;
        } finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $req_status);
        }
    }

    public function getCabangById(Request $request){
        try{
            $id = $request->get('id');
            $data = Cabang::select('id', 'cabang')
                ->where('id', $id)
                ->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'data' => $data
            ]);
        } catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        } catch(QueryException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
