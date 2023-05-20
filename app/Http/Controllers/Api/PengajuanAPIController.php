<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanAPIController extends Controller
{
    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Authorized',
            'email' => $user->email,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function getDataPengajuan()
    {
        $data = DB::table('pengajuan')
            ->where('skema_kredit', 'KKB')
            ->whereNotNull('po')
            ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
            ->join('data_po', 'data_po.id_pengajuan', 'pengajuan.id')
            ->select('pengajuan.id', 'calon_nasabah.nama', 'calon_nasabah.jumlah_kredit', 'data_po.no_po')
            ->get();
        
        return response()->json($data);
    }

    public function getFilePO($id)
    {
        $data = DB::table('pengajuan')
            ->where('id', $id)
            ->select('po')
            ->first();
        $path = asset('..') . '/upload/' . $id . '/po/' .$data->po;

        return response()->json(['path' => $path]);
    }
    public function getFileSPPK($id)
    {
        $data = DB::table('pengajuan')
            ->where('id', $id)
            ->select('sppk')
            ->first();
        $path = asset('..') . '/upload/' . $id . '/sppk/' .$data->sppk;

        return response()->json(['path' => $path]);
    }

    public function getFilePK($id)
    {
        $data = DB::table('pengajuan')
            ->where('id', $id)
            ->select('pk')
            ->first();
        $path = asset('..') . '/upload/' . $id . '/pk/' .$data->pk;

        return response()->json(['path' => $path]);
    }
}
