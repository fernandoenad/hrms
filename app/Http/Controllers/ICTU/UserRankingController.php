<?php

namespace App\Http\Controllers\ICTU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRanking;
use App\Models\Vacancy;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserRankingController extends Controller
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
    public function index()
    {
        $userrankings = UserRanking::join('users', 'users.id' , '=', 'user_id')
            ->orderBy('name', 'asc')
            ->select('user_rankings.*')
            ->get();

        return view('ictu.userrankings.index', compact('userrankings'));
    }

    public function create()
    {
        $vacancies = Vacancy::orderBy('salarygrade', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        return view('ictu.userrankings.create', compact('vacancies'));
    }

    public function store()
    {
        $data = request()->validate([
            'user_id' => ['required', Rule::unique('user_rankings')
                ->where('vacancy_id', request()->vacancy_id)
                ->where('user_id', request()->user_id)],
            'vacancy_id' => ['required'],
        ],
        [
            'user_id.unique' => 'The assessor already has a role for the assignment selected.',
            'user_id.required' => 'The assessor field is required.',
            'vacancy_id.required' => 'The assignment field is required.',
        ]);

        UserRanking::create(array_merge($data, [
            'user_id' => $data['user_id'],
            'vacancy_id' => $data['vacancy_id'],
        ]));

        return redirect()->route('ictu.userranking')->with('status', 'User created!');
    }

    public function destroy(UserRanking $userranking)
    {
        $userranking->delete();

        return redirect()->route('ictu.userranking')->with('status', 'User deleted!');
    }

    public function lookup()
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

        return view('ictu.userrankings.lookup', compact('employees'));
    }
}
