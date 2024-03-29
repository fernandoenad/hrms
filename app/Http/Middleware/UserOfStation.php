<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Station;

class UserOfStation
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
        $station = $request->station;

        if (is_numeric($station)) {
            $station = Station::find($station);
        }

        if(! $request->user()->isStationUser($station->id)){
            abort(401, 'Unauthorized access.'); 
        }

        return $next($request);
    }
}
