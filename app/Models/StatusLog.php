<?php

namespace App\Models;

use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusLog extends Model
{
    use HasFactory;
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["reason", "status", "user_id", "admin_id", "company_id"];

    protected $casts = [
        "status" => StatusEnum::class,
    ];

    /**
     * Get the company that owns the log.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
