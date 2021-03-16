<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\UserOF;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OFUserController extends Controller
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
    public function index(Office $office)
    {
        $usersofs = UserOF::where('office_id', '=', $office->id)
            ->get();

        return view('ou.office.users.index', compact('usersofs', 'office'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Office $office)
    {
        return view('ou.office.users.create', compact('office'));
    }

    public function lookup(Office $office)
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

        return view('ou.office.users.lookup', compact('office', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Office $office)
    {
        $data = request()->validate([
            'user_id' => ['required', Rule::unique('user_o_f_s')
                ->where('office_id', $office->id)
                ->where('user_id', request()->user_id)],
        ],
        [
            'user_id.unique' => 'The employee already has a role.',
            'user_id.required' => 'The employee field is required.',
        ]);

        UserOF::create(array_merge($data, [
            'office_id' => $office->id,
        ]));

        return redirect()->route('ou.office.users', compact('office'))->with('status', 'User created!');
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
    public function destroy(Office $office, $userOF)
    {
        $userof = UserOF::find($userOF);
        $userof->delete();

        return redirect()->route('ou.office.users', compact('office'))->with('status', 'User removed!');
    }
}
