@extends('layouts.app')
@section('content')
    <div class="container text-center px-20 pt-6">

    <select id="user" class="form-select form-select-lg mb-3 user" aria-label=".form-select-lg example">
        <option  selected> Please Select a User </option>
        @foreach ($data as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
    <table class="table table-danger">
        <tbody>
            <thead>
                <tr class="table-dark">
                    <td>Name</td>
                    <td>Email</td>
                </tr>
            </thead>
            <tr>
                <td id="employee_name"></td>
                <td id="employee_email"></td>
            </tr>
            <tr id="no_records">
                <td>No Records Found</td>
                <td></td>
            </tr>
        </tbody>
        {{--  // This line is for make a another dropdown for employyes email --}}
        {{-- <select id="employees" class="form-select form-select-lg mb-3 user" aria-label=".form-select-lg example">
                
                    <option value=""></option>
                 
                  </select> --}}
    </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script type="text/javascript">
        $('body').on('change', '.user', function() {
            var id = $(this).find(":selected").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ 'employees-list/' }}" + id,
                success: function(employeeData) {
                    function getName(arg) {
                        let names = "";
                        for (let i = 0; i < arg.length; i++) {
                            names += `<li>${arg[i].name}</li>`;
                        }
                        return names;
                    }

                    function getMail(arg) {
                        let emails = "";
                        for (let i = 0; i < arg.length; i++) {
                            emails += `<li>${arg[i].email}</li>`;
                            // This line is for make a another dropdown for employyes email
                            // $('#employees').append(`<option value="${arg[i].email}">
                        //                ${arg[i].email}
                        //           </option>`);
                        }
                        return emails;
                    }
                    if (employeeData) {
                        $("#no_records").hide();
                        $("#employee_name").html(`<ol> ${getName(employeeData)}</ol>`);
                        $("#employee_email").html(`<ol> ${getMail(employeeData)}</ol>`);
                    } 
                }
            })
        });
    </script>
@endsection
