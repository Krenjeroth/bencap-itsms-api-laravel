<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $with = ['brand_model', 'employee'];

    protected $fillable = [
        'brand_model_id',
        'employee_id',
        'parent_component',
        'code',
        'barcode',
        'description',
        'serial_number',
        'property_number',
        'ics_number',
        'iar_number',
        'po_number',
        'control_number',
        'date_issued',
        'date_acquired',
        'date_accepted',
        'date_installed',
        'ip_address',
        'mac_address',
        'status',
        'inventory_type',
    ];

    public function brand_model() {
      return $this->belongsTo(BrandModel::class);
    }

    public function employee() {
      return $this->belongsTo(Employee::class);
    }
}
