<?php
namespace App\Http\Controllers;

use App\Http\Requests\EmployeFormRequest;
use App\Models\Employee;
use App\Models\Hobby;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeController extends Controller
{
    public function isAdmin(): bool
    {
        return auth()->user()->is_admin;
    }

    public function index()
    {
        return view('employe.index');
    }

    public function create()
    {
        return view('employe.create');
    }

    public function store(EmployeFormRequest $request)
    {
        // Mass assignment
        $employee = Employee::create($request->all() + ['user_id' => auth()->id()]);
        $hobbie = implode(",", $request['hobbies']);
        $hobbies = Hobby::create(['employee_id' => $employee->id] + ['hobbies' => $hobbie]);
        \Log::info([$request['name'], $request['email']]);
        return redirect('employee')->with('message', 'Employee Added Succesfully');
    }

    public function edit($employe_id)
    {
        $this->isAdmin() ? $employe = Employee::find($employe_id) : $employe = Employee::where('user_id', auth()->id())->find($employe_id);
        if (!$employe) {
            return redirect('employee')->with('message', 'You are not Valid User');
        }
        return view('employe.edit', compact('employe'));
    }

    public function update(EmployeFormRequest $request, $employe_id)
    {
        $employe = User::find(auth()->id())->employees()->where('id', $employe_id)->update($request->except(['_token', '_method', 'hobbies']));
        if ($this->isAdmin()) {
            $employe = Employee::find($employe_id)->update($request->except(['_token', '_method', 'hobbies']));
        }
        $hobbies = implode(",", $request['hobbies']);
        $editHobbies = Employee::find($employe_id)->hobbies()->update([
            'hobbies' => $hobbies,
        ]);
        return redirect('employee')->with('message', 'Employee updated Succesfully');
    }

    public function destroy($employe_id)
    {
        $this->isAdmin() ? $data = Employee::where('id', $employe_id)->delete() : $data = user::find(auth()->id())->employees()->where('id', '=', $employe_id)->delete();
        return redirect('employee')->with('message', 'Employee Deleted Succesfully');
    }

    public function getEmployees(Request $request)
    {
        if ($request->ajax()) {
            $this->isAdmin() ? $data = Employee::get() : $data = user::find(auth()->id())->employees;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('hobbiescol', function ($row) {
                    $hobbiesCol = '' . $row->hobbies[0]->hobbies . '';
                    return $hobbiesCol;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="employee/' . $row->id . '/edit" class=" btn btn-success btn-sm">Edit</a>
                    <button data-id="' . $row->id . '" class="delete btn btn-danger btn-sm deleteEmployee" >Delete</button>';
                    return $actionBtn;
                })
                ->editColumn('is_active', function ($data) {
                    return ($data->is_active == '1') ? "Active" : "Inactive";;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function employeeList($id)
    {
        $data = Employee::where('user_id', $id)->get();
        return $data;
    }
}
