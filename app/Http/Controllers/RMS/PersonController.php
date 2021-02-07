<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dropdown;
use App\Models\Contact;
use App\Models\Person;
use App\Models\User;
use App\Models\Address;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sexes = Dropdown::where('type', 'sex')->get();
        $extensions = Dropdown::where('type', 'extension')->get();
        $civilstatuses = Dropdown::where('type', 'civilstatus')->get();

        return view('rms.dashboard.register', compact('sexes', 'extensions', 'civilstatuses'));
    }

    public function store()
    {
        $data = request()->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/', 
                Rule::unique('people')
                ->where('firstname',request()->firstname)
                ->where('middlename', request()->middlename)
                ->where('lastname', request()->lastname)
                ->where('extname', request()->extname)
                ->where('sex', request()->sex)
                ->where('dob', request()->dob)
                ->where('civilstatus', request()->civilstatus)],
            'middlename' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'lastname' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'extname' => ['nullable', 'string'],
            'sex' => ['required', 'string'],
            'dob' => ['required', 'date', 'before:-15 years'],
            'civilstatus' => ['required', 'string'],
            'image' => 'string',
            'primaryno' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', 'unique:contacts'],
            'username' => ['required', 'string', 'min:5', 'max:255', 'regex:/^[0-9a-zA-Z.-]*$/', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
            'firstname.unique' => 'Duplicate record alert! Reach out to ICTU for account lookup.',
        ]);

       
        $name = $data['firstname'] . " " . $data['lastname'] . " " . $data['extname'];
        
        $person = Person::create([
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'extname' => $data['extname'],
            'sex' => $data['sex'],
            'dob' => $data['dob'],
            'civilstatus' => $data['civilstatus'],
            'image' => $data['image'],
        ]);
        
        $contact = $person->contact()->create([
            'primaryno' => $data['primaryno'],
        ]);
        
        $user = $person->user()->create([
            'name' => $name,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]); 

        $user->sendEmailVerificationNotification();
        Auth::loginUsingId($user->id);
        
        $address = $person->address()->create();
        
        return redirect()->route('verification.notice')->with('status', 'Account created! Please check your email for a verification link.'); 
    }

    public function request()
    {
        $data = request()->validate([
            'remarks' => ['required', 'email']
        ]);

        $person = Auth::user()->person;
        $person->accountrequest()->create(array_merge($data, [
            'status' => 1,
            'action' => 'Email Correction',
        ]));

        return redirect()->route('verification.notice')->with('status', 'Request sent.'); 
    }
}
