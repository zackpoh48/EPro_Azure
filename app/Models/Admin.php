<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Organization;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * @var string $table
     */
    protected $table = "admins";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["name", "email", "password", "organization_id"];

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(
            new \App\Notifications\MailResetPasswordNotification($token)
        );
    }

    
    public function organization() {
        return $this->belongsTo(Organization::class);
    }
}
