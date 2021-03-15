<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\UserST;
use Illuminate\Support\Facades\Auth;

class OUController extends Controller
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
        return view('ou.index');
    }

    public function station()
    {
        $station = Auth::user()->getStations()->first();
        $station2 = Auth::user()->getStationsUser()->first();

        if(!isset($station) && !isset($station2))
            abort(401, 'Unauthorized accesss');

        $station = isset($station) ? $station : $station2;

        return redirect()->route('ou.station.show', compact('station'));
    }
}
