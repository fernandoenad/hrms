<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\Application;
use App\Models\Dropdown;
use App\Models\Station;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        $person = Auth::user()->person;
        $applications = Application::where('person_id', '=', $person->id)
            ->orderBy('schoolyear', 'desc')->get();

        return view('rms.applications.index', compact('applications'));
    }

    public function apply(Vacancy $vacancy)
    {
        $person = Auth::user()->person;
        $cycle = date('Y', strtotime($vacancy->updated_at));

        $checkdupeapp = Application::join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
            ->where('schoolyear', '=', $cycle)
            ->where('person_id', '=', $person->id)
            ->where('curricularlevel', '=', $vacancy->curricularlevel)
            ->get();

        if(sizeof($checkdupeapp) > 0)
            return redirect('rms/p/vacancies')->with('error', 'You cannot apply two positions on the same level. Go to My Applications and withdraw your current application to proceed.');
        if($vacancy->status == 0)
            abort(404, 'Page not found.');
                
        $stations = Station::orderBy('name', 'asc')->select('id', 'name', 'code', 'office_id')->get();
        $applicationtypes = Dropdown::where('type', '=', 'applicationtype')->get();

        if($vacancy->level <3 )
            return view('rms.applications.apply', compact('cycle', 'vacancy', 'stations', 'applicationtypes'));
        else 
            return view('rms.applications.apply', compact('cycle', 'vacancy'));
    }

    public function store()
    {
        $person = Auth::user()->person;

        $data = request()->validate([
            'schoolyear' => ['required'], 
            'vacancy_id' =>['required', Rule::unique('applications')
                ->where('schoolyear', request()->schoolyear)
                ->where('vacancy_id', request()->vacancy_id)
                ->where('person_id', $person->id)],
            'station_id' => ['required'], 
            'type' => ['required'], 
            'remarks' => ['nullable', 'string'], 
            ],[
            'vacancy_id.unique' => 'You cannot apply twice on the same curricular level.',
            ]);

        if(request()->pertdoc_soft != '-'){
            $uploadedFile = request()->validate(['pertdoc_soft' => ['required', 'mimes:pdf'], ]);
            $filePath = $uploadedFile['pertdoc_soft']->store('docs', 'public');
        } else 
            $filePath = '-';

        $application = $person->application()->create(array_merge($data, [
            'code' => strtotime(now()),
            'pertdoc_soft' => $filePath,
            'pertdoc_hard' => 0,
            'status' => 1,
            ]));

        return redirect()->route('rms.application.show', compact('application'));
    }

    public function show(Application $application)
    {
        return view('rms.applications.show', compact('application'))->with('status', 'Application was submitted successfuly.');
    }

    public function destroy(Application $application)
    {
        if( $application->pertdoc_soft != '-')
            unlink("storage/" . $application->pertdoc_soft);
        $application->delete();

        return redirect()->route('rms.application')->with('status', 'Application was withdrawn sucessfully.');
    }
}
