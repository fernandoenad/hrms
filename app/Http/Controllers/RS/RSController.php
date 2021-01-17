<?php

namespace App\Http\Controllers\RS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class RSController extends Controller
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
        $empl_a = $this->employeesActiveCounter();
        
        return view('rs.index', compact('empl_a'));
    }

    public function employeesActiveCounter()
    {
        $employees = app('App\Http\Controllers\PS\EmployeeController')->employeesActiveCounter();

        return $employees;
    }
}
