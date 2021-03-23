<?php

namespace App\Http\Controllers\OU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Deployment;
use App\Models\Employee;
use App\Models\Contact;
use App\Models\Person;
use App\Models\Address;
use App\Models\Dropdown;
use App\Models\PUserLog;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class STEmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Station $station)
    {
        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->where('station_id', '=', $station->id)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);

        return view('ou.station.employees.index', compact('station', 'employees'));
    }

    public function search(Station $station)
    {
        $str = request()->get('str');

        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->join('items', 'deployments.item_id', '=', 'items.id')
            ->where('deployments.station_id', '=', $station->id)
            ->where(function ($query) use ($str){
                $query->where('lastname', 'like' , $str . '%')
                    ->orWhere('firstname', 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $str . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $str . '%')
                    ->orWhere('position', 'like', '%' . $str . '%');
                })
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(15);
      
        $employees = $employees->appends(['str' => $str]);
       
        return view('ou.station.employees.index', compact('station', 'employees'));
    }

    public function filter(Station $station, $filter)
    {
        $filter = ($filter == 1 ? '%' : $filter);
        $employees = Employee::join('deployments', 'employees.item_id', '=', 'deployments.item_id')
            ->join('people', 'employees.person_id', '=', 'people.id')
            ->join('items', 'deployments.item_id', '=', 'items.id')
            ->where('deployments.station_id', '=', $station->id)
            ->where('position', 'like', $filter)
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->select('employees.id AS empid', 'employees.*', 'people.*')
            ->paginate(1000);
             
        return view('ou.station.employees.index', compact('station', 'employees'));
    }

    public function items(Station $station, $pagination)
    {
        $items = Item::join('deployments', 'items.id', '=', 'deployments.item_id')
            ->where('deployments.station_id', '=', $station->id)
            ->orderByRaw('CONVERT(salarygrade, SIGNED) desc')
            ->paginate($pagination);

        return view('ou.station.employees.items', compact('station', 'items'));
    }

    public function plantilla(Station $station, $pagination)
    {
        $items = Item::join('employees', 'items.id', '=', 'employees.item_id')
            ->where('items.station_id', '=', $station->id)
            ->orderByRaw('CONVERT(salarygrade, SIGNED) desc')
            ->paginate($pagination);

        return view('ou.station.employees.plantilla', compact('station', 'items'));
    }

    public function show(Station $station, Employee $employee)
    {
        $person = $employee->person;

        return view('ou.station.employees.show', compact('station', 'person'));
    }

    public function servicecredits(Station $station, Employee $employee)
    {
        $person = $employee->person;

        return view('ou.station.employees.servicecredits', compact('station', 'person'));
    }

    public function edit(Station $station, Employee $employee)
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

        $positions = Item::groupBy('position')
            ->select('position')
            ->get();
        
        $employeetypes = Dropdown::where('type', '=', 'employeetype')
            ->get();    
       
        $itemlevels = Dropdown::where('type', '=', 'itemlevel')
        ->get(); 

        $employmentstatuses = Dropdown::where('type', 'employmentstatus')
            ->get();

        $stations = Station::select('id', 'code', 'name', 'office_id')
            ->orderBy('name', 'asc')
            ->get();

        $person = $employee->person;

        return view('ou.station.employees.edit', compact('station', 'person', 'employmentstatuses', 'stations', 'sexes', 'extensions', 'relations', 'addresses', 'civilstatuses', 'currents', 'permanents', 'positions', 'employeetypes', 'stations', 'itemlevels'));
    }

    public function update(Station $station, Employee $employee)
    {
        $data = request()->validate([
            'firstname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'middlename' => ['nullable', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'lastname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'extname' => ['nullable', 'string'],
            'sex' => ['required'],
            'dob' => ['required', 'date', 'before:-15 years'],
            'civilstatus' => ['required'],
            'image' => ['nullable', 'image'],
            'primaryno' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($employee->person->contact->id)],
            'secondaryno' => ['nullable', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($employee->person->contact->id)], 
            'current' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.Ññ\s]*$/'],
            'currentzip' => ['required', 'integer', 'min:1000', 'max:9999', 'regex:/^[0-9]*$/'],
            'permanent' => ['nullable', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z,.Ññ\s]*$/'],
            'permanentzip' => ['nullable', 'integer', 'min:1000', 'max:9999', 'regex:/^[0-9]*$/'],
            'emergencyperson' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'emergencyrelation' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.Ññ-]*$/'],
            'emergencyaddress' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.,Ññ-]*$/'],
            'emergencycontact' => ['required', 'string', 'min:11', 'max:11', 'regex:/(0)[0-9]{10}/', Rule::unique('contacts')->ignore($employee->person->contact->id)],
            'username' => ['required', 'string', 'max:255', 'regex:/^[0-9a-zA-Z.-]*$/', Rule::unique('users')->ignore($employee->person->user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($employee->person->user->id)],
            'empno' => ['required', 'string', 'min:7', 'max:12', 'regex:/^[Tt0-9-]*$/', Rule::unique('employees')->ignore($employee->id)],
            'tinno' => ['nullable', 'string', 'min:9', 'max:12', 'regex:/^[0-9]*$/', Rule::unique('employees')->ignore($employee->id)],
            'gsisbpno' => ['nullable', 'string', 'min:9', 'max:12', 'regex:/^[0-9]*$/', Rule::unique('employees')->ignore($employee->id)],
            'pagibigid' => ['nullable', 'string', 'min:12', 'max:12', 'regex:/^[0-9]*$/', Rule::unique('employees')->ignore($employee->id)],
            'philhealthno' => ['nullable', 'string', 'min:12', 'max:12', 'regex:/^[0-9]*$/', Rule::unique('employees')->ignore($employee->id)],
            'dbpaccountno' => ['nullable', 'string', 'min:6', 'max:12', 'regex:/^[0-9]*$/', Rule::unique('employees')->ignore($employee->id)],
            'itemno' => ['required', 'string', 'min:15', 'max:255', 'regex:/^[a-zA-Z0-9-]*$/', Rule::unique('items')->ignore($employee->item->id)],
            'level' => ['required'],
            'position' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'salarygrade' => ['required'],
            'employeetype' => ['required'],
            'station_id' => ['required'],
            'deployment_station_id' => ['required'],
            'step' => ['required'],
            'employmentstatus' => ['required'],
            'appointmentdate' => ['required', 'date', 'before_or_equal:today'],
            'firstdaydate' => ['required', 'date', 'after_or_equal:appointmentdate'],
            'confirmationdate' => ['nullable', 'date'],             
            'hiredate' => ['required', 'date'],
            'lastnosidate' => ['required', 'date'],
        ]);

        $name = $data['firstname'] . " " . $data['lastname'] . " " . $data['extname'];

        if(isset($data['image']))
        {
            if($employee->person->image != 'no-avatar.jpg')
                unlink("storage/avatars/" . $employee->person->image);
            
            $imagePath = $data['image']->store('avatars', 'public');
            
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(300, 300);
            $image->save();

            $image = explode("/", $imagePath);

            $employee->person()->update([
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
            $employee->person()->update([
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'extname' => $data['extname'],
                'sex' => $data['sex'],
                'dob' => $data['dob'],
                'civilstatus' => $data['civilstatus'],
            ]);
        }

        $employee->person->contact()->update([
            'primaryno' => $data['primaryno'],
            'secondaryno' => $data['secondaryno'],
            'emergencyperson' => $data['emergencyperson'],
            'emergencyrelation' => $data['emergencyrelation'],
            'emergencyaddress' => $data['emergencyaddress'],
            'emergencycontact' => $data['emergencycontact'],
        ]);

        $employee->person->address()->update([
            'current' => $data['current'],
            'currentzip' => $data['currentzip'],
            'permanent' => $data['permanent'],
            'permanentzip' => $data['permanentzip'],
        ]);

        $employee->person->user()->update([
            'name' => $name,
            'username' => $data['username'],
            'email' => $data['email'],
        ]); 
        
        $employee->person->personlog()->create([
            'action' => 'Modify',
            'log' => $employee->person->toJson(),
            'user_id' => Auth::user()->id,
        ]);  
        
        PUserLog::create([
            'u_id' => $employee->person->user->id,
            'action' => 'Modify',
            'log' => $employee->person->user->toJson(),
            'user_id' => Auth::user()->id,
        ]);

       
        if(isset(request()->empno_mark))
            $data = array_merge($data, ['empno' => 'T-' . strtotime('now')]);

        if(isset(request()->lastnosidate_mark))
            $data = array_merge($data, ['lastnosidate' => NULL]);
        
        if(isset(request()->retirementdate_mark))
            $data = array_merge($data, ['retirementdate' => NULL]);

        if(isset(request()->confirmationdate_mark))
            $data = array_merge($data, ['confirmationdate' => NULL]);

        $employee->update([
            'empno' => $data['empno'],
            'hiredate' => $data['hiredate'],
            'step' => $data['step'],
            'lastapptdate' => $data['appointmentdate'],
            'lastnosidate' => $data['lastnosidate'],
            'employmentstatus' => $data['employmentstatus'],
            'tinno' => $data['tinno'],
            'gsisbpno' => $data['gsisbpno'],
            'pagibigid' => $data['pagibigid'],
            'philhealthno' => $data['philhealthno'],
            'dbpaccountno' => $data['dbpaccountno'],
            ]);

        $employee->item()->update([
            'itemno' => $data['itemno'],
            'level' => $data['level'],
            'position' => $data['position'],
            'salarygrade' => $data['salarygrade'],
            'employeetype' => $data['employeetype'],
            'appointmentdate' => $data['appointmentdate'],
            'firstdaydate' => $data['firstdaydate'],
            'confirmationdate' => $data['confirmationdate'],
            'station_id' => $data['station_id'],
            ]);

        $employee->item->deployment()->update(['station_id' => $data['deployment_station_id']]);

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

        return redirect()->route('ou.station.employees.show', compact('station', 'employee'))->with('status', 'Employee record has been updated.');
    }

    public function move(Station $station, Employee $employee)
    {
        $stations = Station::select('id', 'code', 'name', 'office_id')
            ->orderBy('name', 'asc')
            ->get();

        $person = $employee->person;

        return view('ou.station.employees.move', compact('station', 'person', 'stations'));
    }

    public function moved(Station $station, Employee $employee)
    {
        $data = request()->validate([
            'deployment_station_id' => ['required'],
            ]);

        $employee->item->deployment()->update(['station_id' => $data['deployment_station_id']]);

        $employee->employeelog()->create([
            'action' => 'Modify Deployment',
            'log' => $employee->toJson(),
            'user_id' => Auth::user()->id,
        ]); 

        $employee->item->itemlog()->create([
            'action' => 'Modify Deployment',
            'log' => $employee->item->toJson(),
            'user_id' => Auth::user()->id,
        ]);        

        return redirect()->route('ou.station.employees.show', compact('station', 'employee'))->with('status', 'Employee has been transfered.');
    }

    public function add(Station $station)
    {
        $stations = Station::select('id', 'code', 'name', 'office_id')
            ->orderBy('name', 'asc')
            ->get();

        return view('ou.station.employees.add', compact('station', 'stations'));
    }

    public function lookup(Station $station)
    {
        $searchString = request()->get('searchString');

        $employees = Employee::join('people', 'employees.person_id', '=', 'people.id')
            ->where(function ($query) use ($searchString){
                $query->where('lastname', 'like' , $searchString . '%')
                    ->orWhere('firstname', 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $searchString . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $searchString . '%')
                    ->orderBy('lastname', 'asc')
                    ->orderBy('firstname', 'asc');
        })
        ->select('employees.id AS empid', 'employees.*', 'people.*')
        ->paginate(15);

        $employees = $employees->appends(['searchString' => $searchString]);

        return view('ou.station.employees.lookup', compact('employees', 'station'));
    } 

    public function store(Station $station)
    {
        $data = request()->validate([
            'person_id' => ['required'],
            'deployment_station_id' => ['required'],
            ]);
         
        $person = Person::find($data['person_id']);
        $employee = $person->employee;

        $employee->item->deployment()->update(['station_id' => $data['deployment_station_id']]);

        $employee->employeelog()->create([
            'action' => 'Modify Deployment',
            'log' => $employee->toJson(),
            'user_id' => Auth::user()->id,
        ]); 

        $employee->item->itemlog()->create([
            'action' => 'Modify Deployment',
            'log' => $employee->item->toJson(),
            'user_id' => Auth::user()->id,
        ]);    

        return redirect()->route('ou.station.employees.show', compact('station', 'employee'))->with('status', 'Employee has been added.');
    } 
}
