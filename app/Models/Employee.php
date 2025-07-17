<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'address',
        'contact_num',
        'birthdate',
        'date_hired',
        'position_id',
        'employment_status_id',
        'div_sec_unit_id'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'date_hired' => 'date',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class, 'employment_status_id');
    }

    public function divSecUnit()
    {
        return $this->belongsTo(DivSecUnit::class, 'div_sec_unit_id');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
