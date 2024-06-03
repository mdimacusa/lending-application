<?php

namespace App\Http\Controllers\Pages\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\EventNotification;

class BorrowNotificationResponseController extends Controller
{
    public function notification_response($data)
    {
        return response()->json(['status'=>'success','data'=>$data]);
    }

}


