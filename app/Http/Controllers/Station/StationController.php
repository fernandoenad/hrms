<?php

namespace App\Http\Controllers\Station;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;

class StationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $station = Auth::user()->getStation();

        return view('station.index', compact('station'));
    }

    public function show(Station $station)
    {
        $stations = Auth::user()->person->employee->item->deployment->all();
        
        return view('station.show', compact('station', 'stations'));
    }
}
