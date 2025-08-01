<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryAssociation extends Model
{
    protected $fillable = [
        'source_inventory_id', 'target_inventory_id', 'association_type', 'connection_details'
    ];
    public function sourceInventory() {
        return $this->belongsTo(Inventory::class, 'source_inventory_id');
    }
    public function targetInventory() {
        return $this->belongsTo(Inventory::class, 'target_inventory_id');
    }
}
