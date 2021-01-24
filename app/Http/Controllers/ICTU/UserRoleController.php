<?php

namespace App\Http\Controllers\ICTU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\UserRole;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserRoleController extends Controller
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
        $user_roles = UserRole::orderBy('role_id', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $manager_count = $this->countRole(2)->count() + $this->countRole(1)->count();
        $user_count = $this->countRole(3)->count();

        return view('ictu.roles.index', compact('user_roles', 'manager_count', 'user_count'));
    }

    public function countRole($role_id)
    {
        $count = UserRole::where('role_id', '=', $role_id)
            ->orderBy('role_id', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return $count;
    }

    public function create()
    {
        $userroles = UserRole::all();
        $employees = Employee::all();

        return view('ictu.roles.create', compact('userroles', 'employees'));
    }

    public function show(UserRole $userrole)
    {
        return view('ictu.roles.show', compact('userrole'));
    }

    public function store()
    {
        $data = request()->validate([
            'user_id' => ['required', Rule::unique('user_roles')
                ->where('route', request()->route)
                ->where('user_id', request()->user_id)],
            'route' => ['required'],
            'role_id' => ['required'],
        ],
        [
            'user_id.unique' => 'The employee already has a role.',
            'user_id.required' => 'The employee field is required.',
            'route.unique' => 'The application field is required.',
            'role_id.required' => 'The role field is required.',
        ]);

        $userrole = UserRole::create(array_merge($data, [
            'user_id' => $data['user_id'],
            'route' => $data['route'],
            'status' => 1,
        ]));

        return redirect()->route('ictu.roles.show', compact('userrole'))->with('status', 'User created!');
    }

    public function edit(UserRole $userrole)
    {
        return view('ictu.roles.edit', compact('userrole'));
    }   
    
    public function update(UserRole $userrole)
    {
        $data = request()->validate([
            'role_id' => ['required'],
        ]);

        $user_roles = UserRole::where('role_id', '=', 1)->get();
        
        $user = Auth()->user();
        
        if($user->id == $userrole->user_id)
        {
            return redirect()->route('ictu.roles.show', compact('userrole'))->with('error', 'You cannot modify yourself.');
        }
        else if($userrole->role_id != 1)
        {
            $userrole->update($data);
        }
        else if($userrole->role_id == 1 && sizeof($user_roles) > 1 && $user->userrole->first()->role_id == 1)
        {
            $userrole->update($data);
        }
        else {
            return redirect()->route('ictu.roles.show', compact('userrole'))->with('error', 'You cannot modify an administrator account.');
        }   

        

        return redirect()->route('ictu.roles.show', compact('userrole'))->with('status', 'User updated!');
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

        return view('ictu.roles.lookup', compact('employees'));
    } 

    public function confirmDelete(UserRole $userrole)
    {
        return view('ictu.roles.show', compact('userrole'));
    }

    public function delete(UserRole $userrole)
    {
        $user_roles = UserRole::where('role_id', '=', 1)->get();

        $user = Auth()->user();
        
        if($user->id == $userrole->user_id)
        {
            return redirect()->route('ictu.roles.show', compact('userrole'))->with('error', 'You cannot remove yourself.');
        }
        else if($userrole->role_id != 1)
        {
            $userrole->delete();
        }
        else if($userrole->role_id == 1 && sizeof($user_roles) > 1 && $user->userrole->first()->role_id == 1)
        {
            $userrole->delete();
        }
        else {
            return redirect()->route('ictu.roles.show', compact('userrole'))->with('error', 'You cannot remove an administrator account.');
        }        

        return redirect()->route('ictu.roles')->with('status', 'User deleted!');
    }

    public function search()
    {
        $searchString = request()->get('searchString');

        $user_roles = UserRole::join('users', 'user_roles.user_id', '=', 'users.id')
            ->where(function ($query) use ($searchString){
                $query->where('name', 'like' , '%'. $searchString . '%');
            })
            ->orderBy('role_id', 'asc')
            ->orderBy('user_roles.id', 'asc')
            ->select('users.id as uid', 'users.*', 'user_roles.*')
            ->get();

        $manager_count = $this->countRole(2)->count();
        $user_count = $this->countRole(3)->count();

        return view('ictu.roles.index', compact('user_roles', 'manager_count', 'user_count'));
    }
}