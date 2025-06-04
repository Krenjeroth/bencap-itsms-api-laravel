<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonProblem extends Model
{
    protected $with = ['item_type'];
    protected $fillable = [
        'code',
        'general_term',
        'information',
        'item_type_id',
    ];

    public function item_type() {
      return $this->belongsTo(ItemType::class);
    }
}
