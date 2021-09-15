@extends('layouts.app')
@section('title', 'Admin dashboard-My Coupons')
@section('content')
    @include('layouts.errors')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Coupon</th>
                                    <th>Created</th>
                                    <th>Plan</th>
                                    <th>Status</th>
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
                ajax: "{{ route('admin.my-coupons') }}",
                columns: [{
                        data: 'coupon',
                        name: 'coupon'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'plan',
                        name: 'plan'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ]
            });

        });
    </script>
@endsection
