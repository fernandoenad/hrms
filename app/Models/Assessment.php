<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable =[
        'application_id',
        'template_id',
        'assessment',
        'score',
        'status',
    ];

    protected $connection = 'mysql_2';

    protected $table = 'assessments';

    public function getStatus()
    {
        if($this->status == 4){
            $status_name = "Disqualified";
        } else if($this->status == 0){
            $status_name = "New";
        } else if($this->status == 1){
            $status_name = "Pending";
        } else {
            $status_name = "Qualified";
        }

        return $status_name;
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application2::class, 'application_id');
    }


}
