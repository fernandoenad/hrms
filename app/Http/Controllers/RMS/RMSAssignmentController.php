<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\Application;
use App\Models\Ranking;

class RMSAssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    
    public function index()
    {
        $vacancies = Vacancy::orderBy('status', 'desc')
            ->orderBy('vacancylevel', 'desc')
            ->orderBy('salarygrade', 'desc')
            ->get();

        return view('rms.vacancies.index', compact('vacancies'));
    }

    public function show(Vacancy $vacancy, $filter)
    {
        $cycle = $vacancy->updated_at->year;
        $filter = ($filter == "All" ? "%" : $filter);

        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->where('type', 'LIKE', $filter)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('applications.created_at AS submitted_at', 'people.*', 'applications.*')
            ->get();

        return view('rms.vacancies.show', compact('vacancy', 'applications', 'cycle'));
    }

    public function showRanking(Vacancy $vacancy, $filter)
    {
        $cycle = $vacancy->updated_at->year;
        $filter = ($filter == "All" ? "%" : $filter);
        
        $applications = Application::where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)->get();

        $rankings = Ranking::join('stations', 'rankings.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->join('towns', 'offices.town_id', '=', 'towns.id')
            ->where('year', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->where('towns.cdlevel', 'LIKE', $filter)
            ->orderby('towns.cdlevel', 'asc')
            ->orderby('offices.name', 'asc')
            ->orderby('stations.name', 'asc')
            ->select('rankings.*')->get();
        //dd($rankings);

        return view('rms.vacancies.showranking', compact('vacancy', 'applications', 'rankings',  'cycle'));
    }
}
