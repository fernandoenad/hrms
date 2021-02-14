<?php

namespace App\Http\Controllers\ICTU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Employee;
use App\Models\UserRole;

class ICTUController extends Controller
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
        $people = $this->getPeople()->take(10);
        $people_count = $this->getPeople()->count();
        $employees_count = $this->getEmployees()->count();
        $userroles_count = $this->getUserRoles()->count();

        return view('ictu.index', compact('people', 'people_count', 'employees_count', 'userroles_count'));
    }

    public function getPeople()
    {
        $people = Person::orderBy('id', 'desc')
            ->whereNotIn('people.id', function($query){
                $query->select('person_id')->from('employees');
            })
            ->get();

        return $people;
    }

    public function getEmployees()
    {
        $employees = Employee::all();

        return $employees;
    }

    public function getUserRoles()
    {
        $userroles = UserRole::all();

        return $userroles;
    }
}
