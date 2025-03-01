<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dropdown;
use App\Models\Contact;
use App\Models\Person;
use App\Models\User;
use App\Models\PUserLog;
use App\Models\Address;
use App\Models\AccountRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

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
            'firstname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/', 
                //Rule::unique('people')
                //->where('firstname',request()->firstname)
                //->where('middlename', request()->middlename)
                //->where('lastname', request()->lastname)
                //->where('extname', request()->extname)
                //->where('sex', request()->sex)
                //->where('dob', request()->dob)
                //->where('civilstatus', request()->civilstatus)
                ],
            'middlename' => ['nullable', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'lastname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'extname' => ['nullable', 'string'],
            'sex' => ['required', 'string'],
            'dob' => ['required', 'date', 'before:-15 years'],
            'civilstatus' => ['required', 'string'],
            'image' => 'string',
            'primaryno' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', 'unique:contacts'],
            'username' => ['required', 'string', 'min:5', 'max:255', 'regex:/^[0-9a-zA-Z.-]*$/', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9._%+-]+@deped\.gov\.ph$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
            'email.regex' => 'Only DepEd emails are accepted.',
            'firstname.unique' => 'Duplicate record alert! Try logging in by following instructions above.',
            'dob.required' => 'The date of birth field is required.',
            'dob.before' => 'The date of birth field should take place before :date.',
            'civilstatus.required' => 'The civil status field is required.',
            'primaryno.required' => 'The primary contact no field is required.',
            'primaryno.min' => 'The primary contact no field must be at least :min characters.',
            'primaryno.max' => 'The primary contact no field must be at most :max characters.',
            'primaryno.regex' => 'The primary contact no format is invalid.',
            'primaryno.unique' => 'The primary contact no field is already taken.',
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
            'email_verified_at' => Carbon::now(),
        ]); 

        $address = $person->address()->create();

        //$user->sendEmailVerificationNotification();
        //Auth::loginUsingId($user->id);

        $person->personlog()->create([
            'action' => 'Create',
            'log' => $person->toJson(),
            'user_id' => $user->id,
        ]);  
        
        PUserLog::create([
            'u_id' => $user->id,
            'action' => 'Create',
            'log' => $user->toJson(),
            'user_id' => $user->id,
        ]);
        
        //return redirect()->route('verification.notice')->with('status', 'Account created! Please check your email for a verification link.');
        return redirect()->route('login')->with('status', 'Account created! Please login.');

    }

    public function request()
    {
        if(isset(Auth::user()->person)){
            $person = Auth::user()->person;
            $data = request()->validate([
                'action' => ['string'],
                'remarks' => ['required', 'email']
            ],[
                'remarks.required' => 'The email field is required.',
                'remarks.email' => 'The email field is invalid.'
            ]);
    
            $accountrequest = $person->accountrequest()->create(array_merge($data, [
                'status' => 1,
            ]));
            return redirect()->route('verification.notice')->with('request', 'Request sent. Your reference # is ' . $accountrequest->id)->with('request_id', $accountrequest->id); 
        }
        else {
            $data = request()->validate([
                'action' => ['string'],
                'remarks1' => ['required', 'string', 'min:3', 'max:255'],
                'remarks2' => ['required', 'email'],
            ],[
                'remarks1.required' => 'The name field is required.',
                'remarks2.required' => 'The email field is required.',
                'remarks2.email' => 'The email field is invalid.'
            ]);
    
            $accountrequest = AccountRequest::create(array_merge($data, [
                'remarks' => $data['remarks1'] . ' / ' . $data['remarks2'],
                'person_id' => 0,
                'status' => 1,
            ]));
            return redirect()->route('password.request')->with('request', 'Request sent. Your reference # is ' . $accountrequest->id)->with('request_id', $accountrequest->id); 

        }
    }
}
