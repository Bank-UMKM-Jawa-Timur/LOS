<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{  
    public function index()
    {
        $param['pageTitle'] = "Analisa Kredit";

        return view('dashboard',$param);
    }
}
