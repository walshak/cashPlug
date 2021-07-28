@extends('layouts.app')
@section('title','Admin dashboard - suspend user')
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
                            <th>Ref Id</th>
                            <th>Member since</th>
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
              ajax: "{{ route('admin.suspend-user') }}",
              columns: [
                  {data: 'name', name: 'name'},
                  {data: 'email', name: 'email'},
                  {data: 'ref_id', name: 'ref_id'},
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
