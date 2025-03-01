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

    public function reset()
    {
        return view('home.requests.reset');
    }

    public function reset_save(Request $request)
    {
        $data = request()->validate([
            'employee_number' => ['required', 'string', 'min:4', 'max:7'],
            'firstname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'middlename' => ['nullable', 'string', 'min:1', 'max:255'],
            'lastname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'dob' => ['required', 'date', 'before:-15 years'],
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@deped\.gov\.ph$/'],
            'account' => ['required', 'string'],
            ],
            [
            'dob.required' => 'The date of birth is required.',
            'dob.before' => 'The date of birth field should take place before :date.',
            'email.regex' => 'Only DepEd emails are accepted.',
            'email.required' => 'DepEd email is required.',
        ]);

        $remarks = 'Employee Number: '.$data['employee_number'].'<br>' .
            'Fullname: '.$data['lastname'].', '.$data['firstname'].', '.$data['middlename'].'<br>'.
            'Date of Birth: '.$data['dob'].'<br>'.
            'DepEd Email: '.$data['email'].'<br>'.
            'Account: '.$data['account'].'<br>';

        $account_request_data['action'] = 'Email Password Reset Request'; 
        $account_request_data['remarks'] = $remarks; 
        $account_request_data['status'] = 1; 
        $account_request_data['person_id'] = 0; 
        $account_request_data['user_id'] = null; 

        $account_request = AccountRequest::create($account_request_data);
        
        return redirect(route('help.reset', ['id' => $account_request->id]))->with('status', 'Request has been queued for processing.');
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
