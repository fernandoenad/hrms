<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Station;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;

class STApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Station $station)
    {
        $cycles = Application::where('station_id', '=', $station->id)
            ->groupBy('schoolyear')
            ->orderBy('schoolyear', 'desc')
            ->select('schoolyear')
            ->get();

        return view('ou.station.applications.index', compact('cycles', 'station'));
    }


    public function showcycle(Station $station, $cycle)
    {
        $vacancies = Vacancy::join('applications', 'vacancies.id', '=', 'applications.vacancy_id')
            ->where('station_id', '=', $station->id)
            ->whereYear('vacancies.updated_at', '=', $cycle)
            ->where('vacancies.status', '=', 1)
            ->orderBy('vacancylevel', 'desc')
            ->orderBy('salarygrade', 'desc')
            ->orderBy('name', 'asc')
            ->select('vacancies.*')
            ->get();

        return view('ou.station.applications.showcycle', compact('cycle', 'vacancies', 'station'));
    }

    public function showvacancy(Station $station, $cycle, Vacancy $vacancy)
    {
        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->where('station_id', '=', $station->id)
            ->where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('applications.created_at AS submitted_at', 'people.*', 'applications.*')
            ->get();

        return view('ou.station.applications.showvacancy', compact('cycle', 'vacancy', 'applications', 'station'));
    }

    public function show(Station $station, $cycle, Vacancy $vacancy, Application $application)
    {
        $applicationlogs = $application->applicationlog()
            ->orderBy('created_at', 'desc')->get();

        return view('ou.station.applications.show', compact('cycle', 'vacancy', 'application', 'applicationlogs', 'station'));
    }

    public function takeaction(Station $station, $cycle, Vacancy $vacancy, Application $application)
    {
        if($application->status == 1){

            $application->update([
            'status' => 2,
            'remarks' => 'Checking...',
            ]); 
                
            $application->applicationlog()->create([
                'action' => 'Modify',
                'log' => $application->toJson(),
                'user_id' => Auth::user()->id,
            ]);
    
         }

        return view('ou.station.applications.show', compact('cycle', 'vacancy', 'application', 'station'));
    }

    public function actiontaken(Station $station, $cycle, Vacancy $vacancy, Application $application)
    {
        $data = request()->validate([
            'status' => ['required'],
            'remarks' => ['nullable', 'string', 'min:3', 'max:255'],
            ]);      

        $application->update($data);

        $application->applicationlog()->create([
            'action' => 'Modify',
            'log' => $application->toJson(),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('ou.station.applications.show', compact('cycle', 'vacancy', 'application', 'station'))->with('status', 'Application was updated.');
    }

    public function needsconfirmation(Station $station)
    {
        $applications = Application::where('station_id', '=', $station->id)
            ->where('status', '=', 1)->get();

        return view('ou.station.applications.needsconfirmation', compact('station', 'applications'));
    }
}


