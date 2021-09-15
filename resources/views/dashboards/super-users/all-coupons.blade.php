@extends('layouts.app')
@section('title', 'Super Admin dashboard-All Coupons')
@section('content')
    @include('layouts.errors')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        @include('layouts.coupons-sidebar')
                    </div>
                    <div class="col-sm-9">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Coupon</th>
                                    <th>Created</th>
                                    <th>Vendor</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('super-admin.coupons') }}",
                columns: [{
                        data: 'coupon',
                        name: 'coupon'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'vendor',
                        name: 'vendor'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                ]
            });

        });
    </script>
@endsection
