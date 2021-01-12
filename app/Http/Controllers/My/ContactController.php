<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Models\Person;

class ContactController extends Controller
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
    public function create()
    {
        return view('my.contact.create');
    }

    public function store()
    {
        $data = request()->validate([
            'primaryno' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/'],
            'secondaryno' => ['nullable', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/'], 
            'emergencyperson' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z-.\s]*$/'],
            'emergencyrelation' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z-\s]*$/'],
            'emergencyaddress' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.\s]*$/'],
            'emergencycontact' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/'],
        ]); 

        $user = Auth::user();
        $person = $user->person; 
        $person->contacts()->create($data);

        return redirect()->route('my');
    }

    public function edit()
    {
        $user = Auth::user();
        $person = $user->person;
        
        return view('my.contact.edit', compact('person'));
    }

    public function update()
    {

        $data = request()->validate([
            'primaryno' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/'],
            'secondaryno' => ['nullable', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/'], 
            'emergencyperson' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z-.Ññ\s]*$/'],
            'emergencyrelation' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z-Ññ\s]*$/'],
            'emergencyaddress' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.Ññ\s]*$/'],
            'emergencycontact' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/'],
        ]); 

        $user = Auth::user();
        $contact = $user->person->contact;
        $contact->update($data);      

        return redirect()->route('my')->with('status', 'Contact information updated!');
    }
}
