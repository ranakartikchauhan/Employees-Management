<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFormRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('view.permission')->only('show');
        $this->middleware('employees.associate')->only(['edit', 'update', 'delete']);
    }

    public function index()
    {
        return view('employees.index');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(EmployeeFormRequest $request)
    {
        $hobby = $request['hobbies'];
        $hobbies=array();
        for($i=0;$i<sizeof($hobby);$i++){

            $ans=array('hobbies'=>$hobby[$i]);
            array_push($hobbies,$ans);
        }   
        $employee = auth()->user()->employees()->create($request->all());
        $employee->hobbies()->createMany($hobbies);
        return redirect('employees')->with('message', 'Employee Added Successfully');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(EmployeeFormRequest $request, Employee $employee)
    {
        $employee->update($request->except(['_token', '_method', 'hobbies']));
        $hobbies = implode(',', $request['hobbies']);
        $employee->hobbies()->update(['hobbies' => $hobbies]);
        return redirect('employees-data')->with('message', 'Employee updated Successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees')->with('message', 'Employee Deleted Successfully');
    }

}
