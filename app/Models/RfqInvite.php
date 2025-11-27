<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class RfqInvite extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * @var string $table
     */
    protected $table = 'rfq_invites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $guarded
     */
    protected $guarded = [];
}
