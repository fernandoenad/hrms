<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PBBReport extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'town_id',
        'station_id',
        'employee_id',
        'empno',
        'length_of_service',
        'salary_grade',
        'step',
        'ipcr_score',
        'qualified',
        'status',
        'user_id',
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

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getpbbstatus($status)
    {
        switch($status){
            case 1: 
                $status_pbb = 'Qualified';
                break;
            case 2:
                $status_pbb = 'Not Qualified';
                break;
        }

        return $status_pbb;
    }

    public function getapprovaltatus($status)
    {
        switch($status){
            case 1: 
                $status_approval = 'Approved';
                break;
            case 2:
                $status_approval = 'Pending';
                break;
        }

        return $status_approval;
    }

}
