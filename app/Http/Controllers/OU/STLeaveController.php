<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Employee;

class STLeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Station $station)
    {
        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->where('station_id', '=', $station->id)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);

        return view('ou.station.leaves.index', compact('station', 'employees'));
    }
}
