<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PemprovToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!isset($_SERVER['HTTP_TOKEN'])){
            return response()->json([
                'status' => 'gagal',
                'message' => 'Harap masukkan token API.'
            ], Response::HTTP_UNAUTHORIZED);
        } else{
            if($_SERVER['HTTP_TOKEN'] == 'gTWx1U1bVhtz9h51cRNoiluuBfsHqty5MCdXRdmWthFDo9RMhHgHIwrU9DBFVaNj'){
                return $next($request);
            }
            // return response()->json('Unauthorized', 401);
            return response()->json([
                'status' => 'gagal',
                'message' => 'Token yang anda masukkan salah.'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
