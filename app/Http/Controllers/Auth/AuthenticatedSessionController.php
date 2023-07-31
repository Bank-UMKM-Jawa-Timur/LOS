<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::select('nip')
                    ->where('email', $request->email)
                    ->first();

        if ($user) {
            if (isset($user->nip)) {
                $pw = User::select('password')->where('nip',$user->nip)->first();
                if(\Hash::check($request->password, $pw->password)) {
                    $request->authenticate();
                    if(DB::table('sessions')->where('user_id', auth()->user()->id)->count() > 0){
                        Auth::guard('web')->logout();

                        $request->session()->invalidate();

                        $request->session()->regenerateToken();
                        return back()->withError("Akun sedang digunakan di perangkat lain.");
                    }

                    $request->session()->regenerate();

                    return redirect()->intended(RouteServiceProvider::HOME);
                }else{
                    return back()->withError("Password yang anda masukan salah");
                }
            }
            else {
                return back()->withError("Belum dilakukan Pengkinian Data User untuk $request->email.\nHarap menghubungi Divisi Pemasaran atau TI & AK.");
            }
        }
        else {
            return back()->withError("Akun tidak ditemukan");
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
