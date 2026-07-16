<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'ticket_tier_id', 'price', 'quantity'];

    public function order(): BelongsTo 
    { 
        return $this->belongsTo(Order::class); 
    }

    public function ticketTier(): BelongsTo 
    { 
        return $this->belongsTo(TicketTier::class); 
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}