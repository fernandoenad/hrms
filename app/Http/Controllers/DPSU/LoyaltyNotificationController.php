<?php

namespace App\Http\Controllers\DPSU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class LoyaltyNotificationController extends Controller
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
        $qual_count = $this->getLoyaltyQualifiers()->count();
        $qual_list = $this->getLoyaltyQualifiers()->paginate(15);

        return view('dpsu.loyalty.index', compact('qual_count', 'qual_list'));
    }

    public function search()
    {
        $searchString = request()->get('searchString');

        $qual_count = $this->getLoyaltyQualifiers()->count();
        $qual_list = $this->getLoyaltyQualifiersSearch($searchString);

        return view('dpsu.loyalty.index', compact('qual_count', 'qual_list'));
    }

    public function getLoyaltyQualifiers()
    {
        $employees = Employee::where('item_id', '!=', 0)
            ->where('retirementdate', '=', null)
            ->where('hiredate', '>=', 'DATE_SUB(NOW(),INTERVAL 10 YEARS)');
        
        return $employees;
    }

    public function getLoyaltyQualifiersSearch($searchString)
    {  
        $qual_list = Employee::join('people', 'person_id', '=', 'people.id')
            ->where('lastname', 'like' , $searchString . '%')
            ->orWhere('firstname', 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(", ", lastname, firstname)'), 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(" ", firstname, lastname)'), 'like', $searchString . '%')
            ->orWhere(DB::raw('CONCAT_WS(" ", firstname, middlename, lastname)'), 'like', $searchString . '%')
            ->where('retirementdate', '=', null)
            ->where('hiredate', '>=', 'DATE_SUB(NOW(),INTERVAL 10 YEARS)')
            ->paginate(15);
        
        $qual_list = $qual_list->appends(['searchString' => $searchString]);

       return $qual_list;       
    }
}
