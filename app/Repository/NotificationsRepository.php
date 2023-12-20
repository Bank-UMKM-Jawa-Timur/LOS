<?php

namespace App\Repository;

use App\Models\Notifications;
use Illuminate\Support\Facades\DB;

class NotificationsRepository
{
    public function list($user_id=null, $search=null, $limit=10) {
        $data = Notifications::select('notifications.*', 'u.name', 'u.email', 'u.nip')
                            ->join('users AS u', 'u.id', 'notifications.user_id')
                            ->when($user_id, function ($query) use ($user_id) {
                                $query->where('notifications.user_id', $user_id);
                            })
                            ->when($search, function ($query) use ($user_id, $search) {
                                if ($user_id) {
                                    $query->where(function($q) use ($search) {
                                        $q->where('notifications.message', 'LIKE', "%$search%")
                                        ->orWhere('notifications.created_at', 'LIKE', "%$search%");
                                    })->where('notifications.user_id', $user_id);
                                }
                                else {
                                    $query->where('notifications.message', 'LIKE', "%$search%")
                                    ->orWhere('notifications.created_at', 'LIKE', "%$search%");
                                }
                            })
                            ->latest()
                            ->orderBy('notifications.is_read')
                            ->paginate($limit);

        return $data;
    }

    public function getWithLimit($user_id=null, $limit=5) {
        $data = Notifications::select('notifications.*', 'u.name', 'u.email', 'u.nip')
                                ->join('users AS u', 'u.id', 'notifications.user_id')
                                ->when($user_id, function ($query) use ($user_id) {
                                    $query->where('notifications.user_id', $user_id);
                                })
                                ->where('notifications.is_read', 0)
                                ->latest()
                                ->limit($limit)
                                ->get();

        return $data;
    }

    public function store($notification) {
        DB::table('notifications')->insert($notification);
    }

    public function read($id) {
        DB::table('notifications')
            ->where('id', $id)
            ->update([
                'is_read' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function delete($id) {
        DB::table('notifications')->delete($id);
    }
}