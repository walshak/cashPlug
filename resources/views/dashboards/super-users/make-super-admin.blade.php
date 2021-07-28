@extends('layouts.app')
@section('title','Super admin dashboard - make super admin')
@section('content')
@include('layouts.errors')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
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
          var table = $('.datatable').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('super-admin.make-super-admin') }}",
              columns: [
                  {data: 'name', name: 'name'},
                  {data: 'email', name: 'email'},
                  {
                      data: 'action',
                      name: 'action',
                      orderable: false,
                      searchable: false
                  },
              ]
          });

        });
    </script>
@endsection
