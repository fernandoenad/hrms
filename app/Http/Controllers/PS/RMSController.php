<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class RMSController extends Controller
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
        $applications = Application::orderBy('created_at', 'desc')
            ->paginate(15);

        $applications_new = Application::where('status', '=', 1)
            ->get()
            ->count();

        $applications_pending = Application::where('status', '=', 2)
            ->get()
            ->count();

        $applications_confirmed = Application::where('status', '=', 3)
            ->get()
            ->count();
        
        return view('ps.rms.index', compact('applications', 'applications_new', 'applications_pending', 'applications_confirmed'));
    }      
}
