@extends('layouts.app')
@section('title', 'Super admin dashboard - edit plan')
@section('content')
    @include('layouts.errors')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        @include('layouts.plan-sidelinks')
                    </div>
                    <div class="col-sm-9">
                        <form action="{{ route('plan.update',$plan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="put">
                            <div class="form-group">
                                <label for="">Plan Name</label>
                                <input type="text" name="name" class="form-control" value="{{$plan->name}}">
                            </div>
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" class="form-control" value="{{$plan->price}}">
                            </div>
                            <div class="form-group">
                                <label for="">Plan Validity(in days)</label>
                                <input type="number" name="validity" class="form-control" value="{{$plan->validity}}">
                            </div>
                            <div class="form-group">
                                <label for="">Referrals per cycle</label>
                                <input type="number" name="refs" class="form-control" value="{{$plan->refs}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update plan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
