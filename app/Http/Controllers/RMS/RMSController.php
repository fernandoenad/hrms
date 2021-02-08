<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vacancy;

class RMSController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        $page = 'dashboard';
        $vacancies = Vacancy::where('status', '=', 1)
            ->orderBy('salarygrade', 'desc')
            ->get();

        if (Auth::check()) {
            return view('rms.dashboard.dashboard', compact('page', 'vacancies'));
        } else {
            return view('rms.dashboard.index', compact('page', 'vacancies'));
        }      
    }

    public function show($page)
    {
        $vacancies = Vacancy::where('status', '=', 1)
            ->orderBy('salarygrade', 'desc')
            ->get();

        if (Auth::check()) {
            return view('rms.dashboard.dashboard', compact('page', 'vacancies'));
        } else {
            return view('rms.dashboard.index', compact('page', 'vacancies'));
        }             
    }
}
