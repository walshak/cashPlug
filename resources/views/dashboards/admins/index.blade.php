@extends('layouts.app')
@section('title','Admin dashboard')
@section('content')
@include('layouts.errors')
<div class="container">
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
                                33
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
                                33,000
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
                                21,000
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
                                12,000
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
                <h4>Last withdrawal</h4>
                <span>22 july, 2020</span>
            </div>
        </div>
    </div>
</div>
@endsection
