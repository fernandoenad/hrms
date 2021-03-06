<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Vacancy;
use App\Models\Station;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
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
    public function index()
    {
        $cycles = Application::groupBy('schoolyear')
            ->orderBy('schoolyear', 'desc')
            ->select('schoolyear')
            ->get();

        return view('ps.rms.applications.index', compact('cycles'));
    }

    public function search()
    {
        $str = request()->get('str');

        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->where(function ($query) use ($str){
                $query->where('lastname', 'like' , $str . '%')
                    ->orWhere('firstname', 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $str . '%')
                    ->orderBy('lastname', 'asc')
                    ->orderBy('firstname', 'asc');
            })
            ->orWhere('code', '=', $str)
            ->select('applications.*')
            ->paginate(15);

        $applications = $applications->appends(['str' => $str]);

        $applications_new = Application::where('status', '=', 1)
            ->get()
            ->count();

        $applications_pending = Application::where('status', '=', 2)
            ->get()
            ->count();

        $applications_confirmed = Application::where('status', '=', 3)
            ->get()
            ->count();
        
        return view('ps.rms.index', compact('applications', 'applications_new', 'applications_pending', 'applications_confirmed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */

    public function takeaction($cycle, Vacancy $vacancy, Application $application)
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

        $stations = Station::orderBy('name', 'asc')->select('id', 'name', 'code', 'office_id')->get();

        return view('ps.rms.applications.show', compact('cycle', 'vacancy', 'application', 'stations'));
    }

    public function actiontaken($cycle, Vacancy $vacancy, Application $application)
    {
        $data = request()->validate([
            'station_id' => ['required'],
            'status' => ['required'],
            'remarks' => ['nullable', 'string', 'min:3', 'max:255'],
            ]);      

        $application->update($data);

        $application->applicationlog()->create([
            'action' => 'Modify',
            'log' => $application->toJson(),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('ps.rms.applications-show', compact('cycle', 'vacancy', 'application'))->with('status', 'Application was updated.');
    }

    public function show($cycle, Vacancy $vacancy, Application $application)
    {
        $applicationlogs = $application->applicationlog()
            ->orderBy('created_at', 'desc')->get();

        return view('ps.rms.applications.show', compact('cycle', 'vacancy', 'application', 'applicationlogs'));
    }

    public function showvacancy($cycle, Vacancy $vacancy)
    {
        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('applications.created_at AS submitted_at', 'people.*', 'applications.*')
            ->get();

        return view('ps.rms.applications.showvacancy', compact('cycle', 'vacancy', 'applications'));
    }

    public function showcycle($cycle)
    {
        $vacancies = Vacancy::whereYear('updated_at', '=', $cycle)
            ->orderBy('vacancylevel', 'desc')
            ->orderBy('salarygrade', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        return view('ps.rms.applications.showcycle', compact('cycle', 'vacancies'));
    }

    public function needsconfirmation()
    {
        $applications = Application::where('station_id', '=', 0)
        ->where('status', '=', 1)->get();

        return view('ps.rms.applications.needsconfirmation', compact('applications'));
    }

    public function showfilter($cycle, $filter, $page)
    {
        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->join('stations', 'applications.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->join('towns', 'offices.town_id', '=', 'towns.id')
            ->where('schoolyear', '=', $cycle)
            ->where('applications.type', '=', $filter)
            ->orderBy('cdlevel', 'asc')
            ->orderBy('vacancy_id', 'asc')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')            
            ->select('applications.*')->paginate($page);

        return view('ps.rms.applications.showfilter', compact('cycle', 'applications', 'filter'));
    }

    public function vacancyfilter($cycle, Vacancy $vacancy, $filter, $page)
    {
        $applications = Application::where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->where('type', '=', $filter)->get();
        
        $applications2 = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->join('stations', 'applications.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->join('towns', 'offices.town_id', '=', 'towns.id')
            ->where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->where('applications.type', '=', $filter)
            ->orderBy('cdlevel', 'asc')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('applications.*')->paginate($page);

        return view('ps.rms.applications.vacancyfilter', compact('cycle', 'vacancy', 'applications', 'applications2', 'filter'));
    }

    public function showranking($cycle, Vacancy $vacancy)
    {
        $applications = Application::where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)->get();

        $rankings = Ranking::join('stations', 'rankings.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->join('towns', 'offices.town_id', '=', 'towns.id')
            ->where('year', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->orderby('towns.cdlevel', 'asc')
            ->orderby('offices.name', 'asc')
            ->orderby('stations.name', 'asc')
            ->select('rankings.*')->get();
        
        return view('ps.rms.applications.showranking', compact('cycle', 'vacancy', 'applications', 'rankings'));
    }

    public function deleteranking($cycle, Vacancy $vacancy, Ranking $ranking)
    {
        $ranking->delete();

        return redirect()->route('ps.rms.applications-show-ranking', compact('cycle', 'vacancy'))->with('status', 'Ranking file deleted.');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
