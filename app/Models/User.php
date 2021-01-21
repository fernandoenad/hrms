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

        if ($this->userrole()->where('status', '=', 1)->first() &&
            ($this->userrole()->where('route', '=', $route)->first() ||
            $this->userrole()->where('role_id', '=', 1)->first())) 
        {
            return true;
        }

        return false;
    }
    
}
