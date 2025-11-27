<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'registrations';

    protected $fillable = [
        'name_of_company',
    ];
    public function vendorInfo()
    {
        return $this->hasOne(VendorInvite::class, 'id', 'invite_id');
    }
}
