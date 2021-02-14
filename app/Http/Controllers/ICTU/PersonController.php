<?php

namespace App\Http\Controllers\ICTU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\PUserLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        $people = $this->getList()->paginate(15);
        
        return view('ictu.people.index', compact('people'));
    }

    public function nonemployees()
    {
        $people = $this->getList()->whereNotIn('people.id', function($query){
            $query->select('person_id')->from('employees');
        })
        ->paginate(15);
        
        return view('ictu.people.index', compact('people'));
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
            ->paginate(15);

        $people = $people->appends(['searchString' => $searchString]);

        return view('ictu.people.index', compact('people', 'people_count'));
    }

    public function getList()
    {
        $people = Person::orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc');

        return $people;
    }

    public function show(Person $person)
    {
        if(isset($person->employee))
        {
            $employee = $person->employee;
            return redirect()->route('ictu.employees.show', compact('employee')); 
        }
        else
            return view('ictu.people.show', compact('person')); 
    }

    public function reset(Person $person)
    {
        return view('ictu.people.reset', compact('person'));
    }

    public function update(Person $person)
    {
        $person->user->update(['password' =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);

        if(isset($person->employee))
        {
            $employee = $person->employee;
            return redirect()->route('ictu.employees.show', compact('employee'))->with('status', 'Password reset was completed!');
        }
        else 
            return redirect()->route('ictu.people.show', compact('person'))->with('status', 'Password reset was completed!');
    }

    public function editcredentials(Person $person)
    {
        return view('ictu.people.editcredentials', compact('person'));
    }

    public function updatecredentials(Person $person)
    {
        $data = request()->validate([
            'username' => ['required', 'string', 'max:255', 'regex:/^[0-9a-zA-Z.-]*$/', Rule::unique('users')->ignore($person->user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($person->user->id)],
            ]);

        $person->user->update($data);

        PUserLog::create([
            'u_id' => $user->id,
            'action' => 'Create',
            'log' => $user->toJson(),
            'user_id' => Auth::user()->id,
        ]);

        if(isset($person->employee)){
            $employee = $person->employee;
            return redirect()->route('ictu.employees.show', compact('employee'))->with('status', 'Credential modification was completed!');
        }else 
            return redirect()->route('ictu.people.show', compact('person'))->with('status', 'Credential modification was completed!');  
    }

    public function delete(Person $person)
    {
        return view('ictu.people.delete', compact('person'));
    }

    public function destroy(Person $person)
    {
        $person->contact()->delete();
        $person->address()->delete();
        $person->employee()->delete();
        $person->user()->delete();
        $person->delete();

        return redirect()->route('ictu.people')->with('status', 'Account removal was completed!');  
    }
}
