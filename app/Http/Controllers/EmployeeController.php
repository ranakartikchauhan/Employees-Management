<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFormRequest;
use App\Models\Employee;
use App\Models\Hobby;

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
        return view('employee.index');
    }

    public function show(Employee $employee)
    {
        return view('employee.show-employees', compact('employee'));
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(EmployeeFormRequest $request)
    {
        // Mass assignment
        $employee = Employee::create($request->all() + ['user_id' => auth()->id()]);
        $hobby = implode(',', $request['hobbies']);
        $hobbies = Hobby::create(['employee_id' => $employee->id] + ['hobbies' => $hobby]);
        \Log::info([$request['name'], $request['email']]);
        return redirect('employees')->with('message', 'Employee Added Successfully');
    }

    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    public function update(EmployeeFormRequest $request, Employee $employee)
    {
        $employee->update($request->except(['_token', '_method', 'hobbies']));
        $hobbies = implode(',', $request['hobbies']);
        $employee->hobbies()->update(['hobbies' => $hobbies,]);
        return redirect('employees-data')->with('message', 'Employee updated Successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees')->with('message', 'Employee Deleted Successfully');
    }

  
}
