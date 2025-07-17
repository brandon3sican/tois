<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelOrderStatus extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $table = 'travel_order_statuses';
}
