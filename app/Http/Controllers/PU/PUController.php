<?php

namespace App\Http\Controllers\PU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Station;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class PUController extends Controller
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
        $offices = $this->getOffices()->get();
        $office = new Office();
        $stations = $this->getStations($office)->paginate(50);
        
        $district_count = $this->getOfficesByType('school')->count();  
        $office_count = $this->getOfficesByType('office')->count();  

        $school_count = $this->getStationsByType('school')->count();              
        $unit_count = $this->getStationsByType('office')->count();

        return view('pu.index', compact('offices', 'stations', 'district_count', 'school_count', 'office_count', 'unit_count'));
    }

    public function showOffice(Office $office)
    {
        $offices = $this->getOffices()->get();
        $stations = $this->getStations($office)->paginate(50);
        
        $district_count = $this->getOfficesByType('school')->count();  
        $office_count = $this->getOfficesByType('office')->count();  

        $school_count = $this->getStationsByType('school')->count();              
        $unit_count = $this->getStationsByType('office')->count();

        return view('pu.index', compact('offices', 'stations', 'district_count', 'school_count', 'office_count', 'unit_count'));     
    }

    public function getOffices()
    {
        $offices = Office::orderBy('name', 'asc');

        return $offices;
    }

    public function getOfficesByType($type)
    {
        $offices = DB::table('stations')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->where('stations.type', '=', $type)
            ->groupBy('off_id')
            ->select('offices.id AS off_id')->get();  

        return $offices;
    }

    public function getStations(Office $office)
    {
        $stations = Station::where('office_id', 'LIKE', $office->id)
            ->orderBy('services', 'asc')
            ->orderBy('name', 'asc');

        return $stations;
    }

    public function getStationsByType($type)
    {
        $stations = Station::where('type', '=', $type)    
            ->orderBy('name', 'asc');

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

}
