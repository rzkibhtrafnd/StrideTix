<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'customer_name',
        'customer_email',
        'customer_phone', 'invoice_number', 'midtrans_transaction_id', 'midtrans_snap_token',
        'midtrans_redirect_url', 'total_original_price', 'gross_amount',
        'payment_status', 'payment_method', 'va_number', 'payment_provider_channel', 'paid_at'
    ];

    public function user(): BelongsTo { 
        return $this->belongsTo(User::class); 
    }

    public function items(): HasMany { 
        return $this->hasMany(OrderItem::class); 
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('payment_status', $status);
        })->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($subQuery) use ($search) {
                $subQuery->where('invoice_number', 'like', '%' . $search . '%')
                        ->orWhere('customer_name', 'like', '%' . $search . '%');
            });
        });
    }

    public function scopeForOrganizer(Builder $query, ?int $organizerId): Builder
    {
        if (!$organizerId) {
            return $query->where('id', 0);
        }

        return $query->whereHas('items.ticketTier.raceCategory.event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        });
    }

    public function scopeFormAbandoned(Builder $query): Builder
    {
        return $query->where('payment_status', 'pending')
            ->where('created_at', '<', Carbon::now()->subMinutes(10))
            ->whereDoesntHave('items.participants');
    }

    public function scopePaymentExpired(Builder $query): Builder
    {
        return $query->where('payment_status', 'pending')
            ->where('updated_at', '<', Carbon::now()->subMinutes(7))
            ->whereHas('items.participants');
    }
}