<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryOrderLine extends Model
{
    use HasFactory;

    /**
     * Get the delivery order that owns the line.
     */
    public function deliveryOrder(): BelongsTo
    {
        return $this->belongsTo(DeliveryOrder::class);
    }
}
