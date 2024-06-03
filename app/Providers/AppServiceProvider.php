<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Services\DashboardService;
use App\Services\Settings\RolesAndPermissionsService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('*', function ($view) {
            if(auth()->user()==NULL){

                $data                   = new DashboardService();
                $currentDate            = Carbon::now('Asia/Manila');
                $today_transaction      = $data->get_today_transaction($currentDate);
                $overall_transaction    = $data->get_overall_transaction();
                $today_income           = $data->get_today_income($currentDate);
                $overall_income         = $data->get_overall_income();
                $total_fund             = $data->get_total_fund();
                $overall_used_fund      = $data->get_overall_used_fund();
                $total_unpaid           = $data->get_total_unpaid();
                $total_partially_paid   = $data->get_total_partially_paid();
                $total_paid             = $data->get_total_paid();


                $view->with('today_transaction', $today_transaction)
                ->with('overall_transaction', $overall_transaction)
                ->with('today_income',$today_income)
                ->with('overall_income',$overall_income)
                ->with('total_fund',$total_fund)
                ->with('overall_used_fund', $overall_used_fund)
                ->with('total_unpaid', $total_unpaid)
                ->with('total_partially_paid', $total_partially_paid)
                ->with('total_paid', $total_paid);


            }else{

                $data                   = new DashboardService();
                $currentDate            = Carbon::now('Asia/Manila');
                $today_transaction      = $data->get_today_transaction($currentDate);
                $overall_transaction    = $data->get_overall_transaction();
                $today_income           = $data->get_today_income($currentDate);
                $overall_income         = $data->get_overall_income();
                $total_fund             = $data->get_total_fund();
                $overall_used_fund      = $data->get_overall_used_fund();
                $total_unpaid           = $data->get_total_unpaid();
                $total_partially_paid   = $data->get_total_partially_paid();
                $total_paid             = $data->get_total_paid();
                $unpaid                 = $data->get_unpaid();
                $partially_paid         = $data->get_partially_paid();
                $fully_paid             = $data->get_fully_paid();
                $client                 = $data->get_clients();
                $administrator          = $data->get_administrator();
                $staff                  = $data->get_staff();
                $roles                  = new RolesAndPermissionsService();

                $view->with('today_transaction', $today_transaction)
                ->with('overall_transaction', $overall_transaction)
                ->with('today_income',$today_income)
                ->with('overall_income',$overall_income)
                ->with('total_fund',$total_fund)
                ->with('overall_used_fund', $overall_used_fund)
                ->with('total_unpaid', $total_unpaid)
                ->with('total_partially_paid', $total_partially_paid)
                ->with('total_paid', $total_paid)
                ->with('unpaid', $unpaid)
                ->with('partially_paid', $partially_paid)
                ->with('fully_paid', $fully_paid)
                ->with('client', $client)
                ->with('administrator', $administrator)
                ->with('staff', $staff)
                ->with('roles', $roles->get_roles());
            }

        });
    }
}
