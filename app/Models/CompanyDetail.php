<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'company_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $guarded
     */
    protected $guarded = [];
}
