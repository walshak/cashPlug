@extends('layouts.app')
@section('title', 'User dashboard')
@section('content')
    @include('layouts.errors')
    <div class="container">
        @if ($plan_active == false)
            <div class="alert alert-warning" role="alert">
                You currently have no active plan <a class="btn btn-primary" href="{{ route('users.settings') }}">Select
                    Plan</a>
            </div>
        @endif
        <div class="row">
            <div class="col-md-3 m-1">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4>No of downlines</h4>
                                </div>
                                <div class="col-4">
                                    {{$downlines}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 m-1">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4>Total Earnings</h4>
                                </div>
                                <div class="col-4">
                                    {{$gross_bal}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 m-1">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4>Withdrawn Earnings</h4>
                                </div>
                                <div class="col-4">
                                    {{$gross_bal-$balance}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 m-1">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4>Available Balance</h4>
                                </div>
                                <div class="col-4">
                                    {{$balance}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="row ">
            <div class="card primary">
                <div class="card-body">
                    <h4>Member since</h4>
                    <span>{{date('d M Y',strtotime($user->created_at))}}</span><br><br>
                    <div class="form-group">
                        <label for="">Your referral link</label>
                        <input type="text" value="{{route('register',['ref_id'=>Auth::user()->ref_id])}}" class="form-control form-control-lg disabled">
                    </div>
                    <a href="{{route('users.settings')}}" class="btn btn-primary">See detailed info</a>
                </div>
            </div>
        </div>
    </div>
@endsection
