<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'order_number',
    'user_id',
    'service_type',
    'table_code',
    'table_name',
    'pickup_date',
    'pickup_time',
    'customer_name',
    'customer_phone',
    'notes',
    'status',
    'subtotal',
    'total',
])]
class Order extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'pickup_date' => 'date',
            'pickup_time' => 'string',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tenantOrders(): HasMany
    {
        return $this->hasMany(TenantOrder::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}