<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('ps.users.index');
    }

    public function create()
    {
        return view('ps.users.create');
    }

    public function store(User $user)
    {
        return view('ps.users.index');
    }
}
