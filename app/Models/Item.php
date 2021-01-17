<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'itemno',
        'creationdate',
        'position',
        'salarygrade',
        'employeetype',
        'appointmentdate',
        'firstdaydate',
        'status',
        'remarks',
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
        'creationdate' => 'date',
        'appointmentdate' => 'date',
        'firstdaydate' => 'date',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function deployment()
    {
        return $this->hasOne(Deployment::class);
    }

    public function getItemnoAttribute($value)
    {
        return strtoupper($value);
    }

    public function getCreationdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F d, Y') : null;
    }

    public function getAppointmentdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F d, Y') : null;
    }

    public function getFirstdaydateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F d, Y') : null;
    }

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Inactive';
    }

}
