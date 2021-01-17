<?php

namespace App\Http\Controllers\PU;

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

        $empl_a = $this->employeesActiveCounter();
        $empl_i = $this->employeesInactiveCounter();
        
        return view('pu.employees.index', compact('employees', 'empl_a', 'empl_i'));
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
        $empl_i = $this->employeesInactiveCounter();

        return view('pu.employees.index', compact('employees', 'empl_a', 'empl_i'));
    }

    public function show(Employee $employee)
    {
        $person = $employee->person;

        return view('pu.employees.show', compact('person'));
    }

    public function employeesActiveCounter()
    {
        $employees = app('App\Http\Controllers\PS\EmployeeController')->employeesActiveCounter();

        return $employees;
    }

    public function employeesInactiveCounter()
    {
        $unassigned = app('App\Http\Controllers\PS\EmployeeController')->employeesUnassignedCounter();
        $terminated = app('App\Http\Controllers\PS\EmployeeController')->employeesTerminatedCounter();
        $employees = $unassigned + $terminated;

        return $employees;
    }

    public function displayActive()
    {
        $employees = Employee::join('people', 'people.id', '=', 'person_id')
            ->where('item_id', '!=', 0)
            ->where('retirementdate', '=', null)
            ->orderBy('lastname', 'asc')->orderBy('firstname', 'asc')            
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
        
        $empl_a = $this->employeesActiveCounter();
        $empl_i = $this->employeesInactiveCounter();
        return view('pu.employees.index', compact('employees', 'empl_a', 'empl_i'));
    }

    public function displayInactive()
    {
        $employees = Employee::join('people', 'people.id', '=', 'person_id')
            ->where('item_id', '=', 0)
            ->orderBy('lastname', 'asc')->orderBy('firstname', 'asc')            
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
        
        $empl_a = $this->employeesActiveCounter();
        $empl_i = $this->employeesInactiveCounter();

        return view('pu.employees.index', compact('employees', 'empl_a', 'empl_i'));
    }
}
