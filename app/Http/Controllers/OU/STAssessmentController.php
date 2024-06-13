<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Station;
use App\Models\Application2;
use App\Models\Vacancy2;
use App\Models\Template;
use PDF;

class STAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index(Station $station, $cycle, Vacancy2 $vacancy, Application2 $application)
    {
        $template = Template::find($vacancy->template_id);
        $assessment = Assessment::join('applications', 'applications.id', '=', 'assessments.application_id')
            ->join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
            ->where('applications.vacancy_id', '=', $application->vacancy_id)
            ->where('applications.station_id', '=', $station->id)
            ->where('applications.id', '=', $application->id)
            ->select('assessments.*')
            ->get();

        if($assessment->count() == 0){
            $criteria = json_decode($template->template, true);
            $asessment_details = $criteria;

            foreach ($asessment_details as $key => $value) {
                $asessment_details[$key] = is_numeric($asessment_details[$key]) ? 0 : '-';
            }

            $newAssessment = Assessment::create(['application_id' => $application->id,
                'template_id' => $vacancy->template_id,
                'assessment' => json_encode($asessment_details),
                'status' => 2,
            ]);
            $assessment = $newAssessment;
        } else {
            $assessment = $assessment->first();
        }

        return view('ou.station.applications.assess', ['station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy, 'application' => $application, 'assessment' => $assessment, 'template' => $template]);
    }

    public function update(Request $request, Station $station, $cycle, Vacancy2 $vacancy, Application2 $application, Assessment $assessment)
    {
        $template = Template::find($vacancy->template_id);
        $criteria = json_decode($template->template, true);
        $template_details = $criteria;
        $keys = array_keys($template_details);

        $formData = $request->all();
        $filteredFormData = array_intersect_key($formData, array_flip($keys));

        $assessment->update(['assessment' => json_encode($filteredFormData)]); 
        
        return redirect(route('ou.station.applications.assess.index', ['station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy, 'application' => $application]))->with('status', 'Assessment was successfully updated.');

    }

    public function markComplete(Request $request, Station $station, $cycle, Vacancy2 $vacancy, Application2 $application, Assessment $assessment)
    {
        $assessment->update(['status' => 2]); 
        
        return redirect(route('ou.station.applications.assess.index', ['station' => $station, 'cycle' => $cycle, 'vacancy' => $vacancy, 'application' => $application]))->with('status', 'Assessment was successfully marked completed.');

    }


}
