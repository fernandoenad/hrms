<?php

namespace App\Http\Controllers\DPSU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DPSUController extends Controller
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
        
        return view('dpsu.index');
    }
}
