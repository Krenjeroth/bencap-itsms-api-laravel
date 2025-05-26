<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCost extends Model
{
    protected $fillable = [
        'cost',
        'start_date',
        'end_date',
        'status',
    ];

    public function item() {
      return $this->belongsTo(Item::class);
    }
}
