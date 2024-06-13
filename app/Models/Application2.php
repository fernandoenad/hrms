<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id',
        'application_code',
        'first_name',
        'middle_name',
        'last_name',
        'sitio',
        'barangay',
        'municipality',
        'zip',
        'age',
        'gender',
        'civil_status',
        'religion',
        'disability',
        'ethnic_group',
        'email',
        'phone',
        'station_id',
    ];


    protected $connection = 'mysql_2';

    protected $table = 'applications';

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy2::class);
    }

    public function assessment(): HasOne
    {
        return $this->hasOne(Assessment::class, 'application_id');
    }

    public function getFullname()
    {
        return $this->last_name . ', ' . $this->first_name . ' ' . substr($this->middle_name, 0, 1);
    }

    public function getAddress()
    {
        return $this->sitio . ', ' . $this->barangay . ', ' . $this->municipality . ' (' . $this->zip . ')';
    }
}
