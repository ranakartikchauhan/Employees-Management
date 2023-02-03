<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeFormRequest;
use App\Models\Employe;
use App\Models\Hobby;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeController extends Controller
{
    //
    public function index()
    {

        return view('employe.index'); // to show the employees

    }

    public function create()
    {
        return view('employe.create'); // create a file in employe folder
    }

    public function store(EmployeFormRequest $request)
    {

        // in the employee table
        $employee = Employe::create(
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'gender' => $request['gender'],
                'is_active' => $request['status'],
                'phone' => $request['phone'],
                'user_id' => auth()->id(),
            ]
        );

        // Store hobbies in employees_hobby

        $hobby = new Hobby;
        $hobby->hobbies = $request['hobbies'];
        $hobby->employee_id = $employee->id;

        $employee = $employee->hobbies()->save($hobby);

        \Log::info([$request['name'], $request['email']]);
        return redirect('employee')->with('message', 'Employee Added Succesfully');
    }

    public function edit($employe_id)
    {

        $employe = Employe::where('user_id', auth()->id())->find($employe_id);

        if (!$employe) {
            return redirect('employee')->with('message', 'You are not Valid User');

        }
        return view('employe.edit', compact('employe')); // edit  file in employe folder
    }

    public function update(EmployeFormRequest $request, $employe_id)
    {
        $employe = User::find(auth()->id())->employeeData()->where('id', '=', $employe_id)->update([

            'name' => $request['name'],
            'email' => $request['email'],
            'gender' => $request['gender'],
            'is_active' => $request['status'],
            'phone' => $request['phone'],

        ]);

        $edithobbies=Employe::find($employe_id)->hobbies()->update([
            'hobbies'=>$request['hobbies']
        ]);
        



        // $employe = Employe::where('id', $employe_id)->update([
        //     'name' => $request['name'],
        //     'email' => $request['email'],
        //     'gender' => $request['gender'],
        //     'is_active' => $request['status'],
        //     'phone' => $request['phone'],

        // ]);

        return redirect('employee')->with('message', 'Employee updated Succesfully');

    }

    public function destroy($employe_id)
    {

        // $employe = Employe::find($employe_id)->delete();
        $data = user::find(auth()->id())->employeedata()->where('id', '=', $employe_id)->delete();

        return redirect('employee')->with('message', 'Employee Deleted Succesfully');

    }

    public function getEmployees(Request $request)
    {

        if ($request->ajax()) {
            if (auth()->user()->is_admin == true) {
                $data = Employe::get();

            } else {

                // $data = Employe::where('user_id', auth()->id())->latest()->get();
                $data = user::find(auth()->id())->employeeData;
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('hobbiescol', function ($row) {
                    $hobbiescol = '' . $row->hobbies[0]->hobbies . '';
                    return $hobbiescol;
                })

                ->addColumn('action', function ($row) {
                    // . $row->id .

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
       
            $data = Employe::where('user_id', '=', $id)->get();

        return $data;
    }

}
