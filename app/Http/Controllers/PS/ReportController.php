<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Employee;
use App\Models\Station;
use App\Models\Item;

class ReportController extends Controller
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
        $teachingemployees = Item::join('deployments', 'items.id', '=', 'deployments.item_id')
            ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
            ->where('employeetype', '=', 'Teaching')
            ->where('level', '!=', 'Non-school')
            ->groupBy('level')
            ->orderBy('level', 'asc')
            ->select('level')
            ->get();
    
        $nonteachingemployees = Item::join('deployments', 'items.id', '=', 'deployments.item_id')
            ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
            ->where('employeetype', '=', 'Non-Teaching')
            ->where('level', '!=', 'Non-school')
            ->groupBy('level')
            ->orderBy('level', 'asc')
            ->select('level')
            ->get();

        return view('ps.reports.index', compact('teachingemployees', 'nonteachingemployees'));
    }

    public function plantilla()
    {
        $offices = Office::orderBy('name', 'asc')->get();

        return view('ps.reports.plantilla', compact('offices'));
    }

    public function deployment()
    {
        $offices = Office::orderBy('name', 'asc')->get();

        return view('ps.reports.deployment', compact('offices'));
    }

    public static function getEmployeesOffice($office_id, $type)
    {
        if($type == 'plantilla')
            $employees = Employee::join('items', 'employees.item_id', '=', 'items.id')
                ->join('stations', 'items.station_id', '=', 'stations.id')
                ->join('offices', 'stations.office_id', '=', 'offices.id')
                ->where('offices.id', 'like', $office_id);
        
        if($type == 'deployment') 
            $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
                ->join('items', 'deployments.item_id', '=', 'items.id')
                ->join('stations', 'deployments.station_id', '=', 'stations.id')
                ->join('offices', 'stations.office_id', '=', 'offices.id')
                ->where('offices.id', 'like', $office_id);
        
                return $employees;
    }

    public static function getStations()
    {
        $stations = Station::join('offices', 'stations.office_id', '=', 'offices.id')->get();

        return $stations;
    }

    public static function  ploffice(Office $office)
    {
        $stations = Station::join('offices', 'stations.office_id', '=', 'offices.id')
            ->where('stations.office_id', '=', $office->id)
            ->select('offices.id AS o_id', 'offices.name AS o_name', 'offices.person_id AS o_person_id')
            ->select('stations.id AS s_id', 'stations.name AS s_name', 'stations.person_id AS s_person_id')
            ->select('offices.*', 'stations.*')
            ->orderBy('stations.services', 'asc')
            ->orderBy('stations.name', 'asc')->get();

        return view('ps.reports.ploffice', compact('office', 'stations'));
    }

    public static function  deoffice(Office $office)
    {
        $stations = Station::join('offices', 'stations.office_id', '=', 'offices.id')
            ->where('stations.office_id', '=', $office->id)
            ->select('offices.id AS o_id', 'offices.name AS o_name', 'offices.person_id AS o_person_id')
            ->select('stations.id AS s_id', 'stations.name AS s_name', 'stations.person_id AS s_person_id')
            ->select('offices.*', 'stations.*')
            ->orderBy('stations.services', 'asc')
            ->orderBy('stations.name', 'asc')->get();

        return view('ps.reports.deoffice', compact('office', 'stations'));
    }

    public static function getEmployeesStation($station_id, $type)
    {
        if($type == 'plantilla')
            $employees = Employee::join('items', 'employees.item_id', '=', 'items.id')
                ->join('stations', 'items.station_id', '=', 'stations.id')
                ->where('stations.id', 'like', $station_id);
        
        if($type == 'deployment') 
            $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
                ->join('items', 'deployments.item_id', '=', 'items.id')
                ->join('stations', 'deployments.station_id', '=', 'stations.id')
                ->where('stations.id', 'like', $station_id);
        
                return $employees;
    }

    public static function  plstation(Office $office, Station $station)
    {
        $employees = Employee::join('items', 'employees.item_id', '=', 'items.id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->where('items.station_id', '=', $station->id)
            ->orderByRaw('CONVERT(items.salarygrade, SIGNED) desc')
            ->orderBy('position', 'asc')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->get();

        return view('ps.reports.plstation', compact('office', 'station', 'employees'));
    }

    public static function  destation(Office $office, Station $station)
    {
        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('items', 'deployments.item_id', '=', 'items.id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->where('items.station_id', '=', $station->id)
            ->orderByRaw('CONVERT(items.salarygrade, SIGNED) desc')
            ->orderBy('position', 'asc')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->get();

        return view('ps.reports.destation', compact('office', 'station', 'employees'));
    }    

    public static function  fiscalcategory($fiscalcategory)
    {
        $stations = Station::where('fiscalcategory', 'like', $fiscalcategory)
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('ps.reports.schools', compact('fiscalcategory', 'stations'));
    }

    public static function  searchSchool($fiscalcategory)
    {
        $str = request()->searchString;

        $stations = Station::where('fiscalcategory', 'like', $fiscalcategory)
            ->where('name', 'like', $str . '%')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('ps.reports.schools', compact('fiscalcategory', 'stations'));
    }
}


