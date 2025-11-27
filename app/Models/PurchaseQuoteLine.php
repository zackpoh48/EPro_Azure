<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseQuoteLine extends Model
{
    use HasFactory;

    /**
     * Get the purchase quote that owns the line.
     */
    public function purchaseQuote(): BelongsTo
    {
        return $this->belongsTo(PurchaseQuote::class);
    }
}
