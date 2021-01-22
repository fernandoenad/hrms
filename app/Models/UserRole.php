<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'route',
        'user_id',
        'role_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRole($role_id)
    {
        switch($role_id)
        {
            case 1:
                $role = "Administrator";
                break;
            case 2:
                $role = "Manager";
                break;
            case 3:
                $role = "User";
                break;
            default:
                $role = "Invalid role";
        }

        return $role;
    }


    public function getStatus($status_id)
    {
        switch($status_id)
        {
            case 1:
                $status = "Active";
                break;
            case 2:
                $status = "Inactive";
                break;
            default:
                $status = "Invalid role";
        }

        return $status;
    }
}
