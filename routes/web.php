<?php

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

// Subscribe
Route::get('/subscribe', function () {
    return view('subscribe.index', [
        'intent' => auth()->user()->createSetupIntent()
    ]);
})->name('subcribe')->middleware('nonPayingCustomer');

Route::post('/subscribe', function (Request $request) {
    $request->user()->newSubscription(
        'cashier', $request->plan
    )->create($request->paymentMethod);

    return back();
})->name('subscribe.store')->middleware('nonPayingCustomer');

Route::get('/members', function () {
    // $user = auth()->user();

    // $user->applyBalance(300, 'Bad usage penalty.');
    // $subscriptions = Subscription::query()->active()->get();
    // $subscriptions = $user->subscriptions()->canceled()->get();

    // Subscription::query()->active();


    // $transactions = $user->balanceTransactions();

    // $balance = $user->balance();

    return view('member.index');
})->name('member')->middleware('payingCustomer');

Route::get('/cancel-subcription', function () {
    $user = auth()->user();
    // $user->subscription('cashier')->cancelNow();
    $user->subscription('cashier')->cancelNowAndInvoice();

    return back();
})->name('cancel-subcription')->middleware('payingCustomer');
