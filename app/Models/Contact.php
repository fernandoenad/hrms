<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'primaryno',
        'secondaryno',
        'emergencyperson',
        'emergencyrelation',
        'emergencyaddress',
        'emergencycontact',
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
    protected $casts = [];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function getEmergencypersonAttributes($value)
    {
        return ucwords($value);
    }

    public function getEmergencyrelationAttributes($value)
    {
        return ucwords($value);
    }

    public function getEmergencyaddressAttributes($value)
    {
        return ucwords($value);
    }

}
