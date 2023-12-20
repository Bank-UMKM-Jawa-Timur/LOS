<?php

namespace App\Http\Controllers;

use App\Repository\NotificationsRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request) {
        $notifRepo = new NotificationsRepository;
        $search = $request->get('q');
        $limit = $request->has('page_length') ? $request->get('page_length') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $data = $notifRepo->list(auth()->user()->id, $search, $limit);

        return view('dagulir.notification.index', compact('data'));
    }
}
