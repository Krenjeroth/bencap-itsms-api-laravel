<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $with = ['item_type', 'brand_model'];

    protected $fillable = [
        'item_type_id',
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

    public function item_type() {
      return $this->belongsTo(ItemType::class);
    }
    public function brand_model() {
      return $this->belongsTo(BrandModel::class);
    }
}
