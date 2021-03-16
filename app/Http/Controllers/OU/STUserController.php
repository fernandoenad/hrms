<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use App\Models\UserST;
use App\Models\Station;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class STUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Station $station)
    {
        $usersts = UserST::where('station_id', '=', $station->id)
            ->get();

        return view('ou.station.users.index', compact('usersts', 'station'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Station $station)
    {
        return view('ou.station.users.create', compact('station'));
    }

    public function lookup(Station $station)
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
        ->paginate(15);

        $employees = $employees->appends(['searchString' => $searchString]);

        return view('ou.station.users.lookup', compact('station', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Station $station)
    {
        $data = request()->validate([
            'user_id' => ['required', Rule::unique('user_s_t_s')
                ->where('station_id', $station->id)
                ->where('user_id', request()->user_id)],
        ],
        [
            'user_id.unique' => 'The employee already has a role.',
            'user_id.required' => 'The employee field is required.',
        ]);

        UserST::create(array_merge($data, [
            'station_id' => $station->id,
        ]));

        return redirect()->route('ou.station.users', compact('station'))->with('status', 'User created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserST  $userST
     * @return \Illuminate\Http\Response
     */
    public function show(UserST $userST)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserST  $userST
     * @return \Illuminate\Http\Response
     */
    public function edit(UserST $userST)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserST  $userST
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserST $userST)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserST  $userST
     * @return \Illuminate\Http\Response
     */
    public function destroy(Station $station, $userST)
    {
        $userst = UserST::find($userST);
        $userst->delete();

        return redirect()->route('ou.station.users', compact('station'))->with('status', 'User removed!');
    }
}
