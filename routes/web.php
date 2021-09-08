<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Middleware\isActive;
use GuzzleHttp\Middleware;
use phpDocumentor\Reflection\Types\Resource_;
use App\Models\Plan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('template')->with([
        'plans' => Plan::all()
    ]);
})->name('landing-page');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('msg', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('get_banks',[AccountController::class,'get_banks'])->name('get.banks');
Route::get('verify_account',[AccountController::class,'verify_account'])->name('account.verify');
Route::post('add_bank_details',[AccountController::class,'create'])->name('account.add');

Auth::routes();

Route::get('suspended-user',function(){
    return view('suspended-user');
})->name('suspended-user');

Route::get('subscribe',[Controller::class,'subscribe'])->middleware('auth')->name('super-admin.subscribe');

Route::post('/users/update-profile', [UserController::class, 'update_profile'])->middleware(['auth'])->name('users.update-profile');
Route::post('/admins/update-profile', [AdminController::class, 'update_profile'])->middleware(['auth'])->name('admins.update-profile');
Route::post('/super-admins/update-profile', [SuperAdminController::class, 'update_profile'])->middleware(['auth'])->name('super-admins.update-profile');

Route::group(['prefix'=>'admin','middleware'=>['auth','isActive','verified']],function(){
    Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('profile',[AdminController::class,'profile'])->name('admin.profile');
    Route::get('settings',[AdminController::class,'settings'])->name('admin.settings');
    //Route::get('subscribe',[Controller::class,'subscribe'])->name('admin.subscribe');
    Route::post('request-withdrawal',[Controller::class,'request_withdrawal'])->name('admin.request-withdrawal');
    Route::get('suspend-user-page/{user_id?}',[Controller::class,'suspend_user_page'])->name('admin.suspend-user-page');
    Route::get('suspend-user/list/{user_id?}',[Controller::class,'suspend_user'])->name('admin.suspend-user');
    Route::get('approve-payment-page/{request_id?}',[Controller::class,'approve_payment_page'])->name('admin.approve-payment-page');//load the basic approve payment page
    Route::get('approve-payment/list/{request_id?}',[Controller::class,'approve_payment'])->name('admin.approve-payment');//get the data for the approve payment page
});

Route::group(['prefix'=>'users','middleware'=>['auth','isUser','isActive','verified']],function(){
    Route::get('dashboard',[UserController::class,'index'])->name('users.dashboard');
    Route::get('profile',[UserController::class,'profile'])->name('users.profile');
    Route::get('settings',[UserController::class,'settings'])->name('users.settings');
    //Route::get('subscribe',[Controller::class,'subscribe'])->name('users.subscribe');
    Route::post('request-withdrawal',[Controller::class,'request_withdrawal'])->name('users.request-withdrawal');
});

Route::group(['prefix'=>'super-admin','middleware'=>['auth','isSuperAdmin','isActive','verified']],function(){
    Route::get('dashboard',[SuperAdminController::class,'index'])->name('super-admin.dashboard');
    Route::get('profile',[SuperAdminController::class,'profile'])->name('super-admin.profile');
    Route::get('settings',[SuperAdminController::class,'settings'])->name('super-admin.settings');

    Route::post('request-withdrawal',[Controller::class,'request_withdrawal'])->name('super-admin.request-withdrawal');
    // Route::get('suspend-user',[Controller::class,'suspend_user'])->name('super-admin.suspend-user');
    // Route::get('approve-payment',[Controller::class,'approve_payment'])->name('super-admin.approve-payment');
    Route::get('make-super-admin-page/{user_id?}',[SuperAdminController::class,'make_super_admin_page'])->name('super-admin.make-super-admin-page');
    Route::get('make-super-admin/list/{user_id?}',[SuperAdminController::class,'make_super_admin'])->name('super-admin.make-super-admin');
    Route::get('make-admin-page/{user_id?}',[SuperAdminController::class,'make_admin_page'])->name('super-admin.make-admin-page');
    Route::get('make-admin/list/{user_id?}',[SuperAdminController::class,'make_admin'])->name('super-admin.make-admin');
    Route::get('suspend-admin-page/{user_id?}',[SuperAdminController::class,'suspend_admin_page'])->name('super-admin.suspend-admin-page');
    Route::get('suspend-admin/list/{user_id?}',[SuperAdminController::class,'suspend_admin'])->name('super-admin.suspend-admin');
    Route::get('demote-admin/{user_id?}',[SuperAdminController::class,'demote_admin'])->name('super-admin.demote-admin');
    Route::get('financials-page',[SuperAdminController::class,'financials_page'])->name('super-admin.financials-page');
    Route::get('financials/list',[SuperAdminController::class,'financials'])->name('super-admin.financials');
    Route::get('financials-withdrawals-page',[SuperAdminController::class,'financials_withdrawals_page'])->name('super-admin.financials-withdrawals-page');
    Route::get('financials-withdrawals/list',[SuperAdminController::class,'withdrawals'])->name('super-admin.withdrawals');
    Route::resource('plan', PlanController::class);
});


