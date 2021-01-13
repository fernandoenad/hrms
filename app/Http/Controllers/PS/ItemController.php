<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

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

        $items_a = $this->itemsAllCounter();
        $items_un = $this->itemsUnfilledCounter();

        return view('ps.items.index', compact('items', 'items_un', 'items_a'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');
        
        $items = Item::where('itemno', 'LIKE' , '%' . $searchString)
            ->paginate(15);

        $items = $items->appends(['searchString' => $searchString]);

        $items_a = $this->itemsAllCounter();
        $items_un = $this->itemsUnfilledCounter();

        return view('ps.items.index', compact('items', 'items_un', 'items_a'));
    }

    public function displayUnfilled()
    {
        $items = Item::whereNotIn('items.id', function($query){
                $query->select('item_id')->from('employees');
            })
            ->paginate(15);

        $items_a = $this->itemsAllCounter();
        $items_un = $this->itemsUnfilledCounter();
        
        return view('ps.items.index', compact('items', 'items_un', 'items_a'));
    }

    public function show(Item $item)
    {
        return view('ps.items.show', compact('item'));
    }

    public function itemsAllCounter()
    {
        $items = Item::all()->count();

        return $items;
    }

    public function itemsUnfilledCounter()
    {
        $items = Item::whereNotIn('items.id', function($query){
            $query->select('item_id')->from('employees');
        })->count();

        return $items;
    }

    public function create()
    {
        $items_a = $this->itemsAllCounter();
        $items_un = $this->itemsUnfilledCounter();

        return view('ps.items.create', compact('items_un', 'items_a'));
    }

}
