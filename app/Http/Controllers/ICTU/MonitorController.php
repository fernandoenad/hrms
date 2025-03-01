<?php

namespace App\Http\Controllers\ICTU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class MonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        $users = User::all()->filter(function ($user) {
            return Cache::has('user-is-online-' . $user->id);
        })->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'online_since' => Cache::get('user-online-since-' . $user->id, now())->toDateTimeString(),
            ];
        });

        //dd($users);
        return view('ictu.monitor.index', ['users' => $users]);
    }
}
