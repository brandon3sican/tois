<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelOrder extends Model
{
    protected $fillable = [
        'region',
        'province',
        'municipality',
        'station',
        'date',
        'time',
        'destination',
        'purpose',
        'status',
        'user_id',
        'recommending_approval_id',
        'approved_by_id',
        'travel_order_status_id',
        'travel_order_user_type_id',
        'recommendation_notes',
        'approval_notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recommendingApproval(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recommending_approval_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TravelOrderStatus::class, 'travel_order_status_id');
    }

    public function userType(): BelongsTo
    {
        return $this->belongsTo(TravelOrderUserType::class, 'travel_order_user_type_id');
    }

    public function signatories(): HasMany
    {
        return $this->hasMany(TravelOrderSignatory::class);
    }
}
