@extends('layouts.app')
@section('content')

           
        <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Gender</th>
             
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">{{$employee->id}}</th>
                <td>{{$employee->name}}</td>
                <td>{{$employee->email}}</</td>
                <td>{{$employee->gender}}</</td>
               
              </tr> 
            
            </tbody>
          </table>
  
@endsection