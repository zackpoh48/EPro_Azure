<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSubmission extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'rfq_submissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $guarded
     */
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany('App\Models\RfqItemSubmission', 'rfq_submission_id', 'id');
    }
    public function vendorNumber()
    {
        return $this->belongsTo(User::class);
    }
}
