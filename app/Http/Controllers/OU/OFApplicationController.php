<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Station;
use App\Models\Vacancy;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;

class OFApplicationController extends Controller
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
    public function index(Office $office)
    {

        $cycles = Application::join('stations', 'applications.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->where('office_id', '=', $office->id)
            ->groupBy('schoolyear')
            ->orderBy('schoolyear', 'desc')
            ->select('schoolyear')
            ->get();

        return view('ou.office.applications.index', compact('cycles', 'office'));
    }


    public function showcycle(Office $office, $cycle)
    {
        $vacancies = Vacancy::join('applications', 'vacancies.id', '=', 'applications.vacancy_id')
            ->join('stations', 'applications.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->where('office_id', '=', $office->id)
            ->whereYear('vacancies.updated_at', '=', $cycle)
            ->orderBy('vacancylevel', 'desc')
            ->orderBy('salarygrade', 'desc')
            ->orderBy('vacancies.name', 'asc')
            ->select('vacancies.id')
            ->groupby('vacancies.id')
            ->get();

        return view('ou.office.applications.showcycle', compact('cycle', 'vacancies', 'office'));
    }

    public function showvacancy(Office $office, $cycle, Vacancy $vacancy)
    {
        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->join('stations', 'applications.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->where('office_id', '=', $office->id)
            ->where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('applications.created_at AS submitted_at', 'people.*', 'applications.*')
            ->get();

        return view('ou.office.applications.showvacancy', compact('cycle', 'vacancy', 'applications', 'office'));
    }

    public function uploadranklist(Office $office, $cycle, Vacancy $vacancy)
    {
        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
        ->join('stations', 'applications.station_id', '=', 'stations.id')
        ->join('offices', 'stations.office_id', '=', 'offices.id')
        ->where('office_id', '=', $office->id)
        ->where('schoolyear', '=', $cycle)
        ->where('vacancy_id', '=', $vacancy->id)
        ->orderBy('lastname', 'asc')
        ->orderBy('firstname', 'asc')
        ->select('applications.created_at AS submitted_at', 'people.*', 'applications.*')
        ->get();

        return view('ou.office.applications.showvacancy', compact('cycle', 'vacancy', 'applications', 'office'));
    }

    public function uploadedranklist(Office $office, $cycle, Vacancy $vacancy)
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

    public function show(Office $office, $cycle, Vacancy $vacancy, Application $application)
    {
        $applicationlogs = $application->applicationlog()
            ->orderBy('created_at', 'desc')->get();

        return view('ou.office.applications.show', compact('cycle', 'vacancy', 'application', 'applicationlogs', 'office'));
    }

    public function takeaction(Office $office, $cycle, Vacancy $vacancy, Application $application)
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

        return view('ou.office.applications.show', compact('cycle', 'vacancy', 'application', 'office'));
    }

    public function actiontaken(Office $office, $cycle, Vacancy $vacancy, Application $application)
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

        return redirect()->route('ou.office.applications.show', compact('cycle', 'vacancy', 'application', 'office'))->with('status', 'Application was updated.');
    }

    public function needsconfirmation(Office $office)
    {
        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->join('stations', 'applications.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->where('office_id', '=', $office->id)
            ->where('services', 'like', 'elementary')
            ->where('status', '=', 1)
            ->select('people.*', 'applications.*')->get();
            
        return view('ou.office.applications.needsconfirmation', compact('office', 'applications'));
    }
}


