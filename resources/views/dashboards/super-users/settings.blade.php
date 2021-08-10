@extends('layouts.app')
@section('title', 'Super admin dashboard - settings')
@section('content')
    @include('layouts.errors')
    @if ($plan_active == false)
        <div class="alert alert-warning" role="alert">
            You currently have no active plan <a class="btn btn-primary" href="{{ route('users.settings') }}">Select
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
                                        <i class="fas fa-check"></i> {{ $cur_plan->refs }} refrrals per cycle <br>
                                        <i class="fas fa-check"></i> {{ $cur_plan->price }} NGN <br>
                                        <i class="fas fa-check"></i> {{ $cur_plan->validity }} Days <br>
                                        <i class="fas fa-check"></i> Make at least
                                        {{ $cur_plan->price * $cur_plan->refs * env('USER_PERCENTAGE') }}k <br>
                                        <i class="fas fa-check"></i> Min withdarwal
                                        {{ $cur_plan->price * 2 * env('USER_PERCENTAGE') }}k <br>
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <h3>You have achieved</h3>
                                    <p>
                                        <i class="fas fa-check"></i> {{ count($refs_for_cur_cycle) }} refrrals in this
                                        cycle
                                        <br>
                                        <i class="fas fa-check"></i> {{ count($all_refs) }} refrrals in total <br>
                                        <i class="fas fa-check"></i> {{ $balance }}k is your current balance <br>
                                        <i class="fas fa-check"></i> {{ $bal_for_cur_cycle }}k made in this cycle <br>
                                    </p>
                                </div>
                            </div>
                            <a href="#" class="btn btn-warning disabled"> Subscribed</a>
                            @if (($bal_for_cur_cycle >= $cur_plan->price * 2 * env('USER_PERCENTAGE'))&& ($withrawal_requested == false))
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
                                                <form action="{{ route('super-admin.request-withdrawal') }}" method="post">
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
                            <div class="form-group">
                                <label for="">Your referral link</label>
                                <input type="text" value="{{route('register',['ref_id'=>Auth::user()->ref_id])}}" class="form-control form-control-lg disabled">
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($plans as $plan)
                    <div class="col-sm-4">
                        <div class="card">
                            <img src="{{ asset('landing-page/assets/img/header-bg.jpg') }}" alt=""
                                class="card-image-top">
                            <div class="card-body">
                                <h3>{{ $plan->name }}</h3>
                                <p>
                                    <i class="fas fa-check"></i> {{ $plan->refs }} refrals per cycle <br>
                                    <i class="fas fa-check"></i> {{ $plan->price }} NGN <br>
                                    <i class="fas fa-check"></i> {{ $plan->validity }} Days <br>
                                    <i class="fas fa-check"></i> Make at least
                                    {{ $plan->price * $plan->refs * env('USER_PERCENTAGE') }}k <br>
                                    <i class="fas fa-check"></i> Min withdarwal
                                    {{ $plan->price * 2 * env('USER_PERCENTAGE') }}k <br>
                                </p>
                                <a href="{{ route('users.subscribe', $plan->id) }}" class="btn btn-warning"> Subscribe
                                </a>
                                <br>

                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $plans->links() }}
            @endif
        </div>
    </div>
@endsection
