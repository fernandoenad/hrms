<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\Application;
use App\Models\Dropdown;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        $curr_term = Term::where('status', '=', 1)->first()->year;
        $curr_applications = Application::where('schoolyear', '=', $curr_term)->get();
        $prev_applications = Application::where('schoolyear', '!=', $curr_term)->get();

        return view('rms.applications.index', compact('curr_term', 'curr_applications', 'prev_applications'));
    }

    public function create($term)
    {
        $positions = Dropdown::where('type', '=', 'position')->orderBy('details', 'asc')->get();
        $specializations = Dropdown::where('type', '=', 'specialization')->orderBy('details', 'asc')->get();
        $itemlevels = Dropdown::where('type', '=', 'itemlevel')->orderBy('id', 'asc')->get();
        $applicationtypes = Dropdown::where('type', '=', 'applicationtype')->orderBy('id', 'asc')->get();
        $stations = Station::orderBy('name', 'asc')->select('id', 'name', 'code', 'office_id')->get();

        return view('rms.applications.apply', compact('term', 'positions', 'specializations', 'itemlevels', 'stations', 'applicationtypes'));
    }

    public function store()
    {
        $person = Auth::user()->person;

        $data = request()->validate([
            'schoolyear' => ['required'], 
            'position' => ['required'], 
            'major' => ['required'], 
            'level' => ['required', Rule::unique('applications')
                ->where('schoolyear', request()->schoolyear)
                ->where('level', request()->level)
                ->where('person_id', $person->id)], 
            'type' => ['required'], 
            'station_id' => ['required'], 
            ],[
            'major.required' => 'The specialization field is required.',
            'level.unique' => 'You cannot apply twice on the same level.',
            ]);

        $application = $person->application()->create(array_merge($data, [
            'code' => strtotime(now()),
            'status' => 1,
            ]));

        return redirect()->route('rms.application.show', compact('application'));
    }

    public function show(Application $application)
    {
        $curr_term = Term::where('status', '=', 1)->first()->year;
        return view('rms.applications.show', compact('application'))->with('status', 'Application was submitted successfuly.');
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return redirect()->route('rms.application')->with('status', 'Application was withdrawn sucessfully.');
    }
}
