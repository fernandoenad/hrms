<?php

namespace App\Http\Controllers\PU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Station;
use App\Models\Employee;
use App\Models\Town;
use App\Models\Dropdown;
use Illuminate\Validation\Rule;

class TownController extends Controller
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
        $towns = Town::orderBy('name', 'asc')->get();

        return view('pu.towns.index', compact('towns'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $towns = Town::where('name', 'like' , $searchString . '%')
            ->orderBy('name', 'asc')
            ->get();
        
        return view('pu.towns.index', compact('towns'));
    }

    public static function getEmployees($town_id, $employeetype)
    {
        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('items', 'deployments.item_id', '=', 'items.id')
            ->join('stations', 'deployments.station_id', '=', 'stations.id')
            ->join('offices', 'stations.office_id', '=', 'offices.id')
            ->join('towns', 'offices.town_id', '=', 'towns.id')
            ->where('towns.id', '=', $town_id)
            ->where('items.employeetype', 'LIKE', $employeetype);

        return $employees;
    }

    public function create()
    {
        $towns = Town::get();

        $cdlevels = Dropdown::where('type', 'towncdlevel')->get();

        return view('pu.towns.index', compact('towns', 'cdlevels'));
    }

    public function store()
    {
        $towns = Town::get();

        $data = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\-\.]*$/','unique:towns'],
            'cdlevel' => ['required'],
        ]);

        $town = Town::create($data);

        return redirect()->route('pu.towns.edit', compact('towns', 'town'))->with('status', 'Town created!');
    }

    public function delete(Town $town)
    {
        $towns = Town::get(); 

        $town->delete();

        return redirect()->route('pu.towns', compact('towns'))->with('status', 'Town deleted!');
    }

    public function edit(Town $town)
    {
        $towns = Town::get();

        $cdlevels = Dropdown::where('type', 'towncdlevel')->get();

        return view('pu.towns.index', compact('towns', 'town', 'cdlevels'));
    }

    public function update(Town $town)
    {
        $towns = Town::get();

        $cdlevels = Dropdown::where('type', 'towncdlevel')->get();

        $data = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\-\.]*$/', Rule::unique('towns')->ignore($town->id)],
            'cdlevel' => ['required'],
        ]);

        $town->update($data);

        return redirect()->route('pu.towns.edit', compact('towns', 'town', 'cdlevels'))->with('status', 'Town updated!');
    }
}
