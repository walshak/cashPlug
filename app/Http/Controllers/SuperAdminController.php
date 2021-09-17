<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;

class SuperAdminController extends Controller
{
    public function index(){
        return view('dashboards.super-users.index')->with([
            'plan_active' => parent::hasActivePlan(),
            'balance' => parent::getBalance(),
            'downlines' => count(parent::getRefs()),
            'gross_bal' => parent::getGrossBalance(),
            'user' => User::find(Auth::id())
        ]);
    }

    public function profile(){
        return view('dashboards.super-users.profile')->with([
            'plan_active' => parent::hasActivePlan()
        ]);
    }

    public function settings(){
        if (parent::hasActivePlan()) {
            $cur_plan = User::find(Auth::id())->plan;
            $plan_expires = round((User::find(Auth::id())->plan->validity) - ((date('U') - strtotime(User::find(Auth::id())->plan_activated_on)) / 86400));
            return view('dashboards.super-users.settings')->with([
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
            return view('dashboards.super-users.settings')->with([
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
        dd($input);
        $user = User::find(Auth::id());
        if($user->update($input)){
            return back()->with('msg','Profile Updated');
        }else{
            return back()->with('error','Failed to update profile');
        }
    }

    public function make_super_admin_page($user_id=null){
        if(is_null($user_id)){
            // $users = User::where('role', '!=', 0 )
            //                 ->where('active',1)
            //                 ->paginate(env('PER_PAGE'));
            // return view('dashboards.super-users.make-super-admin')->with([
            //     'users' => $users
            // ]);
            return view('dashboards.super-users.make-super-admin');
        }else{
            $user = User::find($user_id);
            if($user->update(['role' => 0])){
                return back()->with('msg', 'User: '.$user->name.' is now a super admin');
            }else{
                return back()->with('err','Request failed');
            }
        }
    }

    public function make_super_admin(Request $request, $user_id=null){
        if ($request->ajax()) {
            $data = User::where('role', '!=', 0 )
                                ->where('active',1)
                                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    //dd($row);
                    $link = route('super-admin.make-super-admin-page',$row->id);
                    $confirm_msg = 'Are you sure you want to make this user a super admin?';
                    $actionBtn = '<a href="'.$link.'" class="btn btn-warning"
                    onclick="return confirm(\''.$confirm_msg.'\')">Promote</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function make_admin_page($user_id=null){
        if(is_null($user_id)){
            // $users = User::where('role', '=', 2 )
            //                 ->where('active',1)
            //                 ->paginate(env('PER_PAGE'));
            // return view('dashboards.super-users.make-admin')->with([
            //     'users' => $users
            // ]);
            return view('dashboards.super-users.make-admin');
        }else{
            $user = User::find($user_id);
            if($user->update(['role' => 1])){
                return back()->with('msg', 'User: '.$user->name.' is now an admin');
            }else{
                return back()->with('err','Request failed');
            }
        }
    }

    public function make_admin(Request $request, $user_id=null){
        if ($request->ajax()) {
            $data = User::where('role', '=', 2 )
                        ->where('active',1)
                        ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    //dd($row);
                    $link = route('super-admin.make-admin-page',$row->id);
                    $confirm_msg = 'Are you sure you want to make this user an admin?';
                    $actionBtn = '<a href="'.$link.'" class="btn btn-warning"
                    onclick="return confirm(\''.$confirm_msg.'\')">Promote</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function demote_admin($user_id=null){
        if(is_null($user_id)){
            $users = User::where('role', '=', 2 )
                            ->where('active',1)
                            ->paginate(env('PER_PAGE'));
            return view('dashboards.super-users.suspend-admin')->with([
                'users' => $users
            ]);
        }else{
            $user = User::find($user_id);
            if($user->update(['role' => 2])){
                return back()->with('msg', 'User: '.$user->name.' is now demoted to user');
            }else{
                return back()->with('err','Request failed');
            }
        }
    }

    public function suspend_admin_page($user_id=null){
        if(is_null($user_id)){
            // $admins = User::where([
            //     'role' => 1,
            // ])->paginate(env('PER_PAGE'));
            // return view('dashboards.super-users.suspend-admin')->with([
            //     'admins' => $admins
            // ]);
            return view('dashboards.super-users.suspend-admin');
        }else{
            $admin = User::find($user_id);
            if($admin->active == true){
                //suspend him
                if($admin->update(['active'=>false])){
                    return back()->with('msg','Admin: '.$admin->name.' has been suspended');
                }
            }else{
                //unsuspend him
                if($admin->update(['active'=>true])){
                    return back()->with('msg','Admin: '.$admin->name.' has been unsuspended');
                }
            }
        }
    }

    public function suspend_admin(Request $request, $user_id=null){
        if ($request->ajax()) {
            $data = User::where([
                     'role' => 1,
                    ])
                    ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if($row->active == 1){
                        $link = route('super-admin.suspend-admin-page',$row->id);
                        $link2 = route('super-admin.demote-admin',$row->id);
                        $msg = 'Are you sure you want to suspend this admin?';
                        $msg2 = 'Are you sure you want to demote this admin?';

                        $actionBtn = '<a href="'.$link.'" class="btn btn-danger"
                            onclick="return confirm(\''.$msg.'\')"
                            >Suspend</a> <a href="'.$link2.'"
                            class="btn btn-warning"
                            onclick="return confirm(\''.$msg2.'\')"
                            >Demote</a>';
                    }else{
                        $link = route('super-admin.suspend-admin-page',$row->id);
                        $msg = 'Are you sure you want to unsuspend this admin?';
                        $actionBtn = '<a href="'.$link.'"
                        class="btn btn-primary"
                        onclick="return confirm(\''.$msg.'\')"
                        >Unsuspend</a>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function financials_page(){
        return view('dashboards.super-users.financials');
    }

    public function financials(Request $request){
        if ($request->ajax()) {
            $data = Transaction::all();
            return Datatables::of($data)
            ->addColumn('name',function($row){
                return $row->user->name;
            })
            ->make(true);
        }
    }

    public function financials_withdrawals_page(){
        return view('dashboards.super-users.withdrawals');
    }

    public function withdrawals(Request $request){
        if ($request->ajax()) {
            $data = WithdrawalRequest::where('approved',1)->get();
            return Datatables::of($data)
            ->addColumn('requested_by',function($row){
                return $row->user->name;
            })
            ->addColumn('approved_by',function($row){
                return $row->approvedBy->name;
            })
            ->make(true);
        }
    }

}
