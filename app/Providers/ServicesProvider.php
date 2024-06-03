<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\DashboardService;
use App\Services\BorrowService;
use App\Services\DepositFundService;
use App\Services\PaymentService;
use App\Services\UserManagement\ClientService;
use App\Services\UserManagement\AdministratorService;
use App\Services\Reports\CompanyIncomeService;
use App\Services\Reports\OverallLoanService;
use App\Services\Reports\FundHistoryService;
use App\Services\Reports\TopBorrowerService;
use App\Services\Settings\RolesAndPermissionsService;
use App\Interfaces\DashboardServiceInterface;
use App\Interfaces\BorrowServiceInterface;
use App\Interfaces\DepositFundServiceInterface;
use App\Interfaces\PaymentServiceInterface;
use App\Interfaces\UserManagement\ClientServiceInterface;
use App\Interfaces\UserManagement\AdministratorServiceInterface;
use App\Interfaces\Reports\CompanyIncomeServiceInterface;
use App\Interfaces\Reports\OverallLoanServiceInterface;
use App\Interfaces\Reports\FundHistoryServiceInterface;
use App\Interfaces\Reports\TopBorrowerServiceInterface;
use App\Interfaces\Settings\RolesAndPermissionsServiceInterface;
class ServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(DashboardServiceInterface::class,DashboardService::class);
        $this->app->bind(BorrowServiceInterface::class,BorrowService::class);
        $this->app->bind(DepositFundServiceInterface::class,DepositFundService::class);
        $this->app->bind(PaymentServiceInterface::class,PaymentService::class);
        $this->app->bind(ClientServiceInterface::class,ClientService::class);
        $this->app->bind(AdministratorServiceInterface::class,AdministratorService::class);
        $this->app->bind(CompanyIncomeServiceInterface::class,CompanyIncomeService::class);
        $this->app->bind(OverallLoanServiceInterface::class,OverallLoanService::class);
        $this->app->bind(FundHistoryServiceInterface::class,FundHistoryService::class);
        $this->app->bind(TopBorrowerServiceInterface::class,TopBorrowerService::class);
        $this->app->bind(RolesAndPermissionsServiceInterface::class,RolesAndPermissionsService::class);
    }
}
