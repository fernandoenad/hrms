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
use Illuminate\Support\Facades\Storage;
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

        $checkdupeapp2 = Application::join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
            ->where('schoolyear', '=', $cycle)
            ->where('person_id', '=', $person->id)
            ->where('vacancies.id', '=', $vacancy->id)
            ->get();

        if(sizeof($checkdupeapp2) > 0)
            return redirect('rms/p/vacancies')->with('error', 'You cannot apply the same position twice. Go to My Applications and withdraw your current application to proceed.');
        if((sizeof($checkdupeapp) > 0 && $vacancy->vacancylevel < 3))
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
            'pertdoc_soft' => ['required', 'mimes:pdf', 'max:45000'],
            ],[
            'vacancy_id.unique' => 'You cannot apply twice on the same curricular level.',
            'pertdoc_soft.required' => 'The pertinent document field is required.',
            'pertdoc_soft.mimes' => 'The pertinent document field should be in a pdf format.',
            'pertdoc_soft.max' => 'The pertinent document field should be less than 45000 Kilobytes.'
            ]);

        $ext = request()->file('pertdoc_soft')->extension();
        $path = Storage::putFile('public/docs', request()->file('pertdoc_soft'));
        $path = str_replace('public', '', $path);

        $application = $person->application()->create(array_merge($data, [
            'code' => strtotime(now()),
            'pertdoc_soft' => $path,
            'pertdoc_hard' => 0,
            'status' => 1,
            ]));
        
        $application->applicationlog()->create([
            'action' => 'Create',
            'log' => $application->toJson(),
            'user_id' => Auth::user()->id,
        ]);
        
        return redirect()->route('rms.application.show', compact('application'));
    }

    public function show(Application $application)
    {
        $person = Auth::user()->person;

        if($application->person_id != $person->id)
            abort(401, 'Unauthorized Access');

        $applicationlogs = $application->applicationlog()
            ->orderBy('application_logs.created_at', 'desc')->get();

        return view('rms.applications.show', compact('application', 'applicationlogs'))->with('status', 'Application was submitted successfuly.');
    }

    public function destroy(Application $application)
    {
        $person = Auth::user()->person;

        if($application->person_id != $person->id)
            abort(401, 'Unauthorized Access');

        if( $application->pertdoc_soft != '-')
            unlink("storage/" . $application->pertdoc_soft);
        $application->delete();

        return redirect()->route('rms.application')->with('status', 'Application was withdrawn sucessfully.');
    }

    public function editdoc(Application $application)
    {
        $person = Auth::user()->person;

        if($application->person_id != $person->id)
            abort(401, 'Unauthorized Access');

        $applicationlogs = $application->applicationlog()
            ->orderBy('created_at', 'desc')->get();

        return view('rms.applications.show', compact('application', 'applicationlogs'));
    }

    public function updatedoc(Application $application)
    {
        $person = Auth::user()->person;

        if($application->person_id != $person->id)
            abort(401, 'Unauthorized Access');

        $data = request()->validate([
            'pertdoc_soft' => ['required', 'mimes:pdf', 'max:45000'],
            ],[
            'pertdoc_soft.required' => 'The pertinent document field is required.',
            'pertdoc_soft.mimes' => 'The pertinent document field should be in a pdf format.',
            'pertdoc_soft.max' => 'The pertinent document field should be less than 45000 Kilobytes.'
            ]);

        $ext = request()->file('pertdoc_soft')->extension();
        $path = Storage::putFile('public/docs', request()->file('pertdoc_soft'));
        $path = str_replace('public', '', $path);

        $application->applicationlog()->create([
            'action' => 'Update',
            'log' => $application->toJson(),
            'user_id' => Auth::user()->id,
        ]);

        $application->update(array_merge($data,[
            'pertdoc_soft' => $path,
            'remarks' => 'Updated document',
        ]));
              
        return redirect()->route('rms.application.show', compact('application'));
    }
}
