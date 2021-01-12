<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Employee;
use App\Models\Item;

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
        $items = Item::all();

        return view('ps.index', compact('people', 'employees', 'items'));
    }

}
