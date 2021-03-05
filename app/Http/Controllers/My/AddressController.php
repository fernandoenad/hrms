<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
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
    public function edit()
    {
        $user = Auth::user();
        $person = $user->person;
        $currents = Address::groupBy('current')
            ->orderBy('current', 'asc')
            ->select('current')
            ->get();
        $permanents = Address::groupBy('permanent')
            ->orderBy('permanent', 'asc')
            ->select('permanent')
            ->get();
        
        return view('my.address.edit', compact('person', 'permanents', 'currents'));
    }

    public function update()
    {

        $data = request()->validate([
            'current' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.Ññ\s-]*$/'],
            'currentzip' => ['required', 'integer', 'min:1000', 'max:9999', 'regex:/^[0-9]*$/'],
            'permanent' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.Ññ\s-]*$/'],
            'permanentzip' => ['required', 'integer', 'min:1000', 'max:9999', 'regex:/^[0-9]*$/'],
        ]); 

        $user = Auth::user();
        $address = $user->person->address;
        $address->update($data);      

        return redirect()->route('my')->with('status', 'Address information updated!');
    }
}
