<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}