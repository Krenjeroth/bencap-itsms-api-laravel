<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $with = ['brand_model', 'employee', 'parent_component', 'item_type', 'internal_components'];

    protected $fillable = [
        'employee_id',
        'item_type_id',
        'brand_model_id',
        'parent_component_id',
        'ip_address',
        'mac_address',
        'remarks',
        'operating_system_name',
        'os_license_number',
        'anti_virus_name',
        'anti_virus_license_number',
        'microsoft_office_name',
        'ms_office_license_number',
        'other_installed_applications',
        'property_number',
        'date_acquired',
        'warranty_expiration_date',
        'serial_number',
        'status',
    ];

    public function brand_model() {
      return $this->belongsTo(BrandModel::class);
    }

    public function employee() {
      return $this->belongsTo(Employee::class);
    }

    public function parent_component() {
      return $this->belongsTo(Inventory::class, 'parent_component_id');
    }

    public function item_type() {
      return $this->belongsTo(ItemType::class);
    }

    public function internal_components() {
      return $this->hasMany(InventoryInternalComponent::class);
    }
}
