@extends('layouts.app')
@section('title', 'Super Admin dashboard-All Coupons')
@section('content')
    @include('layouts.errors')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        @include('layouts.coupons-sidebar')
                    </div>
                    <div class="col-sm-9">
                        <form action="{{route('super-admin.coupons.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Plan</label>
                                <select name="plan" id="" class="form-control">
                                    @foreach ($plans as $plan)
                                        <option value="{{$plan->id}}">{{$plan->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Vendor</label>
                                <select name="vendor" id="" class="form-control">
                                    @foreach ($vendors as $vendor)
                                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="number" name="qty" class="form-control" min="1" value="1">
                            </div>
                            <button type="submit" class="btn btn-primary">Create coupons</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
