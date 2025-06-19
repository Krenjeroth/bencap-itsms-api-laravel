<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $with = ['brand_model'];

    protected $fillable = [
        'brand_model_id',
        'parent_component',
        'code',
        'barcode',
        'description',
        'serial_number',
        'property_number',
        'ics_number',
        'date_acquired',
        'ip_address',
        'mac_address',
        'status',
        'inventory_type',
    ];

    public function brand_model() {
      return $this->belongsTo(BrandModel::class);
    }
}
