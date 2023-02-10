@extends('layouts.app')
@section('content')
<h2 style="text-align:center;font-size:22px;color:black;background-color:rgb(255, 43, 43)"> User Profile</h2>
    <div class="container-fluid pt-4">
       
        <div class="container text-center">
            <div class="row justify-content-md-center pt-3 ">

                <div class="col col-6">
                    <table class="table table-danger ">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $employee->name }}</td>
                            </tr>
                            <tr>
                                <td>Email </td>
                                <td>{{ $employee->email }}</< /td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{ $employee->gender }}</< /td>
                            </tr>
                            <tr>
                                <td>Hobbies</td>
                                <td>{{ $employee->hobbies[0]->hobbies }}</< /td>
                            </tr>
    
                        </tbody>
                    </table>
    
                </div>
            </div>

        </div>

    </div>
@endsection
