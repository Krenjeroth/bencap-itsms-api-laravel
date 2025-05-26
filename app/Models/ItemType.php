<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $fillable = [
        'classification',
        'purpose',
        'status',
    ];
}
