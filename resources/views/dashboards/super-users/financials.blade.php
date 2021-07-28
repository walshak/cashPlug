@extends('layouts.app')
@section('title','User dashboard')
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
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Date</th>
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
        $(function () {
          var table = $('.datatable').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('super-admin.financials') }}",
              columns: [
                  {data: 'name', name: 'name'},
                  {data: 'amount', name: 'amount'},
                  {data: 'type', name: 'type'},
                  {data: 'created_at', name: 'created_at'},
              ]
          });

        });
    </script>
@endsection
