<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'vacancy_id',
        'code',
        'schoolyear',
        'pertdoc_soft',
        'pertdoc_hard',
        'type',
        'remarks',
        'status',
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
    protected $casts = [];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function getStatus($status)
    {
        switch($status){
            case 1:
                $status_name = 'New';
                break;
            case 2:
                $status_name = 'Pending';
                break;
            case 3:
                $status_name = 'Resolved';
                break;
        }

        return $status_name;
    }

    public function getStatusColor($status)
    {
        switch($status){
            case 1:
                $status_color = 'danger';
                break;
            case 2:
                $status_color = 'warning';
                break;
            case 3:
                $status_color = 'success';
                break;
        }

        return $status_color;
    }
}
