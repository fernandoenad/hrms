<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Office;

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

        if (is_numeric($office)) {
            $office = Office::find($office);
        }

        if(! $request->user()->isOfficeUser($office->id)){
            abort(401, 'Unauthorized access.');
        }

        return $next($request);
    }
}
