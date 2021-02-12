<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;

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
    public function show($cycle, Vacancy $vacancy, Application $application)
    {
        return view('ps.rms.applications.show', compact('cycle', 'vacancy', 'application'));
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
            ->where('status', '=', 1)
            ->orderBy('vacancylevel', 'desc')
            ->orderBy('salarygrade', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        return view('ps.rms.applications.showcycle', compact('cycle', 'vacancies'));
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
