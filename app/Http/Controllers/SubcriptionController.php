<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;

class SubcriptionController extends Controller
{
    public function showPlan(){
        return view('subscribe.index', [
            'intent' => auth()->user()->createSetupIntent()
        ]);
    }

    public function purchasePlan(Request $request){
        $request->user()->newSubscription(
            'cashier', $request->plan
        )->create($request->paymentMethod);

        return back();
    }

    public function cancelPlan(){
        $user = auth()->user();
        // $user->subscription('cashier')->cancelNow();
        $user->subscription('cashier')->cancelNowAndInvoice();

        return back();
    }

    public function members(){
            // $user = auth()->user();

        // $user->applyBalance(300, 'Bad usage penalty.');
        // $subscriptions = Subscription::query()->active()->get();
        // $subscriptions = $user->subscriptions()->canceled()->get();

        // Subscription::query()->active();


        // $transactions = $user->balanceTransactions();

        // $balance = $user->balance();

        return view('member.index');
    }

    //======================Part 2=======================
    public function planlist(){
        $plans = Plan::all();
        return view('subscribe.part2.planlist',compact('plans'));
    }
}
