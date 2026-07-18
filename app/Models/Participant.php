<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\IdentityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    protected $fillable = [
        'order_item_id', 'full_name', 'gender', 'date_of_birth',
        'identity_type', 'identity_number', 'blood_type', 'jersey_size',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_relation'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'gender' => Gender::class,
        'identity_type' => IdentityType::class,
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }
}