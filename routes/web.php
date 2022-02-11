<?php

use App\Http\Controllers\SubcriptionController;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Subscribe part 1
Route::controller(SubcriptionController::class)->group(function (){
    Route::get('subscribe', 'showPlan')->name('subcribe')->middleware('nonPayingCustomer');;
    Route::post('subscribe', 'purchasePlan')->name('subscribe.store')->middleware('nonPayingCustomer');
    Route::get('members', 'members')->name('member')->middleware('payingCustomer');
    Route::get('cancel-subcription', 'cancelPlan')->name('cancel-subcription')->middleware('payingCustomer');
});

// Subscribe part 2
Route::controller(SubcriptionController::class)->group(function (){
    Route::get('plans/list', 'planlist')->name('plan.list');
    // Route::get('plans/list', 'planlist')->name('payments');
    // Route::post('subscribe', 'purchasePlan')->name('subscribe.store')->middleware('nonPayingCustomer');
    // Route::get('members', 'members')->name('member')->middleware('payingCustomer');
    // Route::get('cancelPlan', 'cancel-subcription')->name('cancel-subcription')->middleware('payingCustomer');
});
