<?php

namespace App\Http\Controllers;

use App\Helpers\MicrosoftGraphHelper;
use Illuminate\Http\Request;


class UploadOnedriveController extends Controller
{
    public function index() {
        return view('upload-onedrive.index');
    }

    public function store(Request $request) {
        $helper = new MicrosoftGraphHelper;
        $file = $request->file('file');
        // dd($file);
        $filename = $file->getClientOriginalName();
        $filepath = $file->path();
        // return file_get_contents($filepath);
        return $helper->upload($request, $filepath, $filename);
    }
}
