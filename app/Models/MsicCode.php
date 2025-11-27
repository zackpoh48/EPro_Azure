<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsicCode extends Model
{
    use HasFactory;

    public function save(array $options = [])
    {
        throw new \Exception('This model is read-only.');
    }

    public function delete()
    {
        throw new \Exception('This model is read-only.');
    }
}
