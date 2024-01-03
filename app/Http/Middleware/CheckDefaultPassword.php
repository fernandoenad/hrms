<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class CheckDefaultPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** 
        $password_expired_id = Auth::user()->id;
        $current_password = Auth::user()->password;
        $default_password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

        if ($current_password == $default_password) {
            request()->session()->put('password_expired_id', $password_expired_id);
            Auth::logout();
            return redirect()->route('auth.expired-password')->with('message', "You are using your default password. You need to change it for security purposes.");
        }
        return $next($request);
        */
    }
}
