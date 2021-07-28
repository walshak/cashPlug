<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $plans = Plan::paginate(env('PER_PAGE'));
        return view('dashboards.super-users.view-plans')->with([
            'plans' => $plans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboards.super-users.create-plan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->validate([
            'name' => 'string|required|min:3',
            'price' => 'numeric|required',
            'validity' => 'numeric|required',
            'refs' => 'numeric|required'
        ]);
        if(Plan::create($input)){
            return back()->with('msg','Plan created');
        }else{
            return back()->with('err','Request failed');
        }
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
        $plan = Plan::find($id);
        return view('dashboards.super-users.show-plan');
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
        $plan = Plan::find($id);
        return view('dashboards.super-users.edit-plan')->with([
            'plan' => $plan
        ]);
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
        $input = $request->validate([
            'name' => 'string|required|min:3',
            'price' => 'numeric|required',
            'validity' => 'numeric|required',
            'refs' => 'numeric|required'
        ]);
        $plan = Plan::find($id);
        if($plan->update($input)){
            return back()->with('msg','Plan updated');
        }else{
            return back()->with('err','Request failed');
        }

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
