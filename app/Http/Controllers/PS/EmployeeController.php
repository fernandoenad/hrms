<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employees = Employee::join('people', 'people.id', '=', 'person_id')
            ->orderBy('lastname', 'asc')->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);

        
        return view('ps.employees.index', compact('employees'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $employees = Employee::join('people', 'person_id', '=', 'people.id')
            ->where('lastname', 'like' , $searchString . '%')
            ->orWhere('firstname', 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $searchString . '%')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
        
        $employees = $employees->appends(['searchString' => $searchString]);

        return view('ps.employees.index', compact('employees'));
    }

    public function show(Employee $employee)
    {
        return view('ps.employees.show', compact('employee'));
    }

}
