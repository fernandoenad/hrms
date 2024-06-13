<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'author',
        'message',
        'status',
    ];


    protected $connection = 'mysql_2';

    protected $table = 'inquiries';
}
