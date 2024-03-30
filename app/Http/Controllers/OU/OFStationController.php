<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Office;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OFStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office)
    {
        $stations = Station::where('stations.office_id', '=', $office->id)
            ->orderby('services', 'asc')
            ->orderby('name', 'asc')->get();

        return view('ou.office.stations.index', compact('office', 'stations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office, Station $station)
    {
        $stations = Station::where('stations.office_id', '=', $office->id)
            ->orderby('services', 'asc')
            ->orderby('name', 'asc')->get();
            
        return view('ou.office.stations.index', compact('office', 'stations', 'station'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function update(Office $office, Station $station)
    {
        $data = request()->validate([
            'address' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\-\,\.]*$/'],
            'person_id' => ['required'],
        ]);

        $station->update($data);

        return redirect()->route('ou.office.stations', compact('office'))->with('status', 'Station updated!');
    }

    public function lookup(Office $office, Station $station)
    {
        $searchString = request()->get('searchString');

        $employees = Employee::join('people', 'employees.person_id', '=', 'people.id')
            ->where(function ($query) use ($searchString){
                $query->where('lastname', 'like' , $searchString . '%')
                    ->orWhere('firstname', 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $searchString . '%')
                    ->orderBy('lastname', 'asc')
                    ->orderBy('firstname', 'asc');
        })
        ->select('employees.id AS empid', 'employees.*', 'people.*')
        ->paginate(10);

        $employees = $employees->take(9); 
        
        $employees = $employees->append(['searchString' => $searchString]);

        return view('ou.office.stations.lookup', compact('office', 'station', 'employees'));
    } 
}
