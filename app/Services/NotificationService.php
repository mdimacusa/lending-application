<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function get_borrow_notification()
    {
        $query = Notification::where(['user_id' => auth()->user()->id,'category'=>'Borrow','_seen' => 'No'])
        ->orderBy('created_at','DESC')
        ->orderBy('id','DESC')
        ->get();
        return $query;
    }
    public function get_fund_notification()
    {
        $query = Notification::where(['user_id' => auth()->user()->id,'category'=>'Fund','_seen' => 'No'])
        ->orderBy('created_at','DESC')
        ->orderBy('id','DESC')
        ->get();
        return $query;
    }
    public function get_notification_count()
    {
        $query = Notification::where(['user_id' => auth()->user()->id,'_seen' => 'No'])
        ->count();
        return $query;
    }

    public function seen_notification($id)
    {
        $query = Notification::where('id',$id)
        ->update([
            '_seen' => 'Yes',
        ]);
        return $query;
    }
}
