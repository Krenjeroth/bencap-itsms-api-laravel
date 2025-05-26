<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonProblem extends Model
{
    protected $fillable = [
        'code',
        'general_term',
        'information',
    ];

    public function item_type() {
      return $this->belongsTo(ItemType::class);
    }
}
