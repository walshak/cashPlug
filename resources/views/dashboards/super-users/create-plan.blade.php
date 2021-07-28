@extends('layouts.app')
@section('title', 'Super admin dashboard - create plan')
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
                        <form action="{{ route('plan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Plan Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Plan Validity(in days)</label>
                                <input type="number" name="validity" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Referrals per cycle</label>
                                <input type="number" name="refs" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Create plan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
