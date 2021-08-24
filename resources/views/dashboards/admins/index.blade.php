@extends('layouts.app')
@section('title', 'Admin dashboard')
@section('content')
    @include('layouts.errors')
    <div class="container">
        @if ($plan_active == false)
            <div class="alert alert-warning" role="alert">
                You currently have no active plan <a class="btn btn-primary" href="{{ route('admin.settings') }}">Select
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
                                    {{ $downlines }}
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
                                    {{ $gross_bal }}
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
                                    {{ $gross_bal - $balance }}
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
                                    {{ $balance }}
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
                    <span>{{ date('d M Y', strtotime($user->created_at)) }}</span><br><br>
                    <label for="">Your ref link</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-lg" id="ref_link"
                            value="{{ route('register', ['ref_id' => Auth::user()->ref_id]) }}" readonly>
                        <span class="input-group-text" id="basic-addon2"><span onclick="copyTextFunction()">Copy
                                Link</span></span>
                    </div>
                    <script>
                        function copyTextFunction() {
                            /* Get the text field */
                            var copyText = document.getElementById("ref_link");

                            /* Select the text field */
                            copyText.select();
                            copyText.setSelectionRange(0, 99999); /* For mobile devices */

                            /* Copy the text inside the text field */
                            navigator.clipboard.writeText(copyText.value);

                            /* Alert the copied text */
                            alert("Link Copied");
                        }
                    </script>
                    <a href="{{ route('admin.settings') }}" class="btn btn-primary">See detailed info</a>
                </div>
            </div>
        </div>
    </div>
@endsection
