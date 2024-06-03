<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\ClientIsActive;
use App\Http\Middleware\AccessReport;
use App\Http\Middleware\AccessClient;
use App\Http\Middleware\CreateClient;
use App\Http\Middleware\UpdateClient;
use App\Http\Middleware\AccessAdministrator;
use App\Http\Middleware\CreateAdministrator;
use App\Http\Middleware\UpdateAdministrator;
use App\Http\Middleware\AccessStaff;
use App\Http\Middleware\CreateStaff;
use App\Http\Middleware\UpdateStaff;
use App\Http\Middleware\AccessRoleAndPermission;
use App\Http\Controllers\Pages\NotificationController;
use App\Http\Controllers\Pages\DashboardController;
use App\Http\Controllers\Pages\Transactions\BorrowController;
use App\Http\Controllers\Pages\Transactions\FundController;
use App\Http\Controllers\Pages\Transactions\DepositController;
use App\Http\Controllers\Pages\Transactions\Payments\PaymentSOAController;
use App\Http\Controllers\Pages\Transactions\Payments\PaymentController;
use App\Http\Controllers\Pages\Transactions\Payments\PaymentHistoryController;
use App\Http\Controllers\Pages\Transactions\Payments\PaymentInvoiceController;
use App\Http\Controllers\Pages\Transactions\Payments\DownloadAgreementController;
use App\Http\Controllers\Pages\UserManagement\ClientController;
use App\Http\Controllers\Pages\UserManagement\ClientProfileController;
use App\Http\Controllers\Pages\UserManagement\AdministratorController;
use App\Http\Controllers\Pages\UserManagement\StaffController;
use App\Http\Controllers\Pages\UserManagement\StaffProfileController;
use App\Http\Controllers\Pages\UserManagement\AdministratorProfileController;
use App\Http\Controllers\Pages\Reports\CompanyIncomeController;
use App\Http\Controllers\Pages\Reports\CompanyIncomeExportController;
use App\Http\Controllers\Pages\Reports\OverallLoanController;
use App\Http\Controllers\Pages\Reports\OverallLoanExportController;
use App\Http\Controllers\Pages\Reports\FundHistoryController;
use App\Http\Controllers\Pages\Reports\FundHistoryExportController;
use App\Http\Controllers\Pages\Reports\TopBorrowerController;
use App\Http\Controllers\Pages\Reports\TopBorrowerExportController;

use App\Http\Controllers\Pages\Settings\RolesAndPermissionsController;
use App\Http\Controllers\Pages\Settings\RoleController;
use App\Http\Controllers\Pages\Settings\PermissionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});
Auth::routes();
Route::middleware([AuthenticateUser::class,'auth'])->group(function() {

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::prefix('transactions')->group(function () {
        Route::get('/download-agreement/{id}/{reference}',[DownloadAgreementController::class,'download'])->name('agreement.download');
        Route::resource('/borrow', BorrowController::class);
        Route::prefix('fund')->group(function () {
            Route::match(['get', 'post'],'/', [FundController::class,'index'])->name('fund.index');
            Route::resource('/deposit', DepositController::class);
        });
        Route::prefix('soa')->group(function () {
            Route::match(['get', 'post'],'/{status}', [PaymentSOAController::class,'show'])->name('payment.list');
            Route::resource('{status}/payment', PaymentController::class);
            Route::get('/{status}/payment/history/{reference}', [PaymentHistoryController::class,'show'])->name('payment.history.show');
        });
        Route::get('/{reference}', [PaymentInvoiceController::class,'whole_transaction'])->name('invoice');
        Route::get('/send-mail/{reference}',[PaymentInvoiceController::class,'send_mail'])->name('send-mail.attachment')->middleware(ClientIsActive::class);
    });

    Route::prefix('user-management')->group(function () {
        Route::middleware(AccessClient::class)->group(function() {
            Route::prefix('client')->group(function () {
                Route::match(['get', 'post'],'/', [ClientController::class,'index'])->name('client.index');
                Route::resource('/profile', ClientController::class)->except(['index'])->names(['create'=>'client.profile.create','store'=>'client.profile.store'])->middleware(CreateClient::class);
                Route::match(['get', 'post'],'/profile/{tab}/{id}', [ClientProfileController::class,'show'])->name('client.profile');
                Route::post('/profile/{tab}/update/{id}', [ClientProfileController::class,'update'])->name('client.profile.update')->middleware(UpdateClient::class);
            });
        });
        Route::middleware(AccessAdministrator::class)->group(function() {
            Route::prefix('administrator')->group(function () {
                Route::match(['get', 'post'],'/', [AdministratorController::class,'index'])->name('administrator.index');
                Route::resource('/profile', AdministratorController::class)->except(['index'])->names(['create'=>'administrator.profile.create','store'=>'administrator.profile.store'])->middleware(CreateAdministrator::class);
                Route::match(['get', 'post'],'/profile/{tab}/{id}', [AdministratorProfileController::class,'show'])->name('administrator.profile');
                Route::post('/profile/{tab}/update/{id}', [AdministratorProfileController::class,'update'])->name('administrator.profile.update')->middleware(UpdateAdministrator::class);
            });
        });
        Route::middleware(AccessStaff::class)->group(function() {
            Route::prefix('staff')->group(function () {
                Route::match(['get', 'post'],'/', [StaffController::class,'index'])->name('staff.index');
                Route::resource('/profile', StaffController::class)->except(['index'])->names(['create'=>'staff.profile.create','store'=>'staff.profile.store'])->middleware(CreateStaff::class);
                Route::match(['get', 'post'],'/profile/{tab}/{id}', [StaffProfileController::class,'show'])->name('staff.profile');
                Route::post('/profile/{tab}/update/{id}', [StaffProfileController::class,'update'])->name('staff.profile.update')->middleware(UpdateStaff::class);
            });
        });
    });

    Route::middleware(AccessReport::class)->group(function() {
        Route::prefix('report')->group(function () {
            Route::match(['get', 'post'],'/company-income', [CompanyIncomeController::class,'index'])->name('company-income.index');
            Route::get('/company-income/export', [CompanyIncomeExportController::class, 'export'])->name('company-income.export');
            Route::match(['get', 'post'],'/overall-loan', [OverallLoanController::class,'index'])->name('overall-loan.index');
            Route::get('/overall-loan/export', [OverallLoanExportController::class, 'export'])->name('overall-loan.export');
            Route::match(['get', 'post'],'/fund-history', [FundHistoryController::class,'index'])->name('fund-history.index');
            Route::get('/fund-history/export', [FundHistoryExportController::class, 'export'])->name('fund-history.export');
            Route::match(['get', 'post'],'/top-borrower', [TopBorrowerController::class,'index'])->name('top-borrower.index');
            Route::get('/top-borrower/export', [TopBorrowerExportController::class, 'export'])->name('top-borrower.export');
        });
    });


    Route::prefix('settings')->group(function () {
        Route::middleware(AccessRoleAndPermission::class)->group(function() {
            Route::resource('/roles-and-permissions', RolesAndPermissionsController::class);
            Route::resource('/permission', PermissionController::class);
            Route::resource('/role', RoleController::class);
        });
    });

    Route::get('/borrow-notification',[NotificationController::class,'borrow_notification']);
    Route::get('/fund-notification',[NotificationController::class,'fund_notification']);
    Route::get('/notification-count',[NotificationController::class,'notification_count']);
    Route::get('/seen-notification/{id}',[NotificationController::class,'seen_notification']);
});
