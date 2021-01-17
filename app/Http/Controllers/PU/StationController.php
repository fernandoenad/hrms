<?php

namespace App\Http\Controllers\PU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Station;
use App\Models\Employee;
use App\Models\Dropdown;
use App\Models\Person;
use Illuminate\Validation\Rule;

class StationController extends Controller
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
        $office = new Office();
        $stations = $this->getStations($office)->paginate(15);

        return view('pu.stations.index', compact('stations'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $stations = Station::where('stations.name', 'like' , $searchString . '%')
            ->orWhere('code', '=' , $searchString)
            ->orderBy('name', 'asc')
            ->paginate(15);
        
        $stations = $stations->appends(['searchString' => $searchString]);

        return view('pu.stations.index', compact('stations'));
    }

    public function create()
    {
        $office = new Office();
        $stations = $this->getStations($office)->paginate(50);

        $stationtypes = Dropdown::where('type', '=', 'stationtype')->get();
        $stationcategories = Dropdown::where('type', '=', 'stationcategory')->get();
        $offices = Office::orderBy('name', 'asc')
            ->select('id', 'name')->get();
        $people = Person::orderBy('firstname', 'asc')
            ->orderBy('lastname', 'asc')
            ->select('id', 'firstname', 'lastname', 'extname')->get();
        $services = Station::orderBy('services', 'asc')
            ->groupBy('services')
            ->select('services')->get();

        return view('pu.stations.index', compact('stations', 'stationtypes', 'stationcategories', 'offices', 'people', 'services'));
    }

    public function store()
    {
        $office = new Office();
        $stations = $this->getStations($office)->paginate(50);

        $data = request()->validate([
            'type' => ['required'],
            'code' => ['required', 'string', 'min:3', 'max:12', 'regex:/^[0-9]*$/', 'unique:stations'],
            'name' => ['required', 'string', 'min:6', 'max:255', 'regex:/^[a-zA-Z\s\-\.]*$/'],
            'services' => ['required', 'string', 'min:6', 'max:255', 'regex:/^[a-zA-Z\s\-\,]*$/'],
            'category' => ['required'],
            'office_id' => ['required'],
            'address' => ['required', 'string', 'min:6', 'max:255', 'regex:/^[a-zA-Z\s\-\,\.]*$/'],
            'person_id' => ['required'],
        ]);

        Station::create($data);

        return redirect()->route('pu.stations', compact('stations'))->with('status', 'Station created!');
    }

    public function getStations(Office $office)
    {
        $stations = app('App\Http\Controllers\PU\PUController')->getStations($office);

        return $stations;
    }

    public static function getEmployees($station_id, $employeetype)
    {
        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('items', 'deployments.item_id', '=', 'items.id')
            ->where('deployments.station_id', '=', $station_id)
            ->where('items.employeetype', 'LIKE', $employeetype);

        return $employees;
    }

    public function delete(Station $station)
    {
        $office = new Office();
        $stations = $this->getStations($office)->paginate(15);

        $station->delete();

        return redirect()->route('pu.stations', compact('stations'))->with('status', 'Station deleted!');        
    }

    public function edit(Station $station)
    {
        $office = new Office();
        $stations = $this->getStations($office)->paginate(50);

        $stationtypes = Dropdown::where('type', '=', 'stationtype')->get();
        $stationcategories = Dropdown::where('type', '=', 'stationcategory')->get();
        $offices = Office::orderBy('name', 'asc')
            ->select('id', 'name')->get();
        $people = Person::orderBy('firstname', 'asc')
            ->orderBy('lastname', 'asc')
            ->select('id', 'firstname', 'lastname', 'extname')->get();
        $services = Station::orderBy('services', 'asc')
            ->groupBy('services')
            ->select('services')->get();

        return view('pu.stations.index', compact('stations', 'stationtypes', 'stationcategories', 'offices', 'people', 'services', 'station'));
    }

    public function update(Station $station)
    {
        $office = new Office();
        $stations = $this->getStations($office)->paginate(50);

        $data = request()->validate([
            'type' => ['required'],
            'code' => ['required', 'string', 'min:3', 'max:12', 'regex:/^[0-9]*$/', Rule::unique('stations')->ignore($station->id)],
            'name' => ['required', 'string', 'min:6', 'max:255', 'regex:/^[a-zA-Z\s\-\.]*$/'],
            'services' => ['required', 'string', 'min:6', 'max:255', 'regex:/^[a-zA-Z\s\-\,]*$/'],
            'category' => ['required'],
            'office_id' => ['required'],
            'address' => ['required', 'string', 'min:6', 'max:255', 'regex:/^[a-zA-Z\s\-\,\.]*$/'],
            'person_id' => ['required'],
        ]);

        $station->update($data);

        return redirect()->route('pu.stations', compact('stations'))->with('status', 'Station updated!');
    }
    
}
