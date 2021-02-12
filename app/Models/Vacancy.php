<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'salarygrade',
        'vacancylevel',
        'curricularlevel',
        'qualifications',
        'vacancy',
        'status',
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

    public function application()
    {
        return $this->hasMany(Application::class);
    }

    public function getvacancylevel($vacancylevel)
    {
        switch($vacancylevel){
            case 1: 
                $vacancylevel_name = 'School';
                break;
            case 2: 
                $vacancylevel_name = 'District';
                break;
            case 3: 
                $vacancylevel_name = 'Division';
                break;
        }

        return $vacancylevel_name;
    }

    public function getstatus($status)
    {
        switch($status){
            case 0: 
                $status_name = 'Close';
                break;
            case 1: 
                $status_name = 'Open';
                break;
        }

        return $status_name;
    }

    public function getstatuscolor($status)
    {
        switch($status){
            case 0: 
                $status_color = 'danger';
                break;
            case 1: 
                $status_color = 'success';
                break;
        }

        return $status_color;
    }
}
