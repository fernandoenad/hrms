<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Dropdown;
use App\Models\Station;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
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
        $items = Item::paginate(15);

        $items_a = $this->itemsActiveCounter();
        $items_un = $this->itemsUnfilledCounter();
        $items_da = $this->itemsDeactivatedCounter();

        return view('ps.items.index', compact('items', 'items_un', 'items_a', 'items_da'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $items = Item::where('itemno', 'LIKE' , '%' . $searchString)
            ->paginate(15);

        $items = $items->appends(['searchString' => $searchString]);

        $items_a = $this->itemsActiveCounter();
        $items_un = $this->itemsUnfilledCounter();
        $items_da = $this->itemsDeactivatedCounter();

        return view('ps.items.index', compact('items', 'items_un', 'items_a', 'items_da'));
    }

    public function displayActive()
    {
        $items = Item::where('status', '=', 1)
            ->whereIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->paginate(15);

        $items_a = $this->itemsActiveCounter();
        $items_un = $this->itemsUnfilledCounter();
        $items_da = $this->itemsDeactivatedCounter();
        
        return view('ps.items.index', compact('items', 'items_un', 'items_a', 'items_da'));
    }

    public function displayUnfilled()
    {
        $items = Item::where('status', '=', 1)
            ->whereNotIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->paginate(15);

        $items_a = $this->itemsActiveCounter();
        $items_un = $this->itemsUnfilledCounter();
        $items_da = $this->itemsDeactivatedCounter();
        
        return view('ps.items.index', compact('items', 'items_un', 'items_a', 'items_da'));
    }

    public function displayDeactivated()
    {
        $items = Item::where('status', '=', 0)->paginate(15);

        $items_a = $this->itemsActiveCounter();
        $items_un = $this->itemsUnfilledCounter();
        $items_da = $this->itemsDeactivatedCounter();
        
        return view('ps.items.index', compact('items', 'items_un', 'items_a', 'items_da'));
    }

    public function show(Item $item)
    {
        return view('ps.items.show', compact('item'));
    }

    public function itemsActiveCounter()
    {
        $items = Item::where('status', '=', 1)
            ->whereIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })->count();

        return $items;
    }

    public function itemsUnfilledCounter()
    {
        $items = Item::where('status', '=', 1)
            ->whereNotIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->count();

        return $items;
    }

    public function itemsDeactivatedCounter()
    {
        $items = Item::where('status', '=', 0)->count();

        return $items;
    }

    public function create()
    {
        $positions = Item::groupBy('position')
            ->select('position')
            ->get();
        
        $employeetypes = Dropdown::where('type', '=', 'employeetype')
            ->get();    

        $stations = Station::select('id', 'code', 'name', 'office_id')
            ->orderBy('code', 'asc')
            ->get();
        
        $itemlevels = Dropdown::where('type', '=', 'itemlevel')
            ->get();  

            
       
        return view('ps.items.create', compact('positions', 'employeetypes', 'stations', 'itemlevels'));
    }

    public function store()
    {
        $data = request()->validate([
            'itemno' => ['required', 'string', 'min:25', 'max:255', 'regex:/^[a-zA-Z0-9-]*$/', 'unique:items'],
            'level' => ['required'],
            'creationdate' => ['required', 'date', 'before_or_equal: today'],
            'position' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'salarygrade' => ['required'],
            'employeetype' => ['required'],
            'station_id' => ['required'],
            'deployment_station_id' => ['required'],
        ]);

        $item = Item::create(array_merge($data, ['status' => 1]));

        $item->deployment()->create(['station_id' => $data['deployment_station_id']]);

        $item->itemlog()->create([
            'action' => 'Create',
            'log' => $item->toJson(),
            'user_id' => Auth::user()->id,
        ]); 

        return redirect()->route('ps.items.show', compact('item'))->with('status', 'Item created!'); 
    }


    public function edit(Item $item)
    {
        $positions = Item::groupBy('position')
            ->select('position')
            ->get();
        
        $employeetypes = Dropdown::where('type', '=', 'employeetype')
            ->get();    

        $stations = Station::select('id', 'code', 'name', 'office_id')
            ->orderBy('code', 'asc')
            ->get();
        
        $itemlevels = Dropdown::where('type', '=', 'itemlevel')
        ->get();  

         return view('ps.items.edit', compact('item', 'positions', 'employeetypes', 'stations', 'itemlevels'));
    }

    public function update(Item $item)
    {
        $data = request()->validate([
            'itemno' => ['required', 'string', 'min:25', 'max:255', 'regex:/^[a-zA-Z0-9-]*$/', Rule::unique('items')->ignore($item->id)],
            'creationdate' => ['required', 'date', 'before: today'],
            'position' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'salarygrade' => ['required'],
            'employeetype' => ['required'],
            'station_id' => ['required'],
            'deployment_station_id' => ['required'],
        ]);
       
        $item->update($data);

        $item->deployment()->update(['station_id' => $data['deployment_station_id']]);

        $item->itemlog()->create([
            'action' => 'Modify',
            'log' => $item->toJson(),
            'user_id' => Auth::user()->id,
        ]); 
        
        return redirect()->route('ps.items.show', compact('item'))->with('status', 'Item updated!'); 
    }

    public function deactivate(Item $item)
    {

        return view('ps.items.deactivate', compact('item'));
    }

    public function deactivatedone(Item $item)
    {
        $data = request()->validate([
            'remarks_old' => [''],
            'remarks' => ['required', 'string', 'min:5', 'max:255', 'regex:/^[a-zA-Z0-9\s-]*$/'],
        ]);
       
        $item->update(array_merge($data, ['status' => 0, 'remarks' =>  $data['remarks_old'] . '/' . $data['remarks'] ]));
        
        return redirect()->route('ps.items.show', compact('item'))->with('status', 'Item updated!'); 
    }

    public function activate(Item $item)
    {

        return view('ps.items.activate', compact('item'));
    }

    public function activatedone(Item $item)
    {
        $data = request()->validate([
            'remarks_old' => [''],
            'remarks' => ['required', 'string', 'min:5', 'max:255', 'regex:/^[a-zA-Z0-9\s-]*$/'],
        ]);
       
        $item->update(array_merge($data, ['status' => 1, 'remarks' =>  $data['remarks_old'] . '/' . $data['remarks'] ]));
        
        return redirect()->route('ps.items.show', compact('item'))->with('status', 'Item updated!'); 
    }

}
