<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\Application;
use App\Models\Ranking;
use Illuminate\Support\Facades\Auth;

class RMSAssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        if(Auth::user()->isSuperAdmin())
            $vacancies = Vacancy::orderBy('status', 'desc')
                ->orderBy('vacancylevel', 'desc')
                ->orderBy('salarygrade', 'desc')
                ->get();
        else
            $vacancies = Vacancy::join('user_rankings', 'vacancies.id', '=', 'user_rankings.vacancy_id')
                ->where('user_rankings.user_id', '=', Auth::id())
                ->orderBy('status', 'desc')
                ->orderBy('vacancylevel', 'desc')
                ->orderBy('salarygrade', 'desc')
                ->select('vacancies.*')
                ->get();

        return view('rms.vacancies.index', compact('vacancies'));
    }

    public function show(Vacancy $vacancy, $filter)
    {
        $cycle = $vacancy->updated_at->year;
        $filter = ($filter == "All" ? "%" : $filter);

        $access = Vacancy::join('user_rankings', 'vacancies.id', '=', 'user_rankings.vacancy_id')
            ->where('user_rankings.user_id', '=', Auth::id())
            ->where('user_rankings.vacancy_id', '=', $vacancy->id)
            ->select('vacancies.*')
            ->get();
        
        if(sizeof($access) > 0 || Auth::user()->isSuperAdmin())  
            $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
                ->where('schoolyear', '=', $cycle)
                ->where('vacancy_id', '=', $vacancy->id)
                ->where('type', 'LIKE', $filter)
                ->orderBy('lastname', 'asc')
                ->orderBy('firstname', 'asc')
                ->select('applications.created_at AS submitted_at', 'people.*', 'applications.*')
                ->get();
        else
            abort(401, 'This action is unauthorized.');

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
            ->orderby('stations.name', 'asc')
            ->select('rankings.*')->get();

        return view('rms.vacancies.showranking', compact('vacancy', 'applications', 'rankings',  'cycle'));
    }
}
