<?php

namespace App\Http\Controllers\OU;

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
    public function index(Station $station)
    {

        if(!Auth::user()->isStationPersonnel($station->id)){
            if(Auth::user()->isSuperAdmin())
                return view('ou.station.index', compact('station'));
            else
                abort(401, 'Unauthorized access.');
        }

        return view('ou.station.index', compact('station'));
    }
}
