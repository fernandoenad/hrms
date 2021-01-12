<?php

namespace App\Http\Controllers\Station;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;

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
        return view('station.index', compact('station'));
    }
}
