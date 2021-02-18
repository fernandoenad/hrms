<?php

namespace App\Http\Controllers\ICTU;

use App\Http\Controllers\Controller;
use App\Models\AccountRequest;
use App\Models\PUserLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountrequests = AccountRequest::orderBy('status', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('ictu.requests.index', compact('accountrequests'));
    }

    public function activations()
    {
        $users = User::where('email_verified_at', '!=', NULL)
            ->orderBy('email_verified_at', 'desc')
            ->paginate(15);

        return view('ictu.requests.activations', compact('users'));
    }

    public function display()
    {
        if(Route::currentRouteName() == 'ictu.requests.display-new')
            $filter = 1;
        else if(Route::currentRouteName() == 'ictu.requests.display-pending')
            $filter = 2;
        else if(Route::currentRouteName() == 'ictu.requests.display-resolved')
            $filter = 3;

        $accountrequests = AccountRequest::where('status', '=', $filter)
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('ictu.requests.index', compact('accountrequests'));
    }

    public function search()
    {
        $str = request()->get('str');

        $accountrequests = AccountRequest::Where('action', 'like', '%' . $str . '%')
            ->orWhere('remarks', 'like', '%' . $str . '%')
            ->orWhere('id', '=', $str)
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('ictu.requests.index', compact('accountrequests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountRequest  $accountrequest
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountRequest $accountrequest)
    {
        if($accountrequest->status == 1){
            $accountrequest->update([
                'status' => 2,
                'user_id' => Auth::user()->id,
                ]);
        }
        $accountrequests = AccountRequest::orderBy('status', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('ictu.requests.index', compact('accountrequests', 'accountrequest'));
    }

    public function resetpassword(AccountRequest $accountrequest)
    {
        $accountrequest->person->user()->update([
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ]);

        $accountrequest->update([
            'remarks' => $accountrequest->remarks . '<br>=============<br>' . 'New password is "password" (without quotes).',
            ]);

        PUserLog::create([
            'u_id' => $accountrequest->person->user->id,
            'action' => 'Modify- Password reset',
            'log' => $accountrequest->person->user->toJson(),
            'user_id' => Auth::user()->id,
        ]);
            
        return redirect()->route('ictu.requests.edit', compact('accountrequest'))->with('status', 'Password reset was successful.');   ;
    }

    public function verifyemail(AccountRequest $accountrequest)
    {
        $accountrequest->person->user()->update([
            'email_verified_at' => date('Y-m-d H:i', strtotime(NOW())),
            ]);
        $accountrequest->update([
            'remarks' => $accountrequest->remarks . '<br>=============<br>' . 'Account was manually verified.',
            ]);
        PUserLog::create([
            'u_id' => $accountrequest->person->user->id,
            'action' => 'Modify- Manual Email Verificaton',
            'log' => $accountrequest->person->user->toJson(),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('ictu.requests.edit', compact('accountrequest'))->with('status', 'Account was manually verified.');   ;    
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountRequest  $accountrequest
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRequest $accountrequest)
    {
        $data = request()->validate([
            'status' => ['required'],
            'remarks' => ['required', 'min:3'],
            ]);

        $accountrequest->update([
            'status' => $data['status'],
            'remarks' => $accountrequest->remarks . '<br>=============<br>' . $data['remarks'],
            ]);

        return redirect()->route('ictu.requests')->with('status', 'Account request was updated.');    
    }

    public function getNewCounter()
    {
        $accountrequestcount_new = AccountRequest::where('status', '=', 1)
            ->count();

        return view('ictu.requests.counter', compact('accountrequestcount_new'));
    }
}
