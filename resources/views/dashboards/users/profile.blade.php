@extends('layouts.app')
@section('title', 'User dashboard - profile')
@section('content')
    @include('layouts.errors')
    <div class="row">
        @if ($plan_active == false)
            <div class="alert alert-warning" role="alert">
                You currently have no active contribution plan <a class="btn btn-primary" href="{{ route('users.settings') }}">Select
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
                                    name="name" readonly>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="example-email" class="col-md-12 p-0">Email</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="email" value="{{ Auth::user()->email }}" class="form-control p-0 border-0"
                                    name="email" id="example-email" readonly>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="example-phone" class="col-md-12 p-0">Phone</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" value="{{ Auth::user()->phone }}" class="form-control p-0 border-0"
                                    name="phone" id="example-phone" placeholder="+2348066455789" readonly>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="button" disabled>Update Profile</button>
                            </div>
                        </div>
                    </form>
                    <h3>Account details</h3>
                    @if (Auth::user()->account)
                        <table>
                            <tbody>
                                <tr>
                                    <th>Account Name: </th>
                                    <td>{{ Auth::user()->account->account_name }}</td>
                                </tr>
                                <tr>
                                    <th>Bank</th>
                                    <td>{{ Auth::user()->account->bank }}</td>
                                </tr>
                                <tr>
                                    <th>Account Number</th>
                                    <td>{{ Auth::user()->account->account_number }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <form action="{{ route('account.add') }}" method="post">
                            @csrf
                            <input type="hidden" id="recipient_code" name="recipient_code">
                            <input type="hidden" id="account_name" name="account_name">
                            <input type="hidden" id="bank_name" name="bank">
                            <div class="form-group">
                                <label for="">Account number <i id="account_number_status"></i></label>
                                <input type="text" class="form-control" name="account_number" id="acc_no" minlength="10">
                            </div>
                            <div class="form-group">
                                <i class="text-danger" style="display: none" id="bank_fetch_error_text">Failed to get list
                                    of
                                    banks, plaese refresh this page</i><br>
                                <label for="">Select Bank</label>
                                <div class="spinner-border spinner-border-sm" role="status" id="fetch_banks_spinner">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <select name="bank_code" id="banks" class="form-control"></select>
                            </div>
                            <p id="account_name_text"></p>
                            <div class="spinner-border spinner-border-sm" role="status" id="verify_acc_spinner"
                                style="display: none">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <button class="btn btn-success" onclick="verify_account()" style="display: none"
                                id="verify_acc_btn" type="button">Verify account</button>
                            <br><br><button class="btn btn-primary" type="submit" id="submit_btn"
                                style="display: none">Update
                                Account info</button>
                        </form>
                        <script>
                            $(document).ready(function() {
                                banks_error = $('#bank_fetch_error_text');
                                banks_error.text('');
                                banks_input = $('#banks');
                                verify_acc_btn = $('#verify_acc_btn');
                                banks_spinner = $('#fetch_banks_spinner');
                                $.ajax("{{ route('get.banks') }}", {
                                    dataType: 'json', // type of response data
                                    timeout: 50000, // timeout milliseconds
                                    success: function(data, status, xhr) { // success callback function
                                        banks = data.data;
                                        banks_spinner.hide();
                                        for (i = 0; i < banks.length; i++) {
                                            option_markup = "<option value = '" + banks[i].code + "'>" + banks[i].name +
                                                "</option>";
                                            banks_input.append(option_markup)
                                            //console.log(banks[i].name);
                                        }
                                        verify_acc_btn.show();
                                    },
                                    error: function(jqXhr, textStatus, errorMessage) { // error callback

                                        banks_error.show();
                                        banks_spinner.hide();
                                        console.log(jqXhr);
                                        console.log(textStatus);
                                        console.log(errorMessage);
                                    }
                                });

                            });

                            function verify_account() {
                                account_name_field = $('#account_name_text');
                                spinner = $('#verify_acc_spinner');
                                account_number = $('#acc_no').val();
                                bank = $('#banks').val();
                                recipient_code = $('#recipient_code');
                                account_name = $('#account_name');
                                bank_name = $('#bank_name');
                                account_number_status = $('#account_number_status');
                                submit_btn = $('#submit_btn');


                                if (account_number != '' && account_number.length == 10) {
                                    spinner.show();
                                    $.ajax("{{ route('account.verify') }}?account_number=" + account_number + "&bank_code=" + bank, {
                                        dataType: 'json', // type of response data
                                        timeout: 50000, // timeout milliseconds
                                        success: function(data, status, xhr) { // success callback function
                                            account_number_status.removeClass('text-danger')
                                            account_number_status.addClass('text-success');
                                            account_number_status.text('Valid');
                                            account_name.val(data.data.details.account_name);
                                            bank_name.val(data.data.details.bank_name);
                                            recipient_code.val(data.data.recipient_code);
                                            account_name_field.text('Account Name: ' + data.data.details.account_name);
                                            console.log(data.data.details);
                                            spinner.hide();
                                            submit_btn.show();
                                            $('#acc_no').val(data.data.details.account_number);

                                            //return data
                                        },
                                        error: function(jqXhr, textStatus, errorMessage) { // error callback

                                            banks_error.show();
                                            spinner.hide();
                                            account_number_status.removeClass('text-success')
                                            account_number_status.addClass('text-danger');
                                            account_number_status.text(
                                                'Failed To verify account, check the details and click \'verify\' again');
                                            console.log(jqXhr);
                                            console.log(textStatus);
                                            console.log(errorMessage);
                                            return false
                                        }
                                    });
                                }else{
                                    account_number_status.removeClass('text-success')
                                    account_number_status.addClass('text-danger');
                                    account_number_status.text('please enter a valid account number')
                                }
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection
