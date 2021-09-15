<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\LinesOfCode\Counter;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboards.super-users.all-coupons');
    }

    public function coupons(Request $request){
        if($request->ajax()){
            $data = Coupon::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('vendor', function ($row) {
                    //dd($row);
                    return $row->vendor->name;
                })
                ->addColumn('user',function($row){
                    return $row->used_by->name;
                })
                ->rawColumns(['vendor','user'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plans = Plan::all();
        $admins = User::where('role','<',2)->get();
        return view('dashboards.super-users.create-coupon')->with(['plans'=>$plans,'vendors'=>$admins]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'plan' => 'required',
            'vendor' => 'required',
            'qty' => 'required'
        ]);

        for($i=0;$i<intval($inputs['qty']);$i++){
            $coupon = new Coupon;
            $coupon->create([
                'coupon' => "CP".rand(10000000,90000000),
                'vendor' => $inputs['vendor'],
                'created_by' => Auth::id(),
                'plan_id' => $inputs['plan']
            ]);
        }

        return back()->with('msg',$inputs['qty']." ". Plan::find($inputs['plan'])->name." Coupons generated for ".User::find($inputs['vendor'])->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
