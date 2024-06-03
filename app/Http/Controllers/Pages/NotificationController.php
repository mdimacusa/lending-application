<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    private $notification;
    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    public function borrow_notification()
    {
        $response = $this->notification->get_borrow_notification();
        return response()->json($response);
    }

    public function fund_notification()
    {
        $response = $this->notification->get_fund_notification();
        return response()->json($response);
    }

    public function notification_count()
    {
        $response = $this->notification->get_notification_count();
        return response()->json($response);
    }

    public function seen_notification($id)
    {
        $response = $this->notification->seen_notification($id);
        return response()->json($response);
    }
}
