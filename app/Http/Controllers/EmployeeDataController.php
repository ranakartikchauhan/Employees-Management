<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeDataController extends Controller
{
    public function index(Request $request)
    {
        $employees = auth()->user()->is_admin
        ? Employee::get()
        : auth()->user()->employees;

        return Datatables::of($employees)
            ->addIndexColumn()
            ->addColumn('hobbies', function ($employee) {
                $hobby = $employee['hobbies'];
                $hobbies = array();
                foreach ($hobby as $x => $x_value) {
                    array_push($hobbies, ($x_value->hobbies));
                }

                return $hobbies;
            })

            ->addColumn('action', function ($row) {

                $actionBtn = '
                <a  href="employees/' . $row->id . '" class="btn btn-primary btn-sm">Show</a>
                <a href="employees/' . $row->id . '/edit" class=" btn btn-success btn-sm">Edit</a>
                <button data-id="' . $row->id . '" class="delete btn btn-danger btn-sm deleteEmployee" >Delete</button>';

                return $actionBtn;
            })
            ->editColumn('is_active', function ($data) {
                return ($data->is_active == '1') ? 'Active' : 'Inactive';
            })
            ->rawColumns(['action', 'viewBtn', 'hobbies'])
            ->make(true);
            
    }
}
