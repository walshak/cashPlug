@extends('layouts.app')
@section('title', 'super admin dashboard - view plans')
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>price</th>
                                    <th>validity</th>
                                    <th>Refs</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plans as $plan)
                                    <tr>
                                        <td>{{$plan->name}}</td>
                                        <td>{{$plan->price}}</td>
                                        <td>{{$plan->validity}}</td>
                                        <td>{{$plan->refs}}</td>
                                        <td><a href="{{route('plan.edit',$plan->id)}}"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$plans->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
