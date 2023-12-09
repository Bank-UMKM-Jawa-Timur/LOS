<?php

namespace App\Http\Controllers\Api\Pemprov;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function listKota(){
        try{
            $data = Kabupaten::select('id', 'kabupaten')
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

    public function getKotaById(Request $request){
        try{
            $id = $request->get('id');
            $data = Kabupaten::select('id', 'kabupaten')
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
