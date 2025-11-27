<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    // protected $casts = [
    //     "status" => StatusEnum::class,
    // ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            "user_companies",
            "company_id",
            "user_id"
        );
    }

    /**
     * Get the status for the company.
     */
    public function statusLogs(): HasMany
    {
        return $this->hasMany(StatusLog::class);
    }
}
