<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    protected $fillable = [
        'name',
        'image',
        'year_released',
        'status',
    ];

    public function brand() {
      return $this->belongsTo(Brand::class);
    }
}
