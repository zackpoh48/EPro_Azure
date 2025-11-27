<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqItem extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'rfq_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $guarded
     */
    protected $guarded = [];

    public function rfq()
    {
        return $this->hasOne('App\Models\Rfq', 'rfq_id');
    }
}
