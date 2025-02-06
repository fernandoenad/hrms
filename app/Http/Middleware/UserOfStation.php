<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Office;

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

        $office = Office::find($station->office_id);
        
        if($request->user()->isStationUser($station->id)){
        } else if ($request->user()->isOfficeUser($office->id)){
        } else {
            abort(401, 'Unauthorized access.'); 
        }
        /*
        if(!$request->user()->isStationUser($station->id)){
            abort(401, 'Unauthorized access.'); 
        }
        */

        return $next($request);
    }
}
