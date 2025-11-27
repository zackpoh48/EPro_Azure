<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Rfq extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'rfqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $guarded
     */
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany('App\Models\RfqItem', 'rfq_id', 'rfq_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            "user_rfqs",
            "rfq_id",
            "user_id"
        )->withTimestamps();
    }

    public function submissions()
    {
        return $this->hasMany('App\Models\RfqSubmission', 'rfq_id', 'rfq_id')
            ->where('user_id', request()->user()->id);
    }
}
