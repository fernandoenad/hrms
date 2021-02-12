<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'fiscalcategory',
        'code',
        'name',
        'services',
        'office_id',
        'address',
        'category',
        'person_id',
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

    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function deployment()
    {
        return $this->hasOne(Deployment::class);
    }

    public function application()
    {
        return $this->hasOne(Application::class);
    }


    public function getTypeAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}
