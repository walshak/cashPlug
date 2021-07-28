@extends('layouts.app')
@section('title', 'Super admin dashboard - profile')
@section('content')
    @include('layouts.errors')
    <div class="row">
        @if ($plan_active == false)
            <div class="alert alert-warning" role="alert">
                You currently have no active plan <a class="btn btn-primary" href="{{ route('users.settings') }}">Select
                    Plan</a>
            </div>
        @endif
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-12">

            <div class="white-box">

                <div class="user-bg"> <img width="100%" alt="user" src="plugins/images/large/img1.jpg">
                    <div class="overlay-box">
                        <div class="user-content">
                            <a href="javascript:void(0)"><img src="plugins/images/users/genu.jpg"
                                    class="thumb-lg img-circle" alt="img"></a>
                            <h4 class="text-white mt-2">{{ Auth::user()->name }}</h4>
                            <h5 class="text-white mt-2">{{ Auth::user()->email }}</h5>
                        </div>
                    </div>
                </div>
                {{-- <div class="user-btm-box mt-5 d-md-flex">
                <div class="col-md-4 col-sm-4 text-center">
                    <h1>258</h1>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <h1>125</h1>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <h1>556</h1>
                </div>
            </div> --}}
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal form-material" action="{{ route('users.update-profile') }}" method="POST">
                        @csrf
                        {{-- <input type="hidden" name="_method" value="PUT"> --}}
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Full Name</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" value="{{ Auth::user()->name }}" class="form-control p-0 border-0"
                                    name="name">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="example-email" class="col-md-12 p-0">Email</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="email" value="{{ Auth::user()->email }}" class="form-control p-0 border-0"
                                    name="email" id="example-email">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="submit">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection
