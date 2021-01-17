<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Station;

class PSController extends Controller
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
        $people = Person::all();
        $employees = Employee::all();
        $items = Item::where('status', '=', 1);
        
        $stations = Station::orderBy('name', 'asc')->paginate(15);
             
        return view('ps.index', compact('people', 'employees', 'items', 'stations'));
    }


    public function search()
    {
        $searchString = request()->get('searchString');

        $people = Person::all();
        $employees = Employee::all();
        $items = Item::where('status', '=', 1);

        $stations = Station::where('name', 'like', $searchString . '%')
            ->orWhere('code', '=', $searchString)
            ->orderBy('name', 'asc')
            ->paginate(15);

        $stations = $stations->appends(['searchString' => $searchString]);

        return view('ps.index', compact('people', 'employees', 'items', 'stations'));
    }

}