@extends('layouts.app')
@section('content')
    <div class="py-12">


        <input type="text" class="float-right me-3" id="custom-search-for-datatables" class="form-control" placeholder="Search here">

        <a class="btn btn-primary float-right me-5" href="{{ route('employees.create') }}">Add User</a>
        <x-success-status class="mb-4" :status="session('message')" />
        <div class="container mt-5">
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
                        <th>View/Edit/Delete</th>
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
                    sDom: '<"top"i>rt<"bottom"i><"clear">',
                    ajax: {
                        'url': '{{ route('get.table.data') }}',
                        'type': 'POST',
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
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
                            data: 'hobbies',
                            name: 'hobbies'

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

            $('#custom-search-for-datatables').on('change', function() {
                var table = $('.yajra-datatable').DataTable(); // get all visible DT instances

                table.search( this.value ).draw();

            });
            $('body').on('click', '.deleteEmployee', function() {
                var id = $(this).data("id");
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
                            url: "/employees/" + id,
                            type: 'DELETE',
                            success: function(result) {
                                'yajra-datatable'.reload();
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
                        $('.yajra-datatable').DataTable().ajax.reload();
                    }
                })
            })
        </script>
    @endsection
