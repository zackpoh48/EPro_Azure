<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["name", "email", "password"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
        // "status" => StatusEnum::class,
    ];

    /**
     * Get the delivery orders for the user.
     */
    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    /**
     * Get the puchase quotes for the user.
     */
    public function purchaseQuotes(): HasMany
    {
        return $this->hasMany(PurchaseQuote::class);
    }

    public function companies()
    {
        return $this->belongsToMany(
            Company::class,
            "user_companies",
            "user_id",
            "company_id"
        );
    }

    public function rfqs()
    {
        return $this->belongsToMany(
            Rfq::class,
            "user_rfqs",
            "user_id",
            "rfq_id"
        )->withTimestamps();
    }
}
