<?php

namespace App\Http\Controllers\Dagulir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DagulirController extends Controller
{
    public function index()
    {
        return view('dagulir.index');
    }
}
