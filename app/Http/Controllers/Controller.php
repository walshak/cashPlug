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
use App\Models\Coupon;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getBalance($id = null)
    {
        if (is_null($id)) {
            $id = Auth::id();
        } else {
            $id = $id;
        }

        if (Auth::user()->email == env('DEVELOPER_MAIL')) {
            $balance = Transaction::where('userId', $id)
                ->where(function ($query) {
                    $query->where('type', 'CAPITAL')
                        ->orWhere('type', 'REFERRAL')
                        ->orWhere('type', 'REFERRAL-AUTO')
                        ->orWhere('type', 'WITHDRAWAL');
                })
                ->pluck('amount')
                ->sum();
            $developer_share = Transaction::where('type', 'VAT')
                ->pluck('amount')
                ->sum();
            return $balance + $developer_share;
        } else {
            $balance = Transaction::where('userId', $id)
                ->where(function ($query) {
                    $query->where('type', 'CAPITAL')
                        ->orWhere('type', 'REFERRAL')
                        ->orWhere('type', 'REFERRAL-AUTO')
                        ->orWhere('type', 'WITHDRAWAL');
                })
                ->pluck('amount')
                ->sum();
            return $balance;
        }
    }

    public function getGrossBalance($id = null)
    {
        if (is_null($id)) {
            $id = Auth::id();
        } else {
            $id = $id;
        }

        if (Auth::user()->email == env('DEVELOPER_MAIL')) {
            $balance = Transaction::where('userId', $id)
                ->where(function ($query) {
                    $query->where('type', 'CAPITAL')
                        ->orWhere('type', 'REFERRAL')
                        ->orWhere('type', 'REFERRAL-AUTO');
                })
                ->pluck('amount')
                ->sum();
            $developer_share = Transaction::where('type', 'VAT')
                ->pluck('amount')
                ->sum();
            return $balance + $developer_share;
        } else {
            $balance = Transaction::where('userId', $id)
                ->where(function ($query) {
                    $query->where('type', 'CAPITAL')
                        ->orWhere('type', 'REFERRAL')
                        ->orWhere('type', 'REFERRAL-AUTO');
                })
                ->pluck('amount')
                ->sum();
            return $balance;
        }
    }

    public function getBalanceForCurCycle($id = null)
    {
        if (is_null($id)) {
            $id = Auth::id();
        } else {
            $id = $id;
        }

        $cur_plan_activated_on = User::find($id)->plan_activated_on;

        if (Auth::user()->email == env('DEVELOPER_MAIL')) {
            $balance_cur_cycle = Transaction::where('userId', $id)
                ->where('created_at', '>', $cur_plan_activated_on)
                ->where(function ($query) {
                    $query->where('type', 'CAPITAL')
                        ->orWhere('type', 'REFERRAL')
                        ->orWhere('type', 'REFERRAL-AUTO')
                        ->orWhere('type', 'WITHDRAWAL');
                })
                ->pluck('amount')
                ->sum();
            $developer_share = Transaction::where('type', 'VAT')
                ->pluck('amount')
                ->sum();
            return $balance_cur_cycle + $developer_share;
        } else {
            $balance_cur_cycle = Transaction::where('userId', $id)
                ->where('created_at', '>', $cur_plan_activated_on)
                ->where(function ($query) {
                    $query->where('type', 'CAPITAL')
                        ->orWhere('type', 'REFERRAL')
                        ->orWhere('type', 'REFERRAL-AUTO')
                        ->orWhere('type', 'WITHDRAWAL');
                })
                ->pluck('amount')
                ->sum();
            return $balance_cur_cycle;
        }
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

    public function getRefs($id = null)
    {
        if (is_null($id)) {
            $id = Auth::id();
        } else {
            $id = $id;
        }
        $hisRefId = User::find($id)->ref_id;
        //dd($hisRefId);

        $refs = User::where('refferd_by', $hisRefId)
            ->where('cycle', '!=', 0)
            ->get();
        return $refs;
    }

    public function getRefForCurCycle($id = null)
    {
        if (is_null($id)) {
            $id = Auth::id();
        } else {
            $id = $id;
        }
        $user = User::find($id); //get the user whose referrals we wish to obtain

        //query the database for all the people he referred(who are currently on their first cycle)
        //since when he activated his most recent plan
        $refs_for_cur_cycle = User::where('refferd_by', $user->ref_id)
            ->where('plan_activated_on', '>', $user->plan_activated_on)
            ->where('cycle', '=', 1)
            ->get();
        return $refs_for_cur_cycle;
        //dd($refs_for_cur_cycle);
    }

    public function subscribe(Request $request)
    {
        $input = $request->validate([
            'plan' => 'required|exists:plans,id',
            'coupon' => 'required'
        ]);
        $coupon = Coupon::where('coupon', $input['coupon'])->get();

        if ($coupon->isEmpty()) {
            return back()->with('err', 'Invalid coupon code');
        } else {
            // dd($coupon);
            if ($coupon[0]->plan_id != $input['plan']) {
                return back()->with('err', 'This coupon is not valid for this plan, please select the right plan');
            } else {
                $plan_id = $input['plan'];
                if (!$this->hasActivePlan()) {
                    $user = User::find(Auth::id());
                    $plan = Plan::find($plan_id);
                    $cur_date = date('Y-m-d H:i:s');
                    $ref_by = User::where('ref_id', $user->refferd_by)->get();
                    // dd($ref_by);

                    //if he has subscribed before(cycle != 0),
                    //it means this subscribtion is a renewal
                    if ($user->cycle != 0) {
                        //do subscribtion renewal
                        $user->update([
                            'cur_plan' => $plan->id,
                            'plan_activated' => true,
                            'plan_activated_on' => $cur_date,
                            'cycle' => $user->cycle + 1
                        ]);

                        //credit the person making the subscription renewal
                        $credit_user = new Transaction;
                        $credit_user->userId = Auth::id();
                        $credit_user->amount = $plan->price * env('USER_PERCENTAGE');
                        $credit_user->type = 'CAPITAL';
                        $credit_user->save();

                        //credit admin
                        $credit_admin = new Transaction;
                        $credit_admin->userId = Auth::id();
                        $credit_admin->amount = $plan->price * env('ADMIN_PERCENTAGE');
                        $credit_admin->type = 'ADMIN';
                        $credit_admin->save();

                        //credit VAT

                        $credit_vat = new Transaction;
                        $credit_vat->userId = Auth::id();
                        $credit_vat->amount = $plan->price * env('VAT_PERCENTAGE');
                        $credit_vat->type = 'VAT';
                        $credit_vat->save();
                    } else {
                        //do new subscription for user who has never subscribed before
                        //call the getNextRefBeneficiary() method and set the reffered_by attribute of the user
                        //to the value returned form the getNextRefBeneficiary() method
                        $nextBeneciciaryOfAutoReferral = $this->getNextRefBeneficiary($plan->id) ?? env('SUPER_ADMIN_USERNAME');
                        if ($user->refferd_by == null) {
                            //dd($nextBeneciciaryOfAutoReferral->ref_id);
                            $user = $user->update([
                                'cur_plan' => $plan->id,
                                'plan_activated' => true,
                                'plan_activated_on' => $cur_date,
                                'cycle' => $user->cycle + 1,
                                'refferd_by' => $nextBeneciciaryOfAutoReferral->ref_id ?? env('SUPER_ADMIN_USERNAME')
                            ]);

                            //credit the person who refferd him
                            $credit = new Transaction;
                            $credit->userId = $nextBeneciciaryOfAutoReferral->id ?? env('SUPER_ADMIN_ID');;
                            $credit->amount = $plan->price * env('REF_PERCENTAGE');
                            $credit->type = 'REFERRAL-AUTO';
                            $credit->save();

                            //credit admin
                            $credit_admin = new Transaction;
                            $credit_admin->userId = Auth::id();
                            $credit_admin->amount = $plan->price * env('ADMIN_PERCENTAGE');
                            $credit_admin->type = 'ADMIN';
                            $credit_admin->save();

                            //credit VAT
                            $credit_vat = new Transaction;
                            $credit_vat->userId = Auth::id();
                            $credit_vat->amount = $plan->price * env('VAT_PERCENTAGE');
                            $credit_vat->type = 'VAT';
                            $credit_vat->save();
                        } else {
                            $user = $user->update([
                                'cur_plan' => $plan->id,
                                'plan_activated' => true,
                                'plan_activated_on' => $cur_date,
                                'cycle' => $user->cycle + 1,
                            ]);
                            //credit the person who refferd him
                            $credit = new Transaction;
                            $credit->userId = $ref_by[0]->id ?? env('SUPER_ADMIN_ID');
                            $credit->amount = $plan->price * env('REF_PERCENTAGE');
                            $credit->type = 'REFERRAL';
                            $credit->save();

                            //credit admin
                            $credit_admin = new Transaction;
                            $credit_admin->userId = Auth::id() ?? env('SUPER_ADMIN_ID');
                            $credit_admin->amount = $plan->price * env('ADMIN_PERCENTAGE');
                            $credit_admin->type = 'ADMIN';
                            $credit_admin->save();

                            //credit VAT
                            $credit_vat = new Transaction;
                            $credit_vat->userId = Auth::id() ?? env('SUPER_ADMIN_ID');
                            $credit_vat->amount = $plan->price * env('VAT_PERCENTAGE');
                            $credit_vat->type = 'VAT';
                            $credit_vat->save();
                        }
                    }
                    $coupon = Coupon::where('coupon', $input['coupon']);
                    $coupon->update(['used' => true, 'used_on' => now('+01:00'), 'user_id' => Auth::id()]);
                    return back()->with('msg', "Subscription added, Congratulations");
                } else {
                    return back()->with('err', 'You already have an active plan');
                }
            }
        }
        //redundent flutterwave code
        // $plan_id = Plan::find()->id;
        // $payment_refrence = intval($_GET['reference']);
        // //verify payment status
        // $response = Http::withToken(env('SK_KEY'))->get('https://api.flutterwave.com/v3/transactions/' . $payment_refrence . '/verify');
        // //dd($response);
        // if ($response->status() == 200) {
        //     if (!$this->hasActivePlan()) {
        //         $user = User::find(Auth::id());
        //         $plan = Plan::find($plan_id);
        //         $cur_date = date('Y-m-d H:i:s');
        //         $ref_by = User::where('ref_id', $user->refferd_by)->get();
        //         // dd($ref_by);

        //         //if he has subscribed before(cycle != 0),
        //         //it means this subscribtion is a renewal
        //         if ($user->cycle != 0) {
        //             //do subscribtion renewal
        //             $user->update([
        //                 'cur_plan' => $plan->id,
        //                 'plan_activated' => true,
        //                 'plan_activated_on' => $cur_date,
        //                 'cycle' => $user->cycle + 1
        //             ]);

        //             //credit the person making the subscription renewal
        //             $credit_user = new Transaction;
        //             $credit_user->userId = Auth::id();
        //             $credit_user->amount = $plan->price * env('USER_PERCENTAGE');
        //             $credit_user->type = 'CAPITAL';
        //             $credit_user->save();

        //             //credit admin
        //             $credit_admin = new Transaction;
        //             $credit_admin->userId = Auth::id();
        //             $credit_admin->amount = $plan->price * env('ADMIN_PERCENTAGE');
        //             $credit_admin->type = 'ADMIN';
        //             $credit_admin->save();

        //             //credit VAT

        //             $credit_vat = new Transaction;
        //             $credit_vat->userId = Auth::id();
        //             $credit_vat->amount = $plan->price * env('VAT_PERCENTAGE');
        //             $credit_vat->type = 'VAT';
        //             $credit_vat->save();
        //         } else {
        //             //do new subscription for user who has never subscribed before
        //             //call the getNextRefBeneficiary() method and set the reffered_by attribute of the user
        //             //to the value returned form the getNextRefBeneficiary() method
        //             $nextBeneciciaryOfAutoReferral = $this->getNextRefBeneficiary($plan->id) ?? env('SUPER_ADMIN_USERNAME');
        //             if ($user->refferd_by == null) {
        //                 //dd($nextBeneciciaryOfAutoReferral->ref_id);
        //                 $user = $user->update([
        //                     'cur_plan' => $plan->id,
        //                     'plan_activated' => true,
        //                     'plan_activated_on' => $cur_date,
        //                     'cycle' => $user->cycle + 1,
        //                     'refferd_by' => $nextBeneciciaryOfAutoReferral->ref_id ?? env('SUPER_ADMIN_USERNAME')
        //                 ]);

        //                 //credit the person who refferd him
        //                 $credit = new Transaction;
        //                 $credit->userId = $nextBeneciciaryOfAutoReferral->id ?? env('SUPER_ADMIN_ID');;
        //                 $credit->amount = $plan->price * env('REF_PERCENTAGE');
        //                 $credit->type = 'REFERRAL-AUTO';
        //                 $credit->save();

        //                 //credit admin
        //                 $credit_admin = new Transaction;
        //                 $credit_admin->userId = Auth::id();
        //                 $credit_admin->amount = $plan->price * env('ADMIN_PERCENTAGE');
        //                 $credit_admin->type = 'ADMIN';
        //                 $credit_admin->save();

        //                 //credit VAT
        //                 $credit_vat = new Transaction;
        //                 $credit_vat->userId = Auth::id();
        //                 $credit_vat->amount = $plan->price * env('VAT_PERCENTAGE');
        //                 $credit_vat->type = 'VAT';
        //                 $credit_vat->save();
        //             } else {
        //                 $user = $user->update([
        //                     'cur_plan' => $plan->id,
        //                     'plan_activated' => true,
        //                     'plan_activated_on' => $cur_date,
        //                     'cycle' => $user->cycle + 1,
        //                 ]);
        //                 //credit the person who refferd him
        //                 $credit = new Transaction;
        //                 $credit->userId = $ref_by[0]->id ?? env('SUPER_ADMIN_ID');
        //                 $credit->amount = $plan->price * env('REF_PERCENTAGE');
        //                 $credit->type = 'REFERRAL';
        //                 $credit->save();

        //                 //credit admin
        //                 $credit_admin = new Transaction;
        //                 $credit_admin->userId = Auth::id() ?? env('SUPER_ADMIN_ID');
        //                 $credit_admin->amount = $plan->price * env('ADMIN_PERCENTAGE');
        //                 $credit_admin->type = 'ADMIN';
        //                 $credit_admin->save();

        //                 //credit VAT
        //                 $credit_vat = new Transaction;
        //                 $credit_vat->userId = Auth::id() ?? env('SUPER_ADMIN_ID');
        //                 $credit_vat->amount = $plan->price * env('VAT_PERCENTAGE');
        //                 $credit_vat->type = 'VAT';
        //                 $credit_vat->save();
        //             }
        //         }
        //         return back()->with('msg', "Subscription added, Congratulations");
        //     } else {
        //         return back()->with('err', 'You already have an active plan');
        //     }
        // } else {
        //     return back()->with('err', "Failed to verify status of payment, please contact admin with the refrence code: " . $payment_refrence);
        // }
    }

    public function getNextRefBeneficiary($plan_id)
    {
        //get all users with active plans and the plan is same as the plan that the user is about to,
        //subscribe to
        $all_user = User::where('plan_activated', true)
            ->where('cur_plan', $plan_id)
            ->where('active', true)
            ->get();

        //initailize some variables
        $users_in_need_of_downlines = [];
        $plan_activation_dates = [];

        //loop through users and find those that have less than env(AUTO_DOWNLINES) downlines,
        //and add them to the $users_in_need_of_downlines array
        foreach ($all_user as $user) {

            if (count($this->getRefForCurCycle($user->id)) < env('AUTO_DOWNLINES')) {
                array_push($users_in_need_of_downlines, $user);
            }
        }

        //loop through the $users_in_need_of_downlines arrray,
        //and find the person who activated his plan first among them
        foreach ($users_in_need_of_downlines as $user) {

            //add the plan_actvated_on dates of each of the $users_in_need_of_downlines
            //to the $plan_activation_dates array,
            //so that it can be sorted, and we can find the person who registered first among them
            array_push($plan_activation_dates, $user->plan_activated_on);
            sort($plan_activation_dates);

            //find the first element of the sorted $plan_activation_dates array,
            //and find the user who has that plan_activated_on date, and return that user
            if (in_array($plan_activation_dates[0], (array)$user)) {
                return $user;
            }
        }
    }

    public function hasActivePlan()
    {
        $chkPlan = User::find(Auth::id());
        $cur_date = date('U');
        $planActivated = $chkPlan->plan_activated;
        $planActivatedOn = $chkPlan->plan_activated_on;
        if ($planActivated == true) {
            $planValidity = $chkPlan->plan->validity;
            $referalsPerCycle = $chkPlan->plan->refs;
            if (($cur_date - strtotime($planActivatedOn)) / 86400 <= $planValidity) {
                $referals = User::where([
                    'refferd_by' => $chkPlan->ref_id,
                    'plan_activated' => true
                ])->get();
                $referals = count($referals);
                $cycle = $chkPlan->cycle;
                if ($referals < ($referalsPerCycle * $cycle) && !$this->hasRequestedWithdrawal) {
                    return true;
                } elseif ($referals == ($referalsPerCycle * $cycle) && $this->hasRequestedWithdrawal) {
                    $chkPlan->update([
                        'plan_activated' => false
                    ]);
                    return false;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function suspend_user_page($user_id = null)
    {
        if (is_null($user_id)) {
            //show the page, the data would be fetched via ajax in the suspend_user function
            return view('dashboards.admins.suspend-user');
        } else {
            $user = User::find($user_id);

            if ($user->active == true) {
                //suspend the user
                if ($user->update(['active' => false])) {
                    return back()->with('msg', 'User ' . $user->name . ' suspended');
                } else {
                    return back()->with('err', 'Request failed');
                }
            } else {
                //unsuspend the user
                if ($user->update(['active' => true])) {
                    return back()->with('msg', 'User ' . $user->name . ' unsuspended');
                } else {
                    return back()->with('err', 'Request failed');
                }
            }
        }
    }

    public function suspend_user(Request $request, $user_id = null)
    {
        if ($request->ajax()) {
            $data = User::where('role', '>', 1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    //dd($row);
                    $link = route('admin.suspend-user-page', $row->id);

                    if ($row->active == 1) {
                        $confirm_msg = 'Are you sure you want to suspend user:' . $row->name;
                        $actionBtn = '<a href="' . $link . '"class="btn btn-danger"
                            onclick="return confirm(\'' . $confirm_msg . '\')">Suspend</a>';
                    } else {
                        $confirm_msg = 'Are you sure you want to restore user:' . $row->name;
                        $actionBtn = '<a href="' . $link . '"class="btn btn-primary"
                        onclick="return confirm(\'' . $confirm_msg . '\')">Unsuspend</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function approve_payment_page($request_id = null)
    {

        if (is_null($request_id)) {
            return view('dashboards.admins.approve-payment');
        } else {
            $request = WithdrawalRequest::find($request_id);
            $user = $request->user;
            $bank_code = $user->account->bank_code;
            $account = $user->account->account_number;
            // dd($bank_code);
            // $response = Http::withToken(env('SK_KEY'))->post('https://api.flutterwave.com/v3/transfers', [
            //     'account_bank' => $bank_code,
            //     'account_number' => $account,
            //     'amount' => $request->amount,
            //     'currency' => 'NGN',
            //     'beneficiary_name' => $user->name

            // ]);
            //process payment
            if ($request->update([
                'approved' => true,
                'approved_by' => Auth::id(),
                'approved_on' => now('+01:00')

            ])) {
                return back()->with('msg', 'Withrawal request of user: ' . $user->name . ' approved');
            }
        }
    }
    public function approve_payment(Request $request, $request_id = null)
    {
        //get withdrawal requests
        if ($request->ajax()) {
            $data = WithdrawalRequest::where(['approved' => 0])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    //dd($row);
                    $link = route('admin.approve-payment-page', $row->id);
                    $confirm_msg = 'Are you sure you want to approve this request';
                    $actionBtn = '<a href="' . $link . '"class="btn btn-primary"
                    onclick="return confirm(\'' . $confirm_msg . '\')">Approve</a>';
                    return $actionBtn;
                })
                // ->addColumn('name', function ($row) {
                //     return $row->user->name;
                // })
                ->addColumn('account_details', function ($row) {
                    $user = User::find($row->userId);
                    $account_name = $user->account->account_name;
                    $account_number = $user->account->account_number;
                    $bank = $user->account->bank;

                    return $account_number . "<br>" . $account_name . "<br>" . $bank;
                })
                ->rawColumns(['action','account_details'])
                ->make(true);
        }
    }

    public function hasRequestedWithdrawal()
    {
        $user = Auth::user();
        $withdrawal_reqs = WithdrawalRequest::where('userId',$user->id)
                                            ->where('approved',false)
                                            ->count();
        if ($withdrawal_reqs > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function myCoupons()
    {
        return view('dashboards.admins.my-coupons');
    }

    public function myCouponsData(Request $request)
    {
        if ($request->ajax()) {
            $data = Coupon::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('plan', function ($row) {
                    //dd($row);
                    return $row->plan->name;
                })
                ->addColumn('status', function ($row) {
                    if ($row->used == false) {
                        return "<span class='bg-success'>Unused</span>";
                    } else {
                        return "<span class='bg-danger'>Used</span>";
                    }
                })
                ->rawColumns(['plan', 'status'])
                ->make(true);
        }
    }
}
