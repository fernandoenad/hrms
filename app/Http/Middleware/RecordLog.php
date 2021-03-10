<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class RecordLog
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
        /*
        if(Route::currentRouteName() == 'ictu.requests.new-counter')
            return $next($request);
            
        if (Auth::check()) {
            $user = Auth::user();
            $user->userlog()->create([
                'ip' => $request->ip(), 
                'route' => Route::currentRouteName(),
                'url' => URL::full(),
                'sessionkey' =>  session()->getId(),  
            ]);
        } else{
            UserLog::create([
                'ip' => $request->ip(),
                'route' => Route::currentRouteName(),
                'url' => URL::full(),      
                'user_id' => 0,   
                'sessionkey' => session()->getId(),       
            ]);
        }
        */
        return $next($request);
    }
}
