<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Application2;
use App\Models\Assessment;
use App\Models\Vacancy2;
use App\Models\Town;
use App\Models\Dropdown;
use App\Models\Office;
use App\Models\Template;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

//use PDF;

class OFApplication2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index(Office $office)
    {
        $cycle = Vacancy2::groupBy('cycle')
            ->orderBy('cycle', 'desc')
            ->select('cycle')
            ->where('office_level', '=', -1)
            ->first();
        
        $vacancies = Vacancy2::where('office_level', '=', -1)
            ->where('cycle', '=', $cycle->cycle)
            ->get();
        
        return view('ou.office.applications.index', ['vacancies' => $vacancies, 'cycle' => $cycle->cycle, 'office' => $office]);
    }

    public function show(Office $office, $cycle, Vacancy2 $vacancy)
    {
        $applications = DB::connection('mysql_2')->table('assessments')
            ->join('applications', 'assessments.application_id', '=', 'applications.id')
            ->join('hrms.stations', 'applications.station_id', '=', 'stations.id')
            ->where('stations.office_id', '=', $office->id)
            ->where('applications.vacancy_id', '=', $vacancy->id)
            ->where('assessments.status', '>=', 2)
            ->select('stations.name', 'stations.code', 'assessments.*', 'applications.*')
            ->get();

        return view('ou.office.applications.show', ['applications' => $applications,'vacancy' => $vacancy, 'cycle' => $cycle, 'office' => $office]);
    }

    public function carview(Office $office, $cycle, Vacancy2 $vacancy)
    {
        $assessments = DB::connection('mysql_2')->table('assessments')
            ->join('applications', 'assessments.application_id', '=', 'applications.id')
            ->join('hrms.stations', 'applications.station_id', '=', 'stations.id')
            ->where('stations.office_id', '=', $office->id)
            ->where('applications.vacancy_id', '=', $vacancy->id)
            ->where('assessments.status', '>=', 2)
            ->select('stations.name', 'stations.code', 'assessments.*', 'applications.*')
            ->get();

            return view('ou.office.applications.carview', ['assessments' => $assessments,'vacancy' => $vacancy, 'cycle' => $cycle, 'office' => $office]);
        }

    public function assess(Office $office, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        return view('ou.office.applications.assess', ['application' => $application, 'vacancy' => $vacancy, 'cycle' => $cycle, 'office' => $office]);
    }

    public function update(Request $request, Office $office, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        $template = Template::find($vacancy->template_id);
        $criteria = json_decode($template->template, true);
        $template_details = $criteria;
        $keys = array_keys($template_details);

        $formData = $request->all();
        $filteredFormData = array_intersect_key($formData, array_flip($keys));

        $assessment = Assessment::where('application_id', '=', $application->id)->first();

        $assessment->update(['assessment' => json_encode($filteredFormData)]); 

        return redirect(route('ou.office.applications.assess', ['application' => $application, 'vacancy' => $vacancy, 'cycle' => $cycle, 'office' => $office]))->with('status', 'Application was successfully updated.');
    }

    public function mark(Request $request, Office $office, $cycle, Vacancy2 $vacancy, Application2 $application, $score)
    {
        $assessment = Assessment::where('application_id', '=', $application->id)->first();

        $assessment->update(['status' => 3, 'score' => $score]); 

        return redirect(route('ou.office.applications.assess', ['application' => $application, 'vacancy' => $vacancy, 'cycle' => $cycle, 'office' => $office]))->with('status', 'Application was successfully marked completed.');
    }

    public function unmark(Request $request, Office $office, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        $assessment = Assessment::where('application_id', '=', $application->id)->first();

        $assessment->update(['status' => 2]); 

        return redirect(route('ou.office.applications.show', ['application' => $application, 'vacancy' => $vacancy, 'cycle' => $cycle, 'office' => $office]))->with('status', 'Application was successfully reverted to the PENDING status.');
    }

    public function umIndex(Office $office, $cycle)
    {
        $applications = DB::connection('mysql_2')->table('applications')
            ->join('hrms.stations', 'applications.station_id', '=', 'stations.id')
            ->select('applications.*', 'stations.name')
            ->where('stations.office_id', '=', $office->id)
            ->orderBy('applications.station_id', 'ASC')
            ->get();

        return view('ou.office.applications.umindex', ['applications' => $applications, 'cycle' => $cycle, 'office' => $office]);
    }

    public function umLookup(Request $request, Office $office, $cycle)
    {
        $applications = DB::connection('mysql_2')->table('applications')
            ->join('hrms.stations', 'applications.station_id', '=', 'stations.id')
            ->select('applications.*', 'stations.name')
            ->where('stations.office_id', '=', $office->id)
            ->where('last_name', 'like', '%'.$request->searchString.'%')
            ->get();

        return view('ou.office.applications.umindex', ['searchString' => $request->searchString, 'applications' => $applications, 'cycle' => $cycle, 'office' => $office ]);       
    }

    public function umProcess(Office $office, $cycle, Application2 $application)
    {
        $assessment = Assessment::where('application_id', '=', $application->id)->first();
        $assessment->update(['status' => 1]);

        return redirect(route('ou.office.applications.umindex', ['cycle' => $cycle, 'office' => $office]))->with('status', 'Application was successfully reverted to the Pending status.');
    }
}
