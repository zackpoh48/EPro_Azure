<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqItemSubmission extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'rfq_item_submissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $guarded
     */
    protected $guarded = [];
}
