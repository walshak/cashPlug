@extends('layouts.app')
@section('title', 'User dashboard')
@section('content')
    @include('layouts.errors')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        @include('layouts.financials-sidebar')
                    </div>
                    <div class="col-sm-9">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Requested by</th>
                                    <th>Amount</th>
                                    <th>Requested on</th>
                                    <th>Approved by</th>
                                    <th>Approved on</th>
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
                ajax: "{{ route('super-admin.withdrawals') }}",
                columns: [{
                        data: 'requested_by',
                        name: 'requested_by'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'approved_by',
                        name: 'approved_by'
                    },
                    {
                        data: 'approved_on',
                        name: 'approved_on'
                    },
                ]
            });

        });
    </script>
@endsection
