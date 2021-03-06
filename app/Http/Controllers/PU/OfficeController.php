<?php

namespace App\Http\Controllers\PU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Station;
use App\Models\Employee;
use App\Models\Town;
use App\Models\Person;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
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
        $offices = Office::orderBy('name', 'asc')->get();

        return view('pu.offices.index', compact('offices'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $offices = Office::where('name', 'like' , $searchString . '%')
            ->orderBy('name', 'asc')
            ->paginate(15);
        
        return view('pu.offices.index', compact('offices'));
    }

    public static function getEmployees($office_id, $employeetype)
    {
        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('items', 'deployments.item_id', '=', 'items.id')
            ->join('stations', 'deployments.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->where('offices.id', '=', $office_id)
            ->where('items.employeetype', 'LIKE', $employeetype);

        return $employees;
    }

    public function create()
    {
        $offices = Office::get();

        $towns = Town::orderBy('name', 'asc')->get();

        $people = Person::orderBy('firstname', 'asc')
            ->orderBy('lastname', 'asc')
            ->select('id', 'firstname', 'lastname', 'extname')->get();

        return view('pu.offices.index', compact('offices', 'towns', 'people'));

    }

    public function store()
    {
        $offices = Office::get(); 

        $data = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\-\.\s]*$/', 'unique:offices'],
            'town_id' => ['required'],
            'person_id' => ['required'],
        ],
        [
            'person_id.required' => 'The office head field is required.',
        ]);

        $office = Office::create($data);

        return redirect()->route('pu.offices.edit', compact('offices', 'office'))->with('status', 'Office created!');

    }

    public function delete(Office $office)
    {
        $offices = Office::get(); 

        $office->delete();

        return redirect()->route('pu.offices', compact('offices'))->with('status', 'Office deleted!');

    }

    public function edit(Office $office)
    {
        $offices = Office::get();

        $towns = Town::orderBy('name', 'asc')->get();

        $people = Person::orderBy('firstname', 'asc')
            ->orderBy('lastname', 'asc')
            ->select('id', 'firstname', 'lastname', 'extname')->get();

        return view('pu.offices.index', compact('offices', 'towns', 'people', 'office'));

    }

    public function update(Office $office)
    {
        $offices = Office::get(); 

        $data = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\-\.]*$/', Rule::unique('offices')->ignore($office->id)],
            'town_id' => ['required'],
            'person_id' => ['required'],
        ]);

        $office->update($data);

        return redirect()->route('pu.offices.edit', compact('offices', 'office'))->with('status', 'Office updated!');

    }

    public function lookup()
    {
        $searchString = request()->get('searchString');

        $employees = Employee::join('people', 'employees.person_id', '=', 'people.id')
            ->where(function ($query) use ($searchString){
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

        return view('pu.offices.lookup', compact('employees'));
    } 
}

