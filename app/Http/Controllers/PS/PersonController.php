<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Dropdown;
use App\Models\User;
use App\Models\Contact;
use App\Models\Item;
use App\Models\Station;
use App\Models\Employee;
use App\Models\Address;
use App\Models\PUserLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $people = $this->getList();
        $people_count = $people->count();
        $people = $people->paginate(15);
        
        return view('ps.people.index', compact('people', 'people_count'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $people = $this->getList();
        $people_count = $people->count();
        $people = $people->where(function ($query) use ($searchString){
                $query->where('lastname', 'like' , $searchString . '%')
                    ->orWhere('firstname', 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $searchString . '%')
                    ->orderBy('lastname', 'asc')
                    ->orderBy('firstname', 'asc');
            })
            ->whereNotIn('people.id', function($query){
                $query->select('person_id')->from('employees');
            })
            ->paginate(15);

        $people = $people->appends(['searchString' => $searchString]);

        return view('ps.people.index', compact('people', 'people_count'));
    }

    public function getList()
    {
        $people = Person::whereNotIn('people.id', function($query){
            $query->select('person_id')->from('employees');
        })
        ->orderBy('lastname', 'asc')
        ->orderBy('firstname', 'asc');

        return $people;
    }

    public function create()
    {
        $sexes = Dropdown::where('type', 'sex')->get();
        $extensions = Dropdown::where('type', 'extension')->get();
        $relations = Contact::groupBy('emergencyrelation')
            ->select('emergencyrelation')
            ->get();
        $addresses = Contact::groupBy('emergencyaddress')
            ->select('emergencyaddress')
            ->get();

        $civilstatuses = Dropdown::where('type', 'civilstatus')->get();

        return view('ps.people.create', compact('sexes', 'extensions', 'relations', 'addresses', 'civilstatuses'));
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
            ],
            [
            'firstname.unique' => 'Duplicate record alert! Please search up existing record using the search bar.',
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
            'person_id' => $person->id,
            'primaryno' => $data['primaryno'],
        ]);

        $user = $person->user()->create([
            'person_id' => $person->id,
            'name' => $name,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['username']),
        ]); 
        
        $address = $person->address()->create([
            'person_id' => $person->id,
        ]);

        $person->personlog()->create([
            'action' => 'Create',
            'log' => $person->toJson(),
            'user_id' => Auth::user()->id,
        ]);  
        
        PUserLog::create([
            'u_id' => $user->id,
            'action' => 'Create',
            'log' => $user->toJson(),
            'user_id' => Auth::user()->id,
        ]);
        
        return redirect()->route('ps.people.show', compact('person'))->with('status', 'Profile created!'); 
    }

    public function show(Person $person)
    {
        if(isset($person->employee))
        {
            $employee = $person->employee;
            return redirect()->route('ps.employees.show', compact('employee')); 
        }
        else {
            $personlogs = $person->personlog()
                ->orderBy('created_at', 'desc')->get();
            return view('ps.people.show', compact('person', 'personlogs')); 
        }
    }

    public function edit(Person $person)
    {
        $sexes = Dropdown::where('type', 'sex')->get();
        $extensions = Dropdown::where('type', 'extension')->get();
        $relations = Contact::groupBy('emergencyrelation')
            ->select('emergencyrelation')
            ->get();
        $addresses = Contact::groupBy('emergencyaddress')
            ->select('emergencyaddress')
            ->get();

        $civilstatuses = Dropdown::where('type', 'civilstatus')->get();

        $currents = Address::groupBy('current')
            ->orderBy('current', 'asc')
            ->select('current')
            ->get();
        $permanents = Address::groupBy('permanent')
            ->orderBy('permanent', 'asc')
            ->select('permanent')
            ->get();

        return view('ps.people.edit', compact('person', 'sexes', 'extensions', 'relations', 'addresses', 'civilstatuses', 'currents', 'permanents'));
    }

    public function update(Person $person)
    {
        $data = request()->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'middlename' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'lastname' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'extname' => ['nullable', 'string'],
            'sex' => ['required'],
            'dob' => ['required', 'date', 'before:-15 years'],
            'civilstatus' => ['required'],
            'image' => ['nullable', 'image'],
            'primaryno' => ['nullable', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($person->contact->id)],
            'secondaryno' => ['nullable', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($person->contact->id)], 
            'current' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.Ññ\s]*$/'],
            'currentzip' => ['nullable', 'integer', 'min:1000', 'max:9999', 'regex:/^[0-9]*$/'],
            'permanent' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.Ññ\s]*$/'],
            'permanentzip' => ['nullable', 'integer', 'min:1000', 'max:9999', 'regex:/^[0-9]*$/'],
            'emergencyperson' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'emergencyrelation' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'emergencyaddress' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.,Ññ-]*$/'],
            'emergencycontact' => ['nullable', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($person->contact->id)],
            'username' => ['required', 'string', 'max:255', 'regex:/^[0-9a-zA-Z.-]*$/', Rule::unique('users')->ignore($person->user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($person->user->id)],
        ]);

        $name = $data['firstname'] . " " . $data['lastname'] . " " . $data['extname'];

        if(isset($data['image']))
        {
            if($person->image != 'no-avatar.jpg')
                unlink("storage/avatars/" . $person->image);
            
            $imagePath = $data['image']->store('avatars', 'public');
            
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(300, 300);
            $image->save();

            $image = explode("/", $imagePath);

            $person->update([
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'extname' => $data['extname'],
                'sex' => $data['sex'],
                'dob' => $data['dob'],
                'civilstatus' => $data['civilstatus'],
                'image' => $image[1],
            ]);
        }
        else 
        {
            $person->update([
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'extname' => $data['extname'],
                'sex' => $data['sex'],
                'dob' => $data['dob'],
                'civilstatus' => $data['civilstatus'],
            ]);
        }

        $person->contact->update([
            'primaryno' => $data['primaryno'],
            'secondaryno' => $data['secondaryno'],
            'emergencyperson' => $data['emergencyperson'],
            'emergencyrelation' => $data['emergencyrelation'],
            'emergencyaddress' => $data['emergencyaddress'],
            'emergencycontact' => $data['emergencycontact'],
        ]);

        $person->address->update([
            'current' => $data['current'],
            'currentzip' => $data['currentzip'],
            'permanent' => $data['permanent'],
            'permanentzip' => $data['permanentzip'],
        ]);

        $person->user->update([
            'name' => $name,
            'username' => $data['username'],
            'email' => $data['email'],
        ]); 
        
        $person->personlog()->create([
            'action' => 'Modify',
            'log' => $person->toJson(),
            'user_id' => Auth::user()->id,
        ]);  
        
        PUserLog::create([
            'u_id' => $person->user->id,
            'action' => 'Modify',
            'log' => $person->user->toJson(),
            'user_id' => Auth::user()->id,
        ]);
        
        if(isset($person->employee))
        {
            $employee = $person->employee;
            return redirect()->route('ps.employees.show', compact('employee'))->with('status', 'Profile updated!');
        }
        else 
            return redirect()->route('ps.people.show', compact('person'))->with('status', 'Profile updated!');
    }

    public function employ(Person $person)
    {
        $items = Item::where('status', '=', 1)
            ->whereNotIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->get();

        $employmentstatuses = Dropdown::where('type', 'employmentstatus')
            ->get();

        $stations = Station::select('id', 'code', 'name', 'office_id')
            ->orderBy('code', 'asc')
            ->get();
           
        if(isset($person->employee))
        {
            $employee = $person->employee;
            return redirect()->route('ps.employees.show', compact('employee'))->with('error', 'Already employed!'); 
        }
        else
            return view('ps.people.employ', compact('person','items', 'stations', 'employmentstatuses'));
    }

    public function employdone(Person $person)
    {
        $data = request()->validate([
            'item_id' => ['required'],
            'appointmentdate' => ['required', 'date', 'before_or_equal: today'],
            'firstdaydate' => ['required', 'date', 'after_or_equal:'.request()->appointmentdate],            
            'employmentstatus' => ['required'],
        ]);

        
        $employee = $person->employee()->create([
            'empno' => 'T-' . strtotime('now'),
            'person_id' => $person->id,
            'item_id' => $data['item_id'],
            'step' => 1,
            'lastapptdate' => $data['firstdaydate'], 
            'hiredate' => $data['firstdaydate'], 
            'employmentstatus' => $data['employmentstatus'],         
        ]);

        $item = $employee->item()->update([
            'appointmentdate' => $data['appointmentdate'],
            'firstdaydate' => $data['firstdaydate'],     
        ]);

        $employee->employeelog()->create([
            'action' => 'Modify',
            'log' => $employee->toJson(),
            'user_id' => Auth::user()->id,
        ]); 

        $employee->item->itemlog()->create([
            'action' => 'Modify',
            'log' => $employee->item->toJson(),
            'user_id' => Auth::user()->id,
        ]); 
        
        return redirect()->route('ps.employees.show', compact('employee'))->with('status', 'Employment created!');
    }

    public function lookupItem(Person $person)
    {
        $searchString = request()->get('searchString');

        $items = Item::where('status', '=', 1)
            ->whereNotIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->where(function($query) use ($searchString) {
                $query->where('itemno', 'like', '%' . $searchString . '%') 
                    ->orWhere('position', 'like', $searchString . '%');
            })       
            ->paginate(15);

        $items = $items->appends(['searchString' => $searchString]);

        return view('ps.people.lookup', compact('person', 'items'));
    }
}
