<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Application2;
use App\Models\Assessment;
use App\Models\Vacancy2;
use App\Models\Inquiry2;
use App\Models\Town;
use App\Models\Dropdown;
use Illuminate\Validation\Rule;
use Mail;
use App\Mail\UpdateMail;
//use PDF;

class STApplication2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index(Station $station)
    {
        $cycles = Vacancy2::groupBy('cycle')
            ->orderBy('cycle', 'desc')
            ->select('cycle')
            ->where('office_level', '=', -1)
            ->get();

        return view('ou.station.applications.index', ['cycles' => $cycles, 'station' => $station]);
    }

    public function showCycle(Station $station, $cycle)
    {
        $applications = Application2::join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
            ->where('station_id', '=', $station->id)
            ->where('cycle', '=', $cycle)
            ->groupBy('vacancy_id')
            ->select('vacancy_id')
            ->orderBy('vacancy_id', 'DESC')
            ->get();
        
        return view('ou.station.applications.showcycle', ['applications' => $applications, 'cycle' => $cycle, 'station' => $station]);
    }

    public function showVacancy(Station $station, $cycle, Vacancy2 $vacancy)
    {
        $applications = Application2::join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
            ->where('station_id', '=', $station->id)
            ->where('cycle', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->select('*', 'applications.id AS id')
            ->get();

        return view('ou.station.applications.showvacancy', ['vacancy' => $vacancy, 'applications' => $applications, 'cycle' => $cycle, 'station' => $station]);
    }

    public function takeIn(Station $station, $cycle)
    {
        $applications = Application2::join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
            ->where('station_id', '=', -1)
            ->where('cycle', '=', $cycle)
            ->select('*', 'applications.id AS id')
            ->limit(0)->get();

        return view('ou.station.applications.takein', ['applications' => $applications,'cycle' => $cycle, 'station' => $station]);
    }

    public function showResult(Request $request, Station $station, $cycle)
    {
        $data = $request->validate([
            'application_code' => 'required|string',
        ]);

        $applications = Application2::join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
            ->where('application_code', '=', $request->application_code)
            ->select('*', 'applications.id AS id')
            ->get();

        return view('ou.station.applications.takein', ['search' => $request->application_code, 'applications' => $applications, 'cycle' => $cycle, 'station' => $station]);
    }

    public function takeInOk(Request $request, Station $station, $cycle, Application2 $application)
    {
        $user = auth()->user();

        $application->update([
            'station_id' => $station->id,
            'last_user' => $user->name,
        ]);

        $vacancy = Vacancy2::find($application->vacancy_id);

        $data['application_id'] = $application->id;
        $data['author'] =  auth()->user()->name;
        $data['message'] = 'The application was taken-in at ' . $station->name . '.' ;
        $data['status'] = 0;

        $inquiry = Inquiry2::create($data);

        // email 
        $data['name'] =  $application->first_name;                
        $data['subject'] =  $application->application_code;
        $data['application'] = $application->application_code;
        Mail::to($application->email)->queue(new UpdateMail($data));

        return redirect(route('ou.station.applications.showvacancy', ['vacancy' => $vacancy, 'cycle' => $cycle, 'station' => $station]))->with('status', 'Application was successfully taken in.');
    }

    public function withdraw(Request $request, Station $station, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        $application->update(['station_id' => $vacancy->office_level]);

        if(isset($application->assessment))
            $application->assessment->delete();

        $data['application_id'] = $application->id;
        $data['author'] =  auth()->user()->name;
        $data['message'] = 'The application was withdrawn from ' . $station->name . '.';
        $data['status'] = 0;

        $inquiry = Inquiry2::create($data);

        // email 
        $data['name'] =  $application->first_name;                
        $data['subject'] =  $application->application_code;
        $data['application'] = $application->application_code;
        Mail::to($application->email)->queue(new UpdateMail($data));

        return redirect(route('ou.station.applications.showvacancy', ['vacancy' => $vacancy, 'cycle' => $cycle, 'station' => $station]))->with('status', 'Application was successfully withdrawn.');
    }

    public function show(Request $request, Station $station, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        return view('ou.station.applications.show', ['application' => $application, 'vacancy' => $vacancy, 'cycle' => $cycle, 'station' => $station]);
    }

    public function edit(Request $request, Station $station, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        $towns = Town::all();
        $sexes = Dropdown::where('type', '=', 'sex')->get();
        $civilstatuses = Dropdown::where('type', '=', 'civilstatus')->get();
        $vacancies = Vacancy2::all();

        return view('ou.station.applications.edit', ['vacancies' => $vacancies, 'towns' => $towns, 'sexes' => $sexes, 'civilstatuses' => $civilstatuses, 'application' => $application, 'vacancy' => $vacancy, 'cycle' => $cycle, 'station' => $station]);
    }

    public function update(Request $request, Station $station, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        $data = $request->validate([
            'first_name' => 'required|min:3|max:255',
            'middle_name' => 'required|min:1|max:255',
            'last_name' => 'required|min:2|max:255',
            'sitio' => 'required:min:1|max:255',
            'barangay' => 'required|min:3|max:255',
            'municipality' => 'required',
            'zip' => 'required|integer|between:6300,6400',
            'age' => 'required|integer|between:18,60',
            'gender' => 'required',
            'civil_status' => 'required',
            'religion' => 'required|min:1|max:255',
            'disability' => 'required|min:1|max:255',
            'ethnic_group' => 'required|min:1|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('mysql_2.applications')
                ->where(function ($query) use ($request, $vacancy) {
                    return $query->where('email', $request->email)
                    ->where('vacancy_id', $vacancy->id);
            })->ignore($application->id)],
            'phone' => 'required|min:11|max:12|regex:(^(09)\\d{9})',
        ], [
            'email.unique' => 'See error above!'
        ]);

        $application->update($data);

        $data['application_id'] = $application->id;
        $data['author'] =  auth()->user()->name;
        $data['message'] = 'The application details were updated.';
        $data['status'] = 0;

        $inquiry = Inquiry2::create($data);

        // email 
        $data['name'] =  $application->first_name;                
        $data['subject'] =  $application->application_code;
        $data['application'] = $application->application_code;
        Mail::to($application->email)->queue(new UpdateMail($data));

        return redirect(route('ou.station.applications.show', ['application' => $application, 'vacancy' => $vacancy, 'cycle' => $cycle, 'station' => $station]))->with('status', 'Application was successfully updated.');
    }

    public function carView(Station $station, $cycle, Vacancy2 $vacancy)
    {
        $assessments = Assessment::join('applications', 'applications.id', '=', 'assessments.application_id')
            ->where('applications.vacancy_id', '=', $vacancy->id)
            ->where('applications.station_id', '=', $station->id)
            ->select('assessments.*')
            ->get();

        return view('ou.station.applications.view', ['assessments' => $assessments, 'station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy]);
    }

    public function ierAView(Station $station, $cycle, Vacancy2 $vacancy)
    {
        $assessments = Assessment::join('applications', 'applications.id', '=', 'assessments.application_id')
            ->where('applications.vacancy_id', '=', $vacancy->id)
            ->where('applications.station_id', '=', $station->id)
            ->orderBy('applications.application_code', 'ASC')
            ->select('assessments.*')
            ->get();

        return view('ou.station.applications.iera', ['assessments' => $assessments, 'station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy]);
    }

    public function iesView(Station $station, $cycle, Vacancy2 $vacancy)
    {
        $assessments = Assessment::join('applications', 'applications.id', '=', 'assessments.application_id')
            ->where('applications.vacancy_id', '=', $vacancy->id)
            ->where('applications.station_id', '=', $station->id)
            ->where('assessments.status', '=', 2)
            ->orderBy('applications.application_code', 'ASC')
            ->select('assessments.*')
            ->get();

        if($vacancy->office_level == -1)
            return view('ou.station.applications.ies', ['assessments' => $assessments, 'station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy]);
        else 
            return view('ou.station.applications.iesnt', ['assessments' => $assessments, 'station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy]);
    }


    public function ierBView(Station $station, $cycle, Vacancy2 $vacancy)
    {
        $assessments = Assessment::join('applications', 'applications.id', '=', 'assessments.application_id')
            ->where('applications.vacancy_id', '=', $vacancy->id)
            ->where('applications.station_id', '=', $station->id)
            ->where('assessments.status', '=', 2)
            ->orderBy('applications.last_name', 'ASC')
            ->orderBy('applications.first_name', 'ASC')
            ->select('assessments.*')
            ->get();

        return view('ou.station.applications.ierb', ['assessments' => $assessments, 'station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy]);
    }

    public function pdf(Station $station, $cycle, Vacancy2 $vacancy)
    {
        $assessments = Assessment::all();

        $pdf = PDF::loadView('ou.station.applications.view', ['assessments' => $assessments]);

        return $pdf->download('pdf_file.pdf');
    }

    public function revert(Station $station, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        $application->assessment->delete();

        $data['application_id'] = $application->id;
        $data['author'] =  auth()->user()->name;
        $data['message'] = 'The application was reverted to New status.';
        $data['status'] = 0;

        $inquiry = Inquiry2::create($data);

        // email 
        $data['name'] =  $application->first_name;                
        $data['subject'] =  $application->application_code;
        $data['application'] = $application->application_code;
        Mail::to($application->email)->queue(new UpdateMail($data));

        return redirect(route('ou.station.applications.showvacancy', ['station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy]))->with('status', 'Request to revert to know has been sent.');
    }
}
