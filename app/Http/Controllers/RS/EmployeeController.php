<?php

namespace App\Http\Controllers\RS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

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

        $empl_a = $this->employeesActiveCounter();
        
        return view('rs.employees.index', compact('employees', 'empl_a'));
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

        $empl_a = $this->employeesActiveCounter();

        return view('ps.employees.index', compact('employees', 'empl_a'));
    }

    public function show(Employee $employee)
    {
        $person = $employee->person;

        return view('rs.employees.show', compact('person'));
    }

    public function employeesActiveCounter()
    {
        $employees = app('App\Http\Controllers\PS\EmployeeController')->employeesActiveCounter();

        return $employees;
    }
}
