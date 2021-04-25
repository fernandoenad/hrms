<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Person extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'firstname',
        'middlename',
        'lastname',
        'extname',
        'sex',
        'dob',
        'civilstatus',
        'image',
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
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }
    
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function station()
    {
        return $this->hasMany(Station::class);
    }

    public function application()
    {
        return $this->hasMany(Application::class);
    }

    public function office()
    {
        return $this->hasMany(Office::class);
    }

    public function accountrequest()
    {
        return $this->hasMany(AccountRequest::class);
    }

    public function personlog()
    {
        return $this->hasMany(PersonLog::class);
    }

    public function getFirstnameAttribute($value){
        return ucwords(mb_strtolower($value));
    }

    public function getLastnameAttribute($value){
        return ucwords(mb_strtolower($value));
    }

    public function getMiddlenameAttribute($value){
        return ucwords(mb_strtolower($value));
    }

    public function getDobAttribute($value){
        return Carbon::parse($value)->format('F d, Y');
    }

    public function getAge()
    {
        return Carbon::parse($this->dob)->age." years old";
    }

    public function getFullname()
    {
        return ucwords(mb_strtolower($this->firstname)). " " . mb_strtoupper($this->lastname) . " " . $this->extname;
    }

    public function getFullnameBox()
    {
        return ucwords(mb_strtolower($this->firstname. " " . $this->lastname . " ")) . $this->extname;
    }

    public function getFullnameSorted()
    {
        return mb_strtoupper($this->lastname) . ", " .ucwords( $this->firstname . " " . $this->middlename) . " " . $this->extname;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F d, Y') : null;
    }
}
