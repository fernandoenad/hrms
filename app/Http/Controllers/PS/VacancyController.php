<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use App\Models\Dropdown;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VacancyController extends Controller
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
        $vacancies = Vacancy::orderBy('status', 'desc')
            ->orderBy('vacancylevel', 'desc')
            ->orderBy('salarygrade', 'desc')
            ->get();

        return view('ps.rms.vacancies.index', compact('vacancies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $names = Vacancy::groupBy('name')
            ->select('name')
            ->orderBy('name', 'asc')->get();
        
        $vacancylevels = Dropdown::where('type', '=', 'vacancylevel')->get(); 

        $itemlevels = Dropdown::where('type', '=', 'itemlevel')->get();

        return view('ps.rms.vacancies.create', compact('names', 'vacancylevels', 'itemlevels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:vacancies'],
            'salarygrade' => ['required'],
            'vacancylevel' => ['required'],
            'curricularlevel' => ['required'],
            'qualifications' => ['required', 'min:3'],
            'vacancy' => ['required'],
            'status' => ['nullable'],
            ]);

        $vacancy = Vacancy::create(array_merge($data, [
            'status' => (!isset($data['status']) || $data['status'] === null ? 0 : 1),
        ]));

        return redirect()->route('ps.rms.vacancies-show', compact('vacancy'))->with('status', 'Vacancy creation was successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function show(Vacancy $vacancy)
    {
        return view('ps.rms.vacancies.show', compact('vacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacancy $vacancy)
    {
        $names = Vacancy::groupBy('name')
            ->select('name')
            ->orderBy('name', 'asc')->get();
        
        $vacancylevels = Dropdown::where('type', '=', 'vacancylevel')->get(); 

        $itemlevels = Dropdown::where('type', '=', 'itemlevel')->get();

        return view('ps.rms.vacancies.edit', compact('vacancy', 'names', 'vacancylevels', 'itemlevels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function update(Vacancy $vacancy)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('vacancies')->ignore($vacancy->id)],
            'salarygrade' => ['required'],
            'vacancylevel' => ['required'],
            'curricularlevel' => ['required'],
            'qualifications' => ['required', 'min:3'],
            'vacancy' => ['required'],
            'status' => ['nullable'],
            ]);

        $vacancy->update(array_merge($data, [
            'status' => (!isset($data['status']) || $data['status'] === null ? 0 : 1),
        ]));

        return redirect()->route('ps.rms.vacancies-show', compact('vacancy'))->with('status', 'Vacancy modification was successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacancy $vacancy)
    {
        //
    }
}
