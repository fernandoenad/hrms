<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Station;
use App\Models\Vacancy;
use App\Models\Ranking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            ->orderBy('vacancylevel', 'desc')
            ->orderBy('salarygrade', 'desc')
            ->orderBy('name', 'asc')
            ->select('vacancies.id')
            ->groupby('vacancies.id')
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

    public function uploadranklist(Station $station, $cycle, Vacancy $vacancy)
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

    public function uploadedranklist(Station $station, $cycle, Vacancy $vacancy)
    {
        $data = request()->validate([
            'year' => ['required'], 
            'attachment' => ['required', 'mimes:pdf', 'max:20000'],
            ],[
            'attachment.required' => 'The ranklist document field is required.',
            'attachment.mimes' => 'The ranklist document field should be in a pdf format.',
            'attachment.max' => 'The ranklist document field should be less than 20000 Kilobytes.'
            ]);

        $ext = request()->file('attachment')->extension();
        $path = Storage::putFile('public/docs', request()->file('attachment'));
        $path = str_replace('public', '', $path);

        $application = Ranking::create(array_merge($data, [
            'vacancy_id' => $vacancy->id,
            'station_id' => $station->id,
            'attachment' => $path,
            ]));

        return redirect()->route('ou.station.applications.showvacancy', compact('cycle', 'vacancy', 'station'))->with('status', 'Ranklist was uploaded successfully.');
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


