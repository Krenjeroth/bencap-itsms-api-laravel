<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryInternalComponent extends Model
{
    protected $fillable = [
        'desktop_inventory_id', 'brand_model_id', 'specific_serial_number', 'slot', 'quantity', 'notes'
    ];

    public function desktopInventory() {
        return $this->belongsTo(Inventory::class, 'desktop_inventory_id');
    }
    public function brandModel() {
        return $this->belongsTo(BrandModel::class);
    }
}
