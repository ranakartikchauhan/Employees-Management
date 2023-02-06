@extends('layouts.app')
@section('content')
    <div class="py-12">
        <a class="btn btn-primary" href="{{ url('employee/create') }}">Add User</a>
        <x-success-status class="mb-4" :status="session('message')" />
        <div class="container mt-5">
            <h2 class="mb-4">All Employees</h2>
            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Phone</th>
                        <th>ID</th>
                        <th>Hobbies</th>
                        <th>Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript">
            $(function() {
                var table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('get.table.data') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'is_active',
                            name: 'status'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'hobbiescol',
                            name: 'hobbiescol'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true
                        },
                    ]
                });
            });
            $('body').on('click', '.deleteEmployee', function() {
                var id = $(this).data("id");
                console.log(id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You wont be able to revert this!',
                    icon: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/employee/" + id,
                            type: 'DELETE',
                            success: function(result) {
                                console.log("hello page work")
                            },
                            error: function(data) {
                                console.log('ERROR', data)
                            }
                        });
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        'deleteEmployee'.reload();
                    }
                })
            })
        </script>
    @endsection
