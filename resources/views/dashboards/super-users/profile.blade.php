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
                    <form class="form-horizontal form-material" action="{{ route('users.update-profile') }}"
                        method="POST">
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

                    <h3>Account details</h3>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">Account number</label>
                            <input type="text" class="form-control" name="account_number" id="acc_no">
                        </div>
                        <div class="form-group">
                            <label for="">Bank</label>
                            <select name="bank" id="banks"></select>
                        </div>
                        <button class="btn btn-primary disabled">Update Account info</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection
<script>
    $(document).ready(function() {
        // Using the core $.ajax() method
        $.ajax({

                // The URL for the request
                url: "post.php",

                // The data to send (will be converted to a query string)
                data: {
                    id: 123
                },

                // Whether this is a POST or GET request
                type: "GET",

                // The type of data we expect back
                dataType: "json",
            })
            // Code to run if the request succeeds (is done);
            // The response is passed to the function
            .done(function(json) {
                $("<h1>").text(json.title).appendTo("body");
                $("<div class=\"content\">").html(json.html).appendTo("body");
            })
            // Code to run if the request fails; the raw request and
            // status codes are passed to the function
            .fail(function(xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            })
            // Code to run regardless of success or failure;
            .always(function(xhr, status) {
                alert("The request is complete!");
            });
    });
</script>
