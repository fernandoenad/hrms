<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Dropdown;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $people = Person::orderBy('lastname', 'asc')->orderBy('firstname', 'asc')->paginate(15);

        return view('ps.people.index', compact('people'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $people = Person::where('lastname', 'like' , $searchString . '%')
            ->orWhere('firstname', 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $searchString . '%')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->paginate(15);
        
        $people = $people->appends(['searchString' => $searchString]);
        
        return view('ps.people.index', compact('people'));
    }

    public function create()
    {
        $sexes = Dropdown::where('type', 'sex')->get();
        $extensions = Dropdown::where('type', 'extension')->get();

        return view('ps.people.create', [
            'sexes' => $sexes, 
            'extensions' => $extensions,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.-Ññ]*$/'],
            'middlename' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.-Ññ]*$/'],
            'lastname' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.-Ññ]*$/'],
            'extname' => ['nullable', 'string'],
            'sex' => ['required', 'string'],
            'dob' => ['required', 'date', 'before:-15 years'],
            'image' => 'string',
            'primaryno' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', 'unique:contacts'],
            'username' => ['required', 'string', 'min:5', 'max:255', 'regex:/^[a-zA-Z\s.-]*$/', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
        ]);

       
        $name = $data['firstname'] . " " . $data['lastname'] . " " . $data['extname'];
        
        $person = Person::create([
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'extname' => $data['extname'],
            'sex' => $data['sex'],
            'dob' => $data['dob'],
            'image' => $data['image'],
        ]);
        
        Contact::create([
            'person_id' => $person->id,
            'primaryno' => $data['primaryno'],
        ]);

        User::create([
            'person_id' => $person->id,
            'name' => $name,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['username']),
        ]);  
        

        return redirect()->route('ps.people.show', compact('person'))->with('status', 'Profile created!'); 
    }

    public function show(Person $person)
    {
        return view('ps.people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        $sexes = Dropdown::where('type', 'sex')->get();
        $extensions = Dropdown::where('type', 'extension')->get();

        return view('ps.people.edit', [
            'sexes' => $sexes, 
            'extensions' => $extensions,
            'person' => $person,
        ]);
    }

    public function update(Person $person)
    {
        $data = request()->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.-Ññ]*$/'],
            'middlename' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.-Ññ]*$/'],
            'lastname' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.-Ññ]*$/'],
            'extname' => ['nullable', 'string'],
            'sex' => ['required', 'string'],
            'dob' => ['required', 'date', 'before:-15 years'],
            'image' => ['nullable', 'image'],
            'primaryno' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($person->contact->id)],
            'secondaryno' => ['nullable', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($person->contact->id)], 
            'emergencyperson' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z-.Ññ\s]*$/'],
            'emergencyrelation' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z-Ññ\s]*$/'],
            'emergencyaddress' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.Ññ\s]*$/'],
            'emergencycontact' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($person->contact->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($person->user->id)],
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

        $person->user->update([
            'name' => $name,
            'username' => $data['username'],
            'email' => $data['email'],
        ]);  

        return redirect()->route('ps.people.show', compact('person'))->with('status', 'Profile updated!'); 
    }

    public function reset(Person $person)
    {
        return view('ps.people.reset', compact('person'));
    }

    public function resetdone(Person $person)
    {
        $person->user->update(['password' =>  Hash::make($person->user->username)]);

        return redirect()->route('ps.people.show', compact('person'))->with('status', 'Password reset was completed!'); 
    }

    public function employ(Person $person)
    {
        return view('ps.people.employ', compact('person'));
    }
}
