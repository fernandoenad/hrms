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
        $page = 'announcements';
        
        if (Auth::check()) {
            return view('rms.dashboard.dashboard', compact('page'));
        } else {
            return view('rms.dashboard.index', compact('page'));
        }      
    }

    public function show($page)
    {
        if (Auth::check()) {
            return view('rms.dashboard.dashboard', compact('page'));
        } else {
            return view('rms.dashboard.index', compact('page'));
        }             
    }

}
