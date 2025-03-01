<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackActiveUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Store user as online with a timestamp
            Cache::put('user-is-online-' . Auth::id(), [
                'status' => true,
                'since' => Cache::get('user-online-since-' . Auth::id(), now()), // Get existing timestamp or set new
            ], now()->addMinutes(5));

            // Store login time separately (if not already set)
            if (!Cache::has('user-online-since-' . Auth::id())) {
                Cache::put('user-online-since-' . Auth::id(), now(), now()->addMinutes(5));
            }
        }

        return $next($request);
    }
}
