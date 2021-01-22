<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
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
        $user_roles = UserRole::where('route', '=', 'ps')
            ->orderBy('role_id', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $manager_count = $this->countRole(2)->count();
        $user_count = $this->countRole(3)->count();

        return view('ps.users.index', compact('user_roles', 'manager_count', 'user_count'));
    }

    public function countRole($role_id)
    {
        $count = UserRole::where('route', '=', 'ps')
            ->where('role_id', '=', $role_id)
            ->orderBy('role_id', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return $count;
    }

    public function create()
    {
        $userroles = UserRole::all();
        $employees = Employee::all();

        return view('ps.users.create', compact('userroles', 'employees'));
    }

    public function show(UserRole $userrole)
    {
        return view('ps.users.show', compact('userrole'));
    }

    public function store()
    {
        $data = request()->validate([
            'user_id' => ['required', Rule::unique('user_roles')
                ->where('route','ps')
                ->where('user_id', request()->user_id)],
            'role_id' => ['required'],
        ],
        [
            'user_id.unique' => 'The employee already has a role.',
            'role_id.required' => 'The role field is required.',
        ]);

        $userrole = UserRole::create(array_merge($data, [
            'route' => 'ps',
            'status' => 1,
        ]));

        return redirect()->route('ps.users.show', compact('userrole'))->with('status', 'User created!');
    }

    public function edit(UserRole $userrole)
    {
        return view('ps.users.edit', compact('userrole'));
    }   
    
    public function update(UserRole $userrole)
    {
        $data = request()->validate([
            'role_id' => ['required'],
        ]);

        $userrole->update($data);

        return redirect()->route('ps.users.show', compact('userrole'))->with('status', 'User updated!');
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

        return view('ps.users.lookup', compact('employees'));
    } 

    public function confirmDelete(UserRole $userrole)
    {
        return view('ps.users.show', compact('userrole'));
    }

    public function delete(UserRole $userrole)
    {
        $userrole->delete();

        return redirect()->route('ps.users')->with('status', 'User deleted!');
    }

    public function search()
    {
        $searchString = request()->get('searchString');

        $user_roles = UserRole::join('users', 'user_roles.user_id', '=', 'users.id')
            ->where('route', '=', 'ps')
            ->where(function ($query) use ($searchString){
                $query->where('name', 'like' , '%'. $searchString . '%');
            })
            ->orderBy('role_id', 'asc')
            ->orderBy('user_roles.id', 'asc')
            ->select('users.id as uid', 'users.*', 'user_roles.*')
            ->get();

        $manager_count = $this->countRole(2)->count();
        $user_count = $this->countRole(3)->count();

        return view('ps.users.index', compact('user_roles', 'manager_count', 'user_count'));
    }
}
