<?php

namespace App\Http\Controllers\PU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Dropdown;
use App\Models\Station;
use Illuminate\Validation\Rule;

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
        $items_ua = $this->itemsUnassignedCounter();

        return view('pu.items.index', compact('items', 'items_un', 'items_a', 'items_ua'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $items = Item::where('itemno', 'LIKE' , '%' . $searchString)
            ->paginate(15);

        $items = $items->appends(['searchString' => $searchString]);

        $items_a = $this->itemsActiveCounter();
        $items_un = $this->itemsUnfilledCounter();
        $items_ua = $this->itemsUnassignedCounter();

        return view('pu.items.index', compact('items', 'items_un', 'items_a', 'items_ua'));
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
        $items_ua = $this->itemsUnassignedCounter();
        
        return view('pu.items.index', compact('items', 'items_un', 'items_a', 'items_ua'));
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
        $items_ua = $this->itemsUnassignedCounter();
        
        return view('pu.items.index', compact('items', 'items_un', 'items_a', 'items_ua'));
    }

    public function displayUnassigned()
    {
        $items = Item::where('status', '=', 1)
            ->where('station_id', '=', 0)->paginate(15);

        $items_a = $this->itemsActiveCounter();
        $items_un = $this->itemsUnfilledCounter();
        $items_ua = $this->itemsUnassignedCounter();
        
        return view('pu.items.index', compact('items', 'items_un', 'items_a', 'items_ua'));
    }

    public function show(Item $item)
    {
        return view('pu.items.show', compact('item'));
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

    public function itemsUnassignedCounter()
    {
        $items = Item::where('status', '=', 1)
            ->where('station_id', '=', 0)
            ->count();

        return $items;
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

         return view('pu.items.edit', compact('item', 'positions', 'employeetypes', 'stations'));
    }

    public function update(Item $item)
    {
        $data = request()->validate([
            'itemno' => ['required'],
            'creationdate' => ['required'],
            'position' => ['required'],
            'salarygrade' => ['required'],
            'employeetype' => ['required'],
            'station_id' => ['required'],
            'deployment_station_id' => ['required'],
        ]);
       
        $item->update($data);

        $item->deployment()->update(['station_id' => $data['deployment_station_id']]);
        
        return redirect()->route('pu.items.show', compact('item'))->with('status', 'Item updated!'); 
    }

}
