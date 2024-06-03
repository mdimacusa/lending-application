<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Soa;
use App\Models\Payment;
use App\Models\PaymentAccount;
use App\Models\CompanyWallet;
use App\Models\Notification;
use App\Models\Client;
use App\Models\User;
use DB;
use App\Interfaces\DashboardServiceInterface;

class DashboardService implements DashboardServiceInterface
{
    public function initialize_data()
    {
        $init_data = [
            'start_date' => Carbon::now()->startOfDay(), // Start of the current day
            'end_date'   => Carbon::now()->addDays(5)->endOfDay()
        ];
        return $init_data;
    }
    public function get_data()
    {
        $init_data = $this->initialize_data();

        $query  = Soa::whereDate('upcoming_due_date', '>=', $init_data['start_date'])
        ->whereDate('upcoming_due_date', '<=', $init_data['end_date'])
        ->whereIn('status',[0,1])
        ->paginate(5);

        return $query;
    }
    public function get_today_transaction($currentdate)
    {
        $query = Payment::whereDate('last_payment_date',$currentdate)
        ->sum('payment_amount');
        return round($query);
    }
    public function get_overall_transaction()
    {
        $query = Payment::sum('payment_amount');
        return round($query);
    }
    public function get_today_income($currentdate)
    {
        $query = PaymentAccount::whereDate('last_payment_date',$currentdate)
        ->where('status',2)
        ->sum('income');
        return round($query);
    }
    public function get_overall_income()
    {
        $query = PaymentAccount::where('status',2)
        ->sum('income');
        return round($query);
    }
    public function get_total_fund()
    {
        $query = CompanyWallet::sum('fund');
        return round($query);
    }
    public function get_overall_used_fund()
    {
        $query = PaymentAccount::sum('amount');
        return $query;
    }
    public function get_total_unpaid()
    {
        $query = PaymentAccount::where('status',0)->count();
        return $query;
    }
    public function get_total_partially_paid()
    {
        $query = PaymentAccount::where('status',1)
        ->count();
        return $query;
    }
    public function get_total_paid()
    {
        $query = PaymentAccount::where('status',2)
        ->count();
        return $query;
    }
    public function get_borrow_notif_credit()
    {
        $query = Notification::where(['user_id' => auth()->user()->id,'category'=>'Borrow','_seen' => 'No'])
        ->orderBy('created_at','DESC')
        ->orderBy('id','DESC')
        ->get();
        return $query;
    }
    public function get_fund_notift()
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
    public function get_unpaid()
    {
        $query =Soa::where('status',0)
        ->count();
        return $query;
    }
    public function get_partially_paid()
    {
        $query = Soa::where('status',1)
        ->count();
        return $query;
    }
    public function get_fully_paid()
    {
        $query = Soa::where('status',2)
        ->count();
        return $query;
    }
    public function get_clients()
    {
        $query = Client::where('status','ACTIVE')
        ->count();
        return $query;
    }
    public function get_administrator()
    {
        $query = User::where('role','ADMINISTRATOR')
        ->count();
        return $query;
    }
    public function get_staff()
    {
        $query = User::where('role','STAFF')
        ->count();
        return $query;
    }

}
