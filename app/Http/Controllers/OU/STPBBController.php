<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\PBBReport;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class STPBBController extends Controller
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
    public function index(Station $station, $year)
    {
        $pbblist = PBBReport::join('employees', 'p_b_b_reports.employee_id', '=', 'employees.id')
            ->join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->where('p_b_b_reports.station_id', '=', $station->id)
            ->where('p_b_b_reports.year', '=', $year)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('p_b_b_reports.*')
            ->get();
        //dd($pbblist->employee());

        return view('ou.station.pbb.index', compact('station', 'year', 'pbblist'));
    }

    public function search(Station $station, $year)
    {
        $str = request()->get('str');

        $pbblist = PBBReport::join('employees', 'p_b_b_reports.employee_id', '=', 'employees.id')
            ->join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->where('p_b_b_reports.station_id', '=', $station->id)
            ->where('p_b_b_reports.year', '=', $year)
            ->where(function ($query) use ($str){
                $query->where('lastname', 'like' , $str . '%')
                    ->orWhere('firstname', 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $str . '%');
                })
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('p_b_b_reports.*')
            ->paginate(1000);
        //dd($pbblist);
      
        $pbblist = $pbblist->appends(['str' => $str]);
       
        return view('ou.station.pbb.index', compact('station', 'year', 'pbblist'));
    }

    public function add(Station $station, $year)
    {
       
        return view('ou.station.pbb.add', compact('station', 'year'));
    }

    public function lookup(Station $station, $year)
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

        return view('ou.station.pbb.lookup', compact('employees', 'station', 'year'));
    } 

    public function store(Station $station, $year)
    {
        $employee = Employee::find(request()->employee_id);
        $station_name = $employee->pbbreport->last()->station->name  ?? '';

        $data = request()->validate([
            'station_id' => ['required'],
            'employee_id' => ['required', Rule::unique('p_b_b_reports')
                ->where('employee_id', request()->employee_id)
                ->where('station_id', request()->station_id)
                ->where('year', $year)],
            'empno' => ['required', 'string', 'min:3', 'max:7'],
            'length_of_service' => ['required', 'integer', 'min:1', 'max:12'],
            'salary_grade' => ['required', 'integer', 'min:1', 'max:26'],
            'step' => ['required', 'integer', 'min:1', 'max:8'],
            'ipcr_score' => ['required', 'numeric', 'min:1', 'max:5', 'regex:/^[0-9]+(\.[0-9][0-9][0-9]?)?$/'],
            'qualified' => ['required', 'string'],
            ],[
            'ipcr_score.regex' => 'IPCR score must have 3 decimal places.',
            'employee_id.unique' => 'Employee is already listed at ' . $station_name  . '.',
            ]);
        
        $data = array_merge($data, [
            'year' => $year,
            'status' => 2,
            'user_id' => Auth::user()->id,
            ]);
        // dd($data);

        PBBReport::create($data);

        return redirect()->route('ou.station.pbb', compact('station', 'year'))->with('status', 'A list item has been added.');
    } 

}
