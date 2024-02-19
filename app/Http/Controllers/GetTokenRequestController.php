<?php

namespace App\Http\Controllers;

use App\Auth\DeviceCodeTokenProvider;
use Illuminate\Http\Request;

class GetTokenRequestController extends Controller
{
    protected $tokenProvider;

    public function __construct(DeviceCodeTokenProvider $tokenProvider)
    {
        $this->tokenProvider = $tokenProvider;
    }

    public function getToken()
    {
        // Panggil metode untuk mendapatkan token dari DeviceCodeTokenProvider
        $tokenPromise = $this->tokenProvider->getAuthorizationTokenAsync('https://graph.microsoft.com');

        // Tunggu hingga janji (promise) selesai
        $tokenPromise->then(function ($token) {
            // Lakukan sesuatu dengan token, seperti mengembalikannya sebagai response
            return response()->json(['token' => $token]);
        })->wait(); // Tunggu hingga janji selesai

        // Jika Anda ingin melakukan sesuatu setelah mendapatkan token, Anda dapat melakukannya di sini
    }
}
