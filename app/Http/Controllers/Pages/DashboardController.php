<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Interfaces\DashboardServiceInterface;
class DashboardController extends Controller
{
    public function index(DashboardServiceInterface $dashboard_service)
    {
        $fivedays_before = $dashboard_service->get_data();
        return view('pages.dashboard',compact('fivedays_before'));
    }

}
