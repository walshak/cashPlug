<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DataTables;


use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawalRequest;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getBalance($id = null){
        if(is_null($id)){
            $id = Auth::id();
        }else{
            $id = $id;
        }

        $balance = Transaction::where('userId',$id)
                    ->where('type','CAPITAL')
                    ->orWhere('type','REFERRAL')
                    ->orWhere('type','WITHDRAWAL')
                    ->pluck('amount')
                    ->sum();
        return $balance;
    }

    public function getGrossBalance($id = null){
        if(is_null($id)){
            $id = Auth::id();
        }else{
            $id = $id;
        }

        $balance = Transaction::where('userId',$id)
                    ->where('type','CAPITAL')
                    ->orWhere('type','REFERRAL')
                    ->pluck('amount')
                    ->sum();
        return $balance;
    }

    public function getBalanceForCurCycle($id = null){
        if(is_null($id)){
            $id = Auth::id();
        }else{
            $id = $id;
        }
        $cur_plan_activated_on = User::find($id)->plan_activated_on;
        $balance_cur_cycle = Transaction::where('userId',$id)
                    ->where('created_at','>',$cur_plan_activated_on)
                    ->where('type','CAPITAL')
                    ->orWhere('type','REFERRAL')
                    ->pluck('amount')
                    ->sum();
        //dd($balance_cur_cycle);
        return $balance_cur_cycle;
    }

    public function request_withdrawal(Request $request)
    {
        $user = User::find(Auth::id());
        $balance = $this->getBalance();
        //dd($balance);
        $input = $request->validate([
            'amount' => "required"
        ]);

        if ($input['amount'] > $balance) {
            return back()->with('err', 'The requested amount cannot be grater than you available balance');
        } else {
            $withdraw = new WithdrawalRequest;
            $withdraw->amount = $input['amount'];
            $withdraw->userId = $user->id;
            if ($withdraw->save()) {
                return back()->with('msg', 'Withdrawal request submited successfuly');
            } else {
                return back()->with('err', 'Request fialed');
            }
        }
    }

    public function getRefs($id = null){
        if(is_null($id)){
            $id = Auth::id();
        }else{
            $id = $id;
        }
        $hisRefId = User::find($id)->ref_id;
        //dd($hisRefId);

        $refs = User::where('refferd_by',$hisRefId)
                    ->where('cycle','!=',0)
                    ->get();
        return $refs;
    }

    public function getRefForCurCycle($id = null){
        if(is_null($id)){
            $id = Auth::id();
        }else{
            $id = $id;
        }
        $user = User::find($id);//get the user whose referrals we wish to obtain

        //query the database for all the people he referred(who are currently on their first cycle)
        //since when he activated his most recent plan
        $refs_for_cur_cycle = User::where('refferd_by',$user->ref_id)
                                    ->where('plan_activated_on','>',$user->plan_activated_on)
                                    ->where('cycle','=',1)
                                    ->get();
        return $refs_for_cur_cycle;
        //dd($refs_for_cur_cycle);
    }

    public function subscribe($plan_id){
        if(!$this->hasActivePlan()){
            $user = User::find(Auth::id());
            $plan = Plan::find($plan_id);
            $cur_date = date('Y-m-d H:i:s');
            $ref_by = User::where('ref_id',$user->refferd_by)->get();
            //dd($ref_by);

            //if he has subscribed before(cycle != 0),
            //it means this subscribtion is a renewal
            if($user->cycle != 0){
                //do subscribtion renewal
                $user->update([
                    'cur_plan' => $plan->id,
                    'plan_activated' => true,
                    'plan_activated_on' => $cur_date,
                    'cycle' => $user->cycle + 1
                ]);
                //credit the person making the subscription renewal
                $credit_user = new Transaction;
                $credit_user->userId = $user->id;
                $credit_user->amount = $plan->price * env('USER_PERCENTAGE');
                $credit_user->type = 'CAPITAL';
                $credit_user->save();
                //credit admin
                $credit_admin = new Transaction;
                $credit_admin->userId = $ref_by[0]->id;
                $credit_admin->amount = $plan->price * env('ADMIN_PERCENTAGE');
                $credit_admin->type = 'ADMIN';
                $credit_admin->save();

                //credit VAT

                $credit_vat = new Transaction;
                $credit_vat->userId =$ref_by[0]->id;
                $credit_vat->amount = $plan->price * env('VAT_PERCENTAGE');
                $credit_vat->type = 'VAT';
                $credit_vat->save();
            }else{
                //do new subscribtion for user who has never subscribed before
                $user = $user->update([
                    'cur_plan' => $plan->id,
                    'plan_activated' => true,
                    'plan_activated_on' => $cur_date,
                    'cycle' => $user->cycle + 1
                ]);
                //credit the person who refferd him
                $credit = new Transaction;
                $credit->userId = $ref_by[0]->id;
                $credit->amount = $plan->price * env('REF_PERCENTAGE');
                $credit->type = 'REFERRAL';
                $credit->save();
                //credit admin
                $credit_admin = new Transaction;
                $credit_admin->userId = $ref_by[0]->id;
                $credit_admin->amount = $plan->price * env('ADMIN_PERCENTAGE');
                $credit_admin->type = 'ADMIN';
                $credit_admin->save();

                //credit VAT

                $credit_vat = new Transaction;
                $credit_vat->userId =$ref_by[0]->id;
                $credit_vat->amount = $plan->price * env('VAT_PERCENTAGE');
                $credit_vat->type = 'VAT';
                $credit_vat->save();
            }
            return back()->with('msg',"Subscription added, Congratulations");
        }else{
            return back()->with('err','You already have an active plan');
        }
    }

    public function hasActivePlan(){
        $chkPlan = User::find(Auth::id());
        $cur_date = date('U');
        $planActivated = $chkPlan->plan_activated;
        $planActivatedOn = $chkPlan->plan_activated_on;
        if($planActivated == true){
            $planValidity = $chkPlan->plan->validity;
            $referalsPerCycle = $chkPlan->plan->refs;
            if(($cur_date - strtotime($planActivatedOn))/86400 <= $planValidity){
                $referals = User::where([
                    'refferd_by'=> $chkPlan->ref_id,
                    'plan_activated' => true
                ])->get();
                $referals = count($referals);
                $cycle = $chkPlan->cycle;
                if($referals < ($referalsPerCycle*$cycle)){
                    return true;
                }elseif($referals == ($referalsPerCycle*$cycle)){
                    $chkPlan->update([
                        'plan_activated' => false
                    ]);
                    return false;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function suspend_user_page($user_id=null){
        if(is_null($user_id)){
            //show the page, the data would be fetched via ajax in the suspend_user function
            return view('dashboards.admins.suspend-user');
        }else{
            $user = User::find($user_id);

            if($user->active ==true){
                //suspend the user
                if($user->update(['active'=> false])){
                    return back()->with('msg','User '.$user->name.' suspended');
                }else{
                    return back()->with('err','Request failed');
                }
            }else{
                //unsuspend the user
                if($user->update(['active'=> true])){
                    return back()->with('msg','User '.$user->name.' unsuspended');
                }else{
                    return back()->with('err','Request failed');
                }
            }
        }
    }

    public function suspend_user(Request $request, $user_id=null){
        if ($request->ajax()) {
            $data = User::where('role', '>', 1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    //dd($row);
                    $link = route('admin.suspend-user-page',$row->id);

                    if($row->active == 1){
                        $confirm_msg = 'Are you sure you want to suspend user:'.$row->name;
                        $actionBtn = '<a href="'.$link.'"class="btn btn-danger"
                            onclick="return confirm(\''.$confirm_msg.'\')">Suspend</a>';
                    }else{
                        $confirm_msg = 'Are you sure you want to restore user:'.$row->name;
                        $actionBtn = '<a href="'.$link.'"class="btn btn-primary"
                        onclick="return confirm(\''.$confirm_msg.'\')">Unsuspend</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function approve_payment_page($request_id=null){

        if(is_null($request_id)){
            return view('dashboards.admins.approve-payment');
        }else{
            $request = WithdrawalRequest::find($request_id);
            $user = $request->user;
            //process payment
            return back()->with('msg','Withrawal request of user: '.$user->name.' approved');
        }

    }
    public function approve_payment(Request $request, $request_id=null){
        //get withdrawal requests
        if ($request->ajax()) {
            $data = WithdrawalRequest::where(['approved'=>0])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    //dd($row);
                    $link = route('admin.approve-payment-page',$row->id);
                    $confirm_msg = 'Are you sure you want to approve this request';
                    $actionBtn = '<a href="'.$link.'"class="btn btn-primary"
                    onclick="return confirm(\''.$confirm_msg.'\')">Approve</a>';
                    return $actionBtn;
                })
                ->addColumn('name', function($row){
                    return $row->user->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    public function hasRequestedWithdrawal(){
        $user = Auth::user();
        if(count($user->withdrawalRequest) > 0 ){
            return true;
        }else{
            return false;
        }
    }
}
