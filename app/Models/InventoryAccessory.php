<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryAccessory extends Model
{
    protected $fillable = [
        'desktop_inventory_id', 'brand_model_id', 'notes'
    ];
    public function desktopInventory() {
        return $this->belongsTo(Inventory::class, 'desktop_inventory_id');
    }
    public function brandModel() {
        return $this->belongsTo(BrandModel::class);
    }
}
