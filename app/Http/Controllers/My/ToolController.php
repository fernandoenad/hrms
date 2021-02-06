<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ToolController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
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
        $user = Auth::user();
        $person = $user->person; 
       
        return view('my.tool.index', compact('person'));
    }

    public function editEmail()
    {
        $user = Auth::user();
        $person = $user->person; 
       
        return view('my.tool.editemail', compact('person'));
    }

    public function updateEmail()
    {
        $data = request()->validate([
            'email' => ['required', 'email'],
        ]); 

        $user = Auth::user();
        $user->update($data);      

        return redirect()->route('my.tools')->with('status', 'E-Mail updated!'); 
    }

    public function editPassword()
    {       
        $user = Auth::user();
        $person = $user->person; 
       
        return view('my.tool.editpassword', compact('person'));
    }

    public function updatePassword()
    {
        $data = request()->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]); 

        $user = Auth::user();
        $user->update(['password' => Hash::make($data['password']),]);      

        Auth::logout();
        return redirect()->route('login')->with('status', 'Password updated, please re-login!'); 
    }

}
