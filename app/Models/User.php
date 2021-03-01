<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }


    public function userrole()
    {
        return $this->hasmany(UserRole::class);
    }

    public function userlog()
    {
        return $this->hasmany(UserLog::class);
    }

    public function applicationlog()
    {
        return $this->hasmany(ApplicationLog::class);
    }

    public function personlog()
    {
        return $this->hasmany(PersonLog::class);
    }

    public function employeelog()
    {
        return $this->hasmany(EmployeeLog::class);
    }

    public function accountrequest()
    {
        return $this->hasmany(AccountRequest::class);
    }

    public function puserlog()
    {
        return $this->hasmany(PUserLog::class);
    }

    public function itemlog()
    {
        return $this->hasmany(ItemLog::class);
    }

    public function getNameAttribute($value){
        return ucwords(mb_strtolower($value));
    }

    public function getUserType()
    {
        return isset(Auth::user()->person->employee->item_id) ? 'Employee' : 'Applicant';
    }

    public function getCreatedatAttribute($value){
        return Carbon::parse($value)->format('F d, Y');
    }

    public function hasRole($route)
    {
        $result = $this->userrole()->where('status', '=', 1)
            ->where(function ($query) use ($route){
                $query->where('route', 'like', $route)
                    ->orWhere('role_id', '=', 1);
            })->first();


        if(isset($result)) 
            return true;

        return false;
    }

    public function isAdmin($route)
    {
        $result = $this->userrole->where('route', 'like', $route)
            ->where('role_id', '=', 2)
            ->where('status', '=', 1);

        if (sizeof($result) > 0)
            return true;
        else if (Auth::user()->userrole->first()->role_id == 1)
            return true;

        return false;
    }

    public function isSuperAdmin()
    {
        $result = $this->userrole->where('role_id', '=', 1)
            ->where('status', '=', 1);

        if (sizeof($result) > 0)
            return true;

        return false;
    }

    public function isStationPersonnel($station_id)
    {
        $result = $this->person->station->where('id', '=', $station_id)
            ->first();

        if (isset($result)) 
            return true;

        return false;
    }

    public function getStations()
    {
        /*
        if($this->isSuperAdmin())
            $stations = Station::orderBy('name', 'asc');
        else
            $stations = Station::where('person_id', '=', $this->person->id);
        */
        $stations = Station::where('person_id', '=', $this->person->id);
        
        return $stations;
    }
    
}
