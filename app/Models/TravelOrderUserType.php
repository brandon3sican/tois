<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelOrderUserType extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $table = 'travel_order_user_types';
}
