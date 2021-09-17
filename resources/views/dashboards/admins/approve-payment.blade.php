@extends('layouts.app')
@section('title','Admin dashboard - approve payment')
@section('content')
@include('layouts.errors')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table yajra-datatable">
                    <thead>
                        <tr>
                            <th>Account Data</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {

          var table = $('.yajra-datatable').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('admin.approve-payment') }}",
              columns: [
                  {data: 'account_details', name: 'account_details'},
                  {data: 'amount', name: 'amount'},
                  {data: 'created_at', name: 'created_at'},
                  {
                      data: 'action',
                      name: 'action',
                      orderable: true,
                      searchable: true
                  },
              ]
          });

        });
    </script>
@endsection
