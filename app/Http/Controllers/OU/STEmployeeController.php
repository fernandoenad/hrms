<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Deployment;
use App\Models\Employee;
use App\Models\Contact;
use App\Models\Person;
use App\Models\Address;
use App\Models\Dropdown;
use App\Models\Item;
use Illuminate\Support\Facades\DB;



class STEmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Station $station)
    {
        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->where('station_id', '=', $station->id)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);

        return view('ou.station.employees.index', compact('station', 'employees'));
    }

    public function search(Station $station)
    {
        $str = request()->get('str');

        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->join('items', 'deployments.item_id', '=', 'items.id')
            ->where('deployments.station_id', '=', $station->id)
            ->where(function ($query) use ($str){
                $query->where('lastname', 'like' , $str . '%')
                    ->orWhere('firstname', 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $str . '%')
                    ->orWhere('position', 'like', '%' . $str . '%');
                })
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
      
        $employees = $employees->appends(['str' => $str]);
       
        return view('ou.station.employees.index', compact('station', 'employees'));
    }

    public function filter(Station $station, $filter)
    {

        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->join('items', 'deployments.item_id', '=', 'items.id')
            ->where('deployments.station_id', '=', $station->id)
            ->where('position', 'like', $filter)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(1000);
             
        return view('ou.station.employees.index', compact('station', 'employees'));
    }

    public function items(Station $station, $pagination)
    {
        $items = Item::join('deployments', 'items.id', '=', 'deployments.item_id')
            ->where('deployments.station_id', '=', $station->id)
            ->orderByRaw('CONVERT(salarygrade, SIGNED) desc')
            ->paginate($pagination);

        return view('ou.station.employees.items', compact('station', 'items'));
    }

    public function plantilla(Station $station, $pagination)
    {
        $items = Item::join('employees', 'items.id', '=', 'employees.item_id')
            ->where('items.station_id', '=', $station->id)
            ->orderByRaw('CONVERT(salarygrade, SIGNED) desc')
            ->paginate($pagination);

        return view('ou.station.employees.plantilla', compact('station', 'items'));
    }

    public function show(Station $station, Employee $employee)
    {
        $person = $employee->person;

        return view('ou.station.employees.show', compact('station', 'person'));
    }

    public function edit(Station $station, Employee $employee)
    {
        $sexes = Dropdown::where('type', 'sex')->get();
        $extensions = Dropdown::where('type', 'extension')->get();
        $relations = Contact::groupBy('emergencyrelation')
            ->select('emergencyrelation')
            ->get();
        $addresses = Contact::groupBy('emergencyaddress')
            ->select('emergencyaddress')
            ->get();

        $civilstatuses = Dropdown::where('type', 'civilstatus')->get();

        $currents = Address::groupBy('current')
            ->orderBy('current', 'asc')
            ->select('current')
            ->get();
        $permanents = Address::groupBy('permanent')
            ->orderBy('permanent', 'asc')
            ->select('permanent')
            ->get();

        $employmentstatuses = Dropdown::where('type', 'employmentstatus')
            ->get();

        $stations = Station::select('id', 'code', 'name', 'office_id')
            ->orderBy('code', 'asc')
            ->get();

        $person = $employee->person;

        return view('ou.station.employees.edit', compact('station', 'person', 'employmentstatuses', 'stations', 'sexes', 'extensions', 'relations', 'addresses', 'civilstatuses', 'currents', 'permanents'));
    }

    public function move(Station $station, Employee $employee)
    {
        $person = $employee->person;

        return view('ou.station.employees.show', compact('station', 'person'));
    }
}
