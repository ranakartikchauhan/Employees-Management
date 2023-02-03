@extends('layouts.app')
@section('content')
    <h2>Employees Data</h2>
    <select id="user" class="form-select form-select-lg mb-3 user" aria-label=".form-select-lg example">
        @foreach ($data as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
    <table class="table">
        <tbody>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                </tr>
            </thead>
            <tr>
                <td id="employee_name"></td>
                <td id="employee_email"></td>
            </tr>
        </tbody>
        {{--  // This line is for make a another dropdown for employyes email --}}
        {{-- <select id="employees" class="form-select form-select-lg mb-3 user" aria-label=".form-select-lg example">
                
                    <option value=""></option>
                 
                  </select> --}}
    </table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script type="text/javascript">
        $('body').on('change', '.user', function() {
            var id = $(this).find(":selected").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ 'employee-list/' }}" + id,
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
                        $("#employee_name").html(`<ol> ${getName(employeeData)}</ol>`);
                        $("#employee_email").html(`<ol> ${getMail(employeeData)}</ol>`);
                        // using javascript
                        // document.querySelector("#employee_name").innerHTML=`<ol> ${getName(employeeData)}</ol>`;
                        // document.querySelector("#employee_email").innerHTML=`<ol> ${getMail(employeeData)}</ol>`
                    } else {
                        $("#employee_name").html(`<ol>No Records</ol>`);
                    }
                }
            })
        });
    </script>
@endsection
