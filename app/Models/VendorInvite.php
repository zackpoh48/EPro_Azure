<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorInvite extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'vendor_invites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $guarded
     */
    protected $guarded = [];
}
