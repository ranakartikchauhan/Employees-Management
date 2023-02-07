<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeDataController extends Controller
{
    public function isAdmin(): bool
    {
        return auth()->user()->is_admin;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = $this->isAdmin()
            ? Employee::get()
            : auth()->user()->employees;

            return Datatables::of($employees)
                ->addIndexColumn()
                ->addColumn('hobbies', function ($row) {
                    $hobbies = '' . $row->hobbies[0]->hobbies . '';

                    return $hobbies;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="employees/' . $row->id . '/edit" class=" btn btn-success btn-sm">Edit</a>
                    <button data-id="' . $row->id . '" class="delete btn btn-danger btn-sm deleteEmployee" >Delete</button>';

                    return $actionBtn;
                })
                ->editColumn('is_active', function ($data) {
                    return ($data->is_active == '1') ? 'Active' : 'Inactive';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('employee.index');
    }

    public function getData($id)
    {
        $data = Employee::where('user_id', $id)->get();
        return $data;
    }
}
