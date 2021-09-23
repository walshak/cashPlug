<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\WithdrawalRequest;
use App\Models\Plan;

class AdminController extends Controller
{
    public function index(){
        return view('dashboards.admins.index')->with([
            'plan_active' => parent::hasActivePlan(),
            'balance' => parent::getBalance(),
            'downlines' => count(parent::getRefs()),
            'gross_bal' => parent::getGrossBalance(),
            'pending_withdrawal' => parent::hasRequestedWithdrawal(),
            'user' => User::find(Auth::id())
        ]);
    }

    public function profile(){
        return view('dashboards.admins.profile')->with([
            'plan_active' => parent::hasActivePlan()
        ]);
    }

    public function settings()
    {
        if (parent::hasActivePlan()) {
            $cur_plan = User::find(Auth::id())->plan;
            $plan_expires = round((User::find(Auth::id())->plan->validity) - ((date('U') - strtotime(User::find(Auth::id())->plan_activated_on)) / 86400));
            return view('dashboards.admins.settings')->with([
                'plan_active' => parent::hasActivePlan(),
                'cur_plan' => $cur_plan,
                'plan_expires' => $plan_expires,
                'balance' => parent::getBalance(),
                'all_refs' => parent::getRefs(),
                'refs_for_cur_cycle' => parent::getRefForCurCycle(),
                'bal_for_cur_cycle' => parent::getBalanceForCurCycle(),
                'withrawal_requested' => parent::hasRequestedWithdrawal()
            ]);
        } else {
            $plans = Plan::paginate(env('PER_PAGE'));
            return view('dashboards.admins.settings')->with([
                'plan_active' => parent::hasActivePlan(),
                'plans' => $plans
            ]);
        }
    }

    public function update_profile(Request $request){
        $input = $request->validate([
            'name' => ['required'],
            'email' => ['required','email'],
            'phone' => ['required','regex:/^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$/'],
        ]);

        $user = User::find(Auth::id());
        if($user->update($input)){
            return back()->with('msg','Profile Updated');
        }else{
            return back()->with('error','Failed to update profile');
        }
    }

}
