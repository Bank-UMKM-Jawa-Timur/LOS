<?php

namespace App\Repository;

use App\Models\Notifications;
use Illuminate\Support\Facades\DB;

class NotificationsRepository
{
    public function list($user_id=null, $limit=10) {
        $data = Notifications::select('notifications.*', 'u.name', 'u.email', 'u.nip')
                            ->join('users AS u', 'u.id', 'notifications.user_id')
                            ->when($user_id, function ($query) use ($user_id) {
                                $query->where('notifications.user_id', $user_id);
                            })
                            ->latest()
                            ->paginate($limit);

        return $data;
    }

    public function getWithLimit($user_id=null, $limit=5) {
        $data = Notifications::select('notifications.*', 'u.name', 'u.email', 'u.nip')
                                ->join('users AS u', 'u.id', 'notifications.user_id')
                                ->when($user_id, function ($query) use ($user_id) {
                                    $query->where('notifications.user_id', $user_id);
                                })
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