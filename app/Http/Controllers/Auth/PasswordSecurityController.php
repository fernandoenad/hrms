<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordSecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest'); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.passwords.reset_password');
    }

    public function resetPassword()
    {
        $password_expired_id = request()->session()->get('password_expired_id');

        if (!isset($password_expired_id)) 
            return redirect()->route('login');

        $data = request()->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

        $user = User::find($password_expired_id);
        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('status', 'Password updated, please re-login!');
    }
}