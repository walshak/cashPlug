@extends('layouts.app')
@section('title', 'User dashboard')
@section('content')
    @include('layouts.errors')
    <div class="container">
        @if ($plan_active == false)
            <div class="alert alert-warning" role="alert">
                You currently have no active contribution plan <a class="btn btn-primary" href="{{ route('users.settings') }}">Select
                    Plan</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>How to purchase an activation code</h3>
                </div>
                <div class="card-body">
                    <p>
                        In order to activate a plan, you need to do the following:
                        <ul>
                            <li>Decide which plan you like and it's price (you can see the list of plans ( Bronze, Gold...etc) <a href="{{route('users.settings')}}">here</a>)</li>
                            <li>Make a bank transfer or deposit to the bank accounts listed below</li>
                            <li>send a whatsapp message with proof of payment to the manager of the bank account you made a transfer to stating your desired plan( Bronze, Gold...etc)</li>
                            <li>The manager will send you a coupon/activation code.</li>
                            <li>Go <a href="{{route('users.settings')}}">here</a> to select your desired plan, click subscribe</li>
                            <li>Enter the coupon/activation code you got from the manager in the field labeled 'coupon'</li>
                            <li>click activate an you plan will be activated instantly...</li>
                            <li>Happy contributing...</li>
                        </ul>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>s/N</th>
                                    <th>Bank Details</th>
                                    <th>Manager contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>GLOFTECH LTD <br> 1022056150 <br> UBA</td>
                                    <td>09012935118</td>
                                </tr>
                            </tbody>
                        </table>
                    </p>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-3 m-1">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4>No of contributors in your cycle</h4>
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
                                    <h4>Total Savings</h4>
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
                                    <h4>Withdrawn Savings</h4>
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
                    <label for="">Your Invitation link</label>
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
                    <a href="{{ route('users.settings') }}" class="btn btn-primary">See detailed info</a>
                </div>
            </div>
        </div>
    </div>
@endsection
