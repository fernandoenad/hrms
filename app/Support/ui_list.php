<?php 

function PRFreason($key=null){
    $array= [
        "Replacement",
        "Additional",
        "New Position"
    ];
    if ($key!==null && isset($array[$key])) {
        return $array[$key];
    }
    return $array;
}

function EmploymentType($key=null){
    $array = [
        "Trainee",
        "Organic",
        "Project-based"
    ];
    if ($key!==null && isset($array[$key])) {
        return $array[$key];
    }
    return $array;
}
function ThingsToPreparePRF($key=null){
    $array = [
        1 => "ID",
        2 => "Calling Card",
        3 => "ATM",
        4 => "Employment Contract",
        5 => "Laptop",
        6 => "Desktop",
        7 => "Smartphone",
        8 => 'Others...'
    ];
    if ($key!==null && isset($array[$key])) {
        return $array[$key];
    }
    return $array;
}


    /*IF $no_role is true then get all the company*/
function getAllCompanies($inactive = 0, $no_role = true) {
    $access = auth()->user()->CanAccess("ACCESS_ALL_COMPANY_BRANCH",true);

    if (session()->exists('companies')) {
        return session('companies');
    }
    $companies =  DB::table('companies')
    ->when(!$access && $no_role,function($query){
        return $query->where(function($q){
            return $q->where('id', auth()->user()->company_id)
            ->orWhereIn('id', auth()->user()->CompanyBranch->pluck('company_id','company_id')->toArray());
        });
    })
    ->whereInactive($inactive)->pluck('comp_name','id')->toArray();
    session(['companies'=>$companies]);
    return $companies;
}


function getBranches($company_id, $no_role = true) {

    if (session()->exists('branches.'.$company_id.(int)$no_role)) {
        return session('branches.'.$company_id.(int)$no_role);
    }
    $branches = DB::table('branches')->whereCompanyId($company_id)
    ->when(auth()->user()->CannotAccess("ACCESS_ALL_COMPANY_BRANCH") && $no_role,function($q){
        return $q->whereIn('id',auth()->user()->CurrentBranches());
    })
    ->whereInactive(0)->pluck('br_name','id')->toArray();
    session(['branches.'.$company_id.(int)$no_role=>$branches]);
    return $branches;
}
function getShifts($inactive = 0, $return_array = true) {
    return DB::table('shifts')->whereInactive($inactive)
    ->when($return_array,function($q){
        return $q->pluck('shift_name','id')->toArray();
    },function($q){
        return $q->get()->keyBy('id');
    });
}
function getScheduleShift($from_date=null, $to_date=null, $employee_id = null) {
    return DB::table('shift_schedules')
        ->selectRaw('shift_schedules.*, shifts.time_in, shifts.time_out, shifts.min_hours, shifts.max_hours, shifts.break_in, shifts.break_out, shifts.rest_days')
        ->Join('shifts','shifts.id','=','shift_schedules.shift_id')
        ->when($employee_id!==null,function($q)use($employee_id){
            if (is_array($employee_id)) {
                return $q->whereIn('shift_schedules.employee', $employee_id);
            }
            return $q->where('shift_schedules.employee', $employee_id);
        })
        ->when($employee_id!==null,fn($q)=>$q->where('shift_schedules.employee',$employee_id))
        ->when($from_date and $to_date,function($q)use($from_date, $to_date){
            return $q
           ->where(function($q)use($from_date, $to_date){
                return $q
                ->whereBetween('shift_schedules.from_date',[$from_date,$to_date])
                ->orwhereBetween('shift_schedules.to_date',[$from_date, $to_date])
                ->orWhereRaw('(? between shift_schedules.from_date and shift_schedules.to_date)',[$from_date])
                ->orWhereRaw('(? between shift_schedules.from_date and shift_schedules.to_date)',[$to_date])
                ->orWhere(function($q)use($from_date,$to_date){
                    return $q->where('shift_schedules.from_date', '<=', $from_date)
                    ->where('shift_schedules.to_date','>=', $to_date);
                })
                ;
           });
        })
       ->get();
}


function getDepartments($inactive = 0) {
    if (session()->exists('departments'.'-v2')) {
        return session('departments'.'-v2');
    }
    $departments = DB::table('departments')->whereInactive($inactive)->pluck('dep_name','id')->toArray();
    session(['departments'.'-v2' => $departments]);
    return $departments;
}


function getPayrollSched($inactive = 0) {
    return DB::table('payroll_schedules')->whereInactive($inactive)->pluck('sched_name','id')->toArray();
}


function getAllPositions($inactive = 0) {
    return DB::table('positions')->whereInactive($inactive)
    ->orderBy('job_title','asc')
    ->pluck('job_title','id')->toArray();
}


function getAllUserRole() {
    return DB::table('user_roles')->whereInactive(0)->pluck('role_name','id')->toArray();
}

define('S_PENDING', 1);
define('S_APPROVED', 2);
define('S_REJECTED', 3);
define('S_CANCELLED', 4);
define('S_APPROVED_HR', 5);
define('S_APPROVED_CEO', 6);
define('S_VOIDED', 7);
define('S_SERVED', 8);
define('S_APPROVE_FINANCE', 9);
define('S_APPROVE_DEP_HEAD', 10);
define('S_FOR_APPROVAL', 11);
define('S_POSTED', 12);
define('S_HRH_APPROVAL', 13);
define('S_OPEN_CASE', 14);
define('S_CLOSED', 20);

function globalStatus($key=null){
    $stat =  [
        S_PENDING => "Pending",
        S_APPROVED => "Approved",
        S_APPROVED_HR => "Approved By HR Head",
        S_REJECTED => "Rejected",
        S_CANCELLED => "Cancelled",
        S_APPROVED_CEO => "Approved By General Manager",
        S_APPROVE_FINANCE => "Approved By Finance Head",
        S_APPROVE_DEP_HEAD => "Approved By Department Head",
        S_VOIDED => "Voided",
        S_SERVED => "Served",
        S_FOR_APPROVAL => "For Approval",
        S_POSTED => "Posted",
        S_HRH_APPROVAL => "HR Head Approval",
        S_CLOSED => "Closed",
        S_OPEN_CASE => "Open Case"
    ];
    
    if ($key!==null && isset($stat[$key])) {
        return $stat[$key];
    }
    return $stat;
}

function BioStatus($key = null){
    $array =  [
        0 => "Time-in",
        1 => "Time-out",
        2 => "Break-in",
        3 => "Break-out",
        4 => "Overtime-in",
        5 => "Overtime-out",
    ];
    if ($key!==null) {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return "Status Not Found...";
    }
    return $array;
}
function getAllOvertime($active = true, $return_array = true){
    return App\Admin\Model\Overtime::query()
    ->where('active',$active)
    ->when($return_array,function($q){
        return $q->pluck('overtime_name','id')->toArray();
    },function($q){
        return $q->get()->keyBy('id');
    });
}
function getAllLeaveTypes($active = true, $return_array = true){
    return DB::table('leaves')
    ->when($active!==null,fn($q)=>$q->whereActive($active))
    ->when($return_array,function($q){
        return $q->pluck('leave_name','id')->toArray();
    },function($q){
        return $q->get()->keyBy('id');
    })
    ;
}
define('R_LEAVE',1);
define('R_OB',2);
define('R_UT',3);
define('R_WFH',4);

function getRequestFor($key = null){
    $array = [
        R_LEAVE => "Leave",
        R_OB => "Official Business",
        R_UT => "Undertime",
        R_WFH => "Work From Home"  
    ];  
    if ($key!==null) {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return "";
    }
    return $array;
}

function getRequestForShort($key = null){
    $array = [
        R_LEAVE => 'Leave',
        R_OB => 'OB',
        R_UT => 'UT',
        R_WFH => 'WFH'  
    ];  
    if ($key!==null) {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return "";
    }
    return $array;
}

//PAYROLL TYPES
define('P_DAILY', 1);
define('P_WEEKLY', 2);
define('P_MONTHLY', 3);
define('P_SEMI_MONTHLY', 4);

function getPayrollTypes($key = null){
    $array = [
        P_DAILY => "Daily",
        P_WEEKLY => "Weekly",
        P_MONTHLY => "Monthly",
        P_SEMI_MONTHLY => "Semi-Monthly",
    ];  
    if ($key!==null) {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return "";
    }
    return $array;
}
function getHolidayTypes($active=true, $return_array = true){
    return DB::table('holiday_types')->whereActive($active)
    ->when($return_array, function($q){
        return $q->pluck('holiday_type_name','id')->toArray();
    },function($q){
        return $q->get()->keyBy('id');
    });
}

function getHolidays($active=1,  $include_company_branch = false, $from_date=null, $to_date=null){
    return \App\Admin\Model\Holiday::query()
    ->selectRaw('holidays.*, holiday_types.percentage, holiday_types.percentage, holiday_types.short_name, holiday_types.type as holiday_type, holiday_types.holiday_type_name')
    ->Join('holiday_types','holiday_types.id','=','holidays.type')
    ->where('holidays.active', $active)
    ->when($from_date and $to_date,function($q)use($from_date,$to_date){
        return $q->whereBetween('holidays.date',[$from_date,$to_date]);
    })
    ->when($include_company_branch,fn($q)=>$q->with('CompanyBranch','ExceptCompanyBranch'))
    ->get()
    ->keyBy('id');
}

function getLoanTypes($active = null){
    return DB::table('loans')
    ->when($active!==null,fn($q)=>$q->where('active',$active))
    ->get()->keyBy('id');
}
function getContributions($active = null){
    return DB::table('contributions')
    ->when($active!==null,fn($q)=>$q->where('active',$active))
    ->get()->keyBy('id');
}
function getContributionRange(){
    return \App\Admin\Model\ContributionRange::with('Rates')->get();
}
function getCustomPayrollColumns($active=null){
    return DB::table('payroll_columns')
    ->when($active!==null,fn($q)=>$q->where('active',$active))
    ->get()->keyBy('id');
}
function getTaxes(){
    return DB::table('taxes')
    ->where('year',date("Y"))
    ->get();
}
function getPayrollGroups($active=true, $return_array = true){
    return DB::table('payroll_groups')->whereActive($active)
    ->when($return_array, function($q){
        return $q->pluck('payroll_group_name','id')->toArray();
    },function($q){
        return $q->get()->keyBy('id');
    });
}


function getBanks(){
    return DB::table('banks')
    ->where('active',1)
    ->pluck('bank_name','id')
    ->toArray();
}

function getIrStatus($row){
    if ( $row->rejected_at ) {
      $status = '<span class="badge bg-red text-red-fg">Rejected</span>';
    }elseif( $row->nte_issued_at ){
      $status = '<span class="badge bg-blue text-blue-fg">NTE Issued</span>';
    }elseif( $row->received_at ){
      $status = '<span class="badge bg-green text-green-fg">Received By HR</span>';
    }else{
      $status = '<span class="badge bg-yellow text-yellow-fg">For HR Approval</span>';
    }
    return $status;
}
function getNteStatus($row){
    if ( $row->rejected_at ) {
      $status = '<span class="badge bg-red text-red-fg">Rejected</span>';
    }elseif( $row->approved_at ){
      $status = '<span class="badge bg-green text-green-fg">Confirmed By Head</span>';
    }elseif($row->hr_approved_by){
      $status = '<span class="badge bg-blue text-blue-fg">For Head Approval</span>';
    }else{
      $status = '<span class="badge bg-blue text-blue-fg">For HR Head Approval</span>';
    }
    return $status;
}