@extends('layouts.app')
@section('title', 'Admin dashboard - settings')
@section('content')
    @include('layouts.errors')
    @if ($plan_active == false)
        <div class="alert alert-warning" role="alert">
            You currently have no active contribution plan <a class="btn btn-primary" href="{{ route('admin.settings') }}">Select
                Plan</a>
        </div>
    @endif
    <div class="container">
        <div class="row">
            @if ($plan_active)
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>
                                Your current plan:
                            </h2>
                            <small class="text-danger">Plan expires in {{ $plan_expires }} days</small>
                        </div>
                        {{-- <img src="{{ asset('landing-page/assets/img/header-bg.jpg') }}" alt="" class="card-image-top"> --}}
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <h3>{{ $cur_plan->name }}</h3>
                                    <p>
                                        <i class="fas fa-check"></i> {{ $cur_plan->refs }} contributors per cycle <br>
                                        <i class="fas fa-check"></i> {{ $cur_plan->price }} NGN <br>
                                        <i class="fas fa-check"></i> {{ $cur_plan->validity }} Days <br>
                                        <i class="fas fa-check"></i> Make at least
                                        {{ $cur_plan->price * $cur_plan->refs * env('USER_PERCENTAGE') }} NGN <br>
                                        <i class="fas fa-check"></i> Min withdarwal
                                        {{ $cur_plan->price * 2 * env('USER_PERCENTAGE') }} NGN <br>
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <h3>You have achieved</h3>
                                    <p>
                                        <i class="fas fa-check"></i> {{ count($refs_for_cur_cycle) }} contributors in this
                                        cycle
                                        <br>
                                        <i class="fas fa-check"></i> {{ count($all_refs) }} contributors in total <br>
                                        <i class="fas fa-check"></i> {{ $balance }} NGN is your current balance <br>
                                        <i class="fas fa-check"></i> {{ $bal_for_cur_cycle }} NGN made in this cycle <br>
                                    </p>
                                </div>
                            </div>
                            <a href="#" class="btn btn-warning disabled"> Subscribed</a>
                            @if ($bal_for_cur_cycle >= $cur_plan->price * 2 * env('USER_PERCENTAGE') && $withrawal_requested == false)
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Request withdrawal
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Request withdrawal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.request-withdrawal') }}" method="post">
                                                    @csrf
                                                    <label for="">Amount</label>
                                                    <input type="number" name="amount" id="" class="form-control" min="0"
                                                        max="{{ $balance }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit request</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif (($bal_for_cur_cycle >= $cur_plan->price * 2 * env('USER_PERCENTAGE')) &&
                                ($withrawal_requested == true))
                                <a href="#" class="btn btn-secondary disabled">Withdrawal pending</a>
                            @else
                                <a href="#" class="btn btn-secondary disabled">Withdraw(not availiable yet)</a>
                            @endif
                        </div>
                        <div class="card-footer">
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
                        </div>
                    </div>
                </div>
            @else
                @if (Auth::user()->account)
                    @foreach ($plans as $plan)
                        <div class="col-sm-4">
                            <div class="card">
                                {{-- <img src="{{ asset('landing-page/assets/img/header-bg.jpg') }}" alt=""
                                    class="card-image-top"> --}}
                                <div class="card-body">
                                    <h3>{{ $plan->name }}</h3>
                                    <p>
                                        <i class="fas fa-check"></i> {{ $plan->refs }} contributors per cycle <br>
                                        <i class="fas fa-check"></i> {{ $plan->price }} NGN <br>
                                        <i class="fas fa-check"></i> {{ $plan->validity }} Days <br>
                                        <i class="fas fa-check"></i> Make at least
                                        {{ $plan->price * $plan->refs * env('USER_PERCENTAGE') }} NGN <br>
                                        <i class="fas fa-check"></i> Min withdarwal
                                        {{ $plan->price * 4 * env('USER_PERCENTAGE') }} NGN <br>
                                    </p>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-warning"
                                        onclick="$('#paymentForm{{ $plan->id }}').toggle()">
                                        Subscribe
                                    </button>
                                    <script>
                                        function makePayment{{ $plan->id }}() {
                                            FlutterwaveCheckout({
                                                public_key: "{{env('PK_KEY')}}",
                                                tx_ref: '' + Math.floor((Math.random() * 1000000000000) +
                                                    1
                                                ),
                                                amount: document.getElementById("amount{{ $plan->id }}").value,
                                                currency: "NGN",
                                                country: "NG",
                                                payment_options: "card,account,banktransfer,ussd",
                                                callback: function(data) { // specified callback function
                                                    console.log(data);
                                                    window.location =
                                                        "{{ url('subscribe') }}?plan-id={{ $plan->id }}&reference=" +
                                                        data.transaction_id
                                                },
                                                customer: {
                                                    email: document.getElementById("email-address{{ $plan->id }}").value,
                                                    phone_number: "07050737402",
                                                    name: "{{ Auth::user()->name }}",
                                                },
                                                onclose: function() {
                                                    // close modal
                                                    alert('Window closed.');
                                                },
                                                customizations: {
                                                    title: "CashPlug Suscription",
                                                    description: "{{ $plan->name }} plan",
                                                    logo: "https://assets.piedpiper.com/logo.png",
                                                },
                                            });
                                        }
                                    </script>
                                    <form id="paymentForm{{ $plan->id }}" style="display: none"
                                        class="row row-cols-lg-auto">
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" id="email-address{{ $plan->id }}" required
                                                value="{{ Auth::user()->email }}" class="form-control" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="tel" id="amount{{ $plan->id }}" required
                                                value="{{ $plan->price }}" class="form-control" readonly />
                                        </div>
                                        <div class="form-submit">
                                            <button type="button" class="btn btn-primary"
                                                onclick="makePayment{{ $plan->id }}()"> Pay Now
                                            </button>
                                            <button type="button" class="btn btn-warning m-3"
                                                onclick="$('#paymentForm{{ $plan->id }}').toggle()">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $plans->links() }}
                @else
                    <div class="card">
                        <div class="card-body">
                            <p>You have not added a bank account yet, <a href="{{ route('admin.profile') }}"
                                    class="btn btn-primary">Add account</a></p>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
