<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserOfOffice
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
        $office = $request->office; 

        if(! $request->user()->isOfficeUser($office->id)){
            abort(401, 'Unauthorized access.');
        }
        return $next($request);
    }
}
