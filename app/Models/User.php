<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class User extends Authenticatable
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

    public function getNameAttribute($value){
        return ucwords($value);
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
        //dd($result->role_id);

        if(isset($result)) 
        {
            return true;
        }

        return false;
    }

    public function isAdmin($route)
    {
        $result = $this->userrole()->where('status', '=', 1)
            ->where('route', 'like', $route)
            ->where('role_id', '<', 3)
            ->orWhere('role_id', '=', 1)
            ->first();

        //dd($result->role_id);

        if (isset($result)) 
        {
            return true;
        }

        return false;
    }
    
}
