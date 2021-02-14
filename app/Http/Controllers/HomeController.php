<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountRequest;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function help()
    {
        $posts = Post::where('type', '=', 'Help')
            ->orderBy('created_at', 'desc')->paginate(4);

        return view('home.help', compact('posts'));
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
        $str = request()->get('str');

        $posts = Post::where('type', '=', 'Help')
            ->where(function ($query) use ($str){
                $query->where('title', 'like', '%' . $str . '%')
                    ->orWhere('title', 'like', '%' . $str . '%');
            })
            ->orderBy('created_at', 'desc')->paginate(15);

        $posts = $posts->appends(['str' => $str]);

        return view('home.help', compact('posts'));
    }

    public function apps()
    {
        return view('home.apps');
    }
}
