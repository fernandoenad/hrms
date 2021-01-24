<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Station;
use App\Models\Dropdown;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $employees = $this->getList()->paginate(15);     
        $empl_a = $this->employeesActiveCounter();
        $empl_un = $this->employeesUnassignedCounter();
        $empl_te = $this->employeesTerminatedCounter();
    
        return view('ps.employees.index', compact('employees', 'empl_a', 'empl_un', 'empl_te'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');

        $employees = $this->getList();
        
        $employees = $employees->where(function ($query) use ($searchString){
                $query->where('lastname', 'like' , $searchString . '%')
                    ->orWhere('firstname', 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $searchString . '%')
                    ->orderBy('lastname', 'asc')
                    ->orderBy('firstname', 'asc');
            })
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
        
        $employees = $employees->appends(['searchString' => $searchString]);

        $empl_a = $this->employeesActiveCounter();
        $empl_un = $this->employeesUnassignedCounter();
        $empl_te = $this->employeesTerminatedCounter();

        return view('ps.employees.index', compact('employees', 'empl_a', 'empl_un', 'empl_te'));
    }

    public function getList()
    {
        $employees = Employee::join('people', 'people.id', '=', 'person_id')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*');
        
        return $employees;
    }

    public function show(Employee $employee)
    {
        $person = $employee->person;

        return view('ps.employees.show', compact('person'));
    }

    public function edit(Employee $employee)
    {
        $employmentstatuses = Dropdown::where('type', 'employmentstatus')
            ->get();

        $stations = Station::select('id', 'code', 'name', 'office_id')
            ->orderBy('code', 'asc')
            ->get();

        $person = $employee->person;
        
        return view('ps.employees.edit', compact('person', 'employmentstatuses', 'stations'));
    }

    public function update(Employee $employee)
    {
        $data = request()->validate([
            'empno' => ['required', 'string', 'min:7', 'max:12', 'regex:/^[Tt0-9-]*$/', Rule::unique('employees')->ignore($employee->id)],
            'tinno' => ['nullable', 'string', 'min:9', 'max:12', 'regex:/^[0-9]*$/', 'unique:employees'],
            'gsisbpno' => ['nullable', 'string', 'min:9', 'max:12', 'regex:/^[0-9]*$/', 'unique:employees'],
            'pagibigid' => ['nullable', 'string', 'min:12', 'max:12', 'regex:/^[0-9]*$/', 'unique:employees'],
            'philhealthno' => ['nullable', 'string', 'min:12', 'max:12', 'regex:/^[0-9]*$/', 'unique:employees'],
            'dbpaccountno' => ['nullable', 'string', 'min:6', 'max:12', 'regex:/^[0-9]*$/', 'unique:employees'],
            'step' => ['required'],
            'employmentstatus' => ['required'],
            'hiredate' => ['required', 'date'],
            'lastapptdate' => ['required', 'date'],
            'lastnosidate' => ['required', 'date'],
            'retirementdate' => ['required', 'date'],
            'appointmentdate' => ['required', 'date'],
            'firstdaydate' => ['required', 'date'],
        ]); 
        
        if(isset(request()->lastnosidate_mark))
            $data = array_merge($data, ['lastnosidate' => NULL]);
        
        if(isset(request()->retirementdate_mark))
            $data = array_merge($data, ['retirementdate' => NULL]);
        
        $employee->update($data);

        $employee->item()->update([
            'appointmentdate' => $data['appointmentdate'],
            'firstdaydate' => $data['firstdaydate'],     
        ]);
       
        return redirect()->route('ps.employees.show', compact('employee'))->with('status', 'Employment updated!');
    }

    public function si(Employee $employee)
    {
        $person = $employee->person;
        
        return view('ps.employees.si', compact('person'));
    }

    public function sidone(Employee $employee)
    {
        if($employee->lastnosidate == null)
            $lastnosidate = date('Y-m-d', strtotime($employee->lastapptdate));
        else
            $lastnosidate = date('Y-m-d', strtotime($employee->lastnosidate));

        $limit = date('Y-m-d', strtotime('+3 years', strtotime($lastnosidate)));

        $data = request()->validate([
            'step' => ['required'],
            'lastnosidate' => ['required', 'date', 'after:'.$limit],
        ]);

        $employee->update($data);
        
        return redirect()->route('ps.employees.show', compact('employee'))->with('status', 'SG-Step incremented!');;
    }

    public function pr(Employee $employee)
    {
        $items = Item::where('status', '=', 1)
            ->whereNotIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->get();

        $person = $employee->person;
        
        return view('ps.employees.pr', compact('person', 'items'));
    }

    public function prdone(Employee $employee)
    {
        if($employee->lastnosidate == null)
            $appointmentdateLimit = date('Y-m-d', strtotime($employee->lastapptdate));
        else
            $appointmentdateLimit = date('Y-m-d', strtotime($employee->lastnosidate));

        $firstdaydateLimit = request()->appointmentdate;

        $data = request()->validate([
            'item_id' => ['required'],
            'appointmentdate' => ['required', 'date', 'after:' . $appointmentdateLimit],
            'firstdaydate' => ['required', 'date' , 'after_or_equal:' . $firstdaydateLimit],
        ],
        [
            'item_id.required' => 'The newitemno field is required.',
        ]);
        
        $employee->update(array_merge($data, [
            'item_id' => $data['item_id'],
            'lastnosidate' => $data['firstdaydate'],
            'lastapptdate' => $data['firstdaydate'],
            'step' => 1,
            ]));

        $employee->item()->update([
            'appointmentdate' => $data['appointmentdate'],
            'firstdaydate' => $data['firstdaydate'],     
        ]);

        return redirect()->route('ps.employees.show', compact('employee'))->with('status', 'Rank promoted!');
    }

    public function ee(Employee $employee)
    {
        $person = $employee->person;
        
        return view('ps.employees.ee', compact('person'));
    }

    public function eedone(Employee $employee)
    {
        if($employee->lastnosidate == null)
            $retirementdateLimit = date('Y-m-d', strtotime($employee->lastapptdate));
        else
            $retirementdateLimit = date('Y-m-d', strtotime($employee->lastnosidate));

        $data = request()->validate([
            'retirementdate' => ['required', 'date', 'after:' . $retirementdateLimit],
        ]);

        $employee->item()->update([
            'appointmentdate' => null,
            'firstdaydate' => null,     
        ]);

        $employee->update(array_merge($data, [
            'item_id' => 0,
        ]));
       
        return redirect()->route('ps.employees.show', compact('employee'))->with('status', 'Employee terminated!');
    }

    public function employeesActiveCounter()
    {
        $employees = $this->getList();

        $employees = $employees->where('item_id', '!=', 0)
            ->where('retirementdate', '=', null)->count();

        return $employees;
    }

    public function employeesUnassignedCounter()
    {
        $employees = $this->getList();

        $employees = $employees->where('item_id', '=', 0)
            ->where('retirementdate', '=', null)->count();

        return $employees;
    }

    public function employeesTerminatedCounter()
    {
        $employees = $this->getList();

        $employees = $employees->where('item_id', '=', 0)
            ->where('retirementdate', '!=', null)->count();

        return $employees;
    }

    public function displayActive()
    {
        $employees = $this->getList();

        $employees = $employees->where('item_id', '!=', 0)
            ->where('retirementdate', '=', null)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')            
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
        
        $empl_a = $this->employeesActiveCounter();
        $empl_un = $this->employeesUnassignedCounter();
        $empl_te = $this->employeesTerminatedCounter();
    
        return view('ps.employees.index', compact('employees', 'empl_a', 'empl_un', 'empl_te'));
    }

    public function displayUnassigned()
    {
        $employees = $this->getList();

        $employees = $employees->where('item_id', '=', 0)
            ->where('retirementdate', '=', null)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')            
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
        
        $empl_a = $this->employeesActiveCounter();
        $empl_un = $this->employeesUnassignedCounter();
        $empl_te = $this->employeesTerminatedCounter();
    
        return view('ps.employees.index', compact('employees', 'empl_a', 'empl_un', 'empl_te'));
    }

    public function displayTerminated()
    {
        $employees = $this->getList();

        $employees = $employees->where('item_id', '=', 0)
            ->where('retirementdate', '!=', null)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')            
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
        
        $empl_a = $this->employeesActiveCounter();
        $empl_un = $this->employeesUnassignedCounter();
        $empl_te = $this->employeesTerminatedCounter();
    
        return view('ps.employees.index', compact('employees', 'empl_a', 'empl_un', 'empl_te'));
    }


    public function confirmDelete(Employee $employee)
    {
        $person = $employee->person;
        
        return view('ps.employees.confirmdelete', compact('person'));
    }

    public function delete(Employee $employee)
    {
        $person = $employee->person;
        
        $employee->item()->update([
            'appointmentdate' => null,
            'firstdaydate' => null,     
        ]);

        $employee->delete();

        return redirect()->route('ps.people.show', compact('person'))->with('status', 'Employment record deleted!');
    }

    public function lookupItem(Employee $employee)
    {
        $searchString = request()->get('searchString');

        $items = Item::where('status', '=', 1)
            ->whereNotIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->where(function($query) use ($searchString) {
                $query->where('itemno', 'like', '%' . $searchString . '%') 
                    ->orWhere('position', 'like', $searchString . '%');
            })       
            ->paginate(15);

        $items = $items->appends(['searchString' => $searchString]);

        return view('ps.employees.lookup', compact('employee', 'items'));
    }

    public function confirmReemploy(Employee $employee)
    {
        if($employee->item_id != 0)
            return redirect()->route('ps.employees.show', compact('employee'))->with('error', 'Employee is currently employed.');

        $items = Item::where('status', '=', 1)
            ->whereNotIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->get();

        $employmentstatuses = Dropdown::where('type', 'employmentstatus')
            ->get();

        $person = $employee->person;

        return view('ps.employees.reemploy', compact('person', 'items', 'employmentstatuses'));
    }

    public function processReemploy(Employee $employee)
    {
        if($employee->lastnosidate == null)
            $appointmentdateLimit = date('Y-m-d', strtotime($employee->lastapptdate));
        else
            $appointmentdateLimit = date('Y-m-d', strtotime($employee->lastnosidate));

        $firstdaydateLimit = request()->appointmentdate;

        $data = request()->validate([
            'item_id' => ['required'],
            'employmentstatus' => ['required'],
            'appointmentdate' => ['required', 'date', 'after:' . $appointmentdateLimit],
            'firstdaydate' => ['required', 'date' , 'after_or_equal:' . $firstdaydateLimit],
        ],
        [
            'item_id.required' => 'The newitemno field is required.',
        ]);
        
        $employee->update(array_merge($data, [
            'item_id' => $data['item_id'],
            'employmentstatus' => $data['employmentstatus'],
            'lastnosidate' => null,
            'lastapptdate' => $data['firstdaydate'],
            'retirementdate' => null,
            'step' => 1,
            ]));

        $employee->item()->update([
            'appointmentdate' => $data['appointmentdate'],
            'firstdaydate' => $data['firstdaydate'],     
        ]);

        return redirect()->route('ps.employees.show', compact('employee'))->with('status', 'Employee was re-employed!');
    }
}