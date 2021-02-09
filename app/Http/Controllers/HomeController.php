<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountRequest;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function help()
    {
        return view('home.help');
    }

    public function track()
    {
        $accountrequest = AccountRequest::find(request()->id);

        if(!isset($accountrequest->id))
            return redirect()->route('help.track-requests')->with('status', 'Request Not Found');

        return view('home.requests.show', compact('accountrequest'));
    }

    public function lookup()
    {
      
        return view('home.requests.lookup');
    }

    public function search()
    {
      
        return view('home.help');
    }

    public function apps()
    {
        return view('home.apps');
    }
}
