<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\Application;

class RMSAssignmentController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::orderBy('status', 'desc')
            ->orderBy('vacancylevel', 'desc')
            ->orderBy('salarygrade', 'desc')
            ->get();

        return view('rms.vacancies.index', compact('vacancies'));
    }

    public function show(Vacancy $vacancy)
    {
        $cycle = $vacancy->updated_at->year;

        $applications = Application::join('people', 'applications.person_id', '=', 'people.id')
            ->where('schoolyear', '=', $cycle)
            ->where('vacancy_id', '=', $vacancy->id)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('applications.created_at AS submitted_at', 'people.*', 'applications.*')
            ->get();

        return view('rms.vacancies.show', compact('vacancy', 'applications', 'cycle'));
    }
}
