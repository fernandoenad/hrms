<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empno',
        'hiredate',
        'step',
        'lastapptdate',
        'lastnosidate',
        'retirementdate',
        'employmentstatus',
        'tinno',
        'gsisbpno',
        'pagibigid',
        'philhealthno',
        'dbpaccountno',
        'item_id',
        'station_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'hiredate' => 'date',
        'lastapptdate' => 'date',
        'lastnosidate' => 'date',
        'retirementdate' => 'date',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function getHiredateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F d, Y') : null;
    }

    public function getLastapptdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F d, Y') : null;
    }

    public function getLastnosidateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F d, Y') : null;
    }

    public function getRetirementdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F d, Y') : null;
    }

    public function getYearsInService()
    {
        return $this->hiredate ? Carbon::parse($this->hiredate)->age : null;
    }

    public function getStatus()
    {
        return $this->item_id == 0 ? 'Inactive' : 'Active';
    }
}
