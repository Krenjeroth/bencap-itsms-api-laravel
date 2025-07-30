<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BrandModelResource;
use App\Http\Resources\EmployeeResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'brand_model' => BrandModelResource::make($this->whenLoaded('brand_model')),
          'employee' => EmployeeResource::make($this->whenLoaded('employee')),
          'parent_component' => $this->parent_component,
          'code' => $this->code,
          'barcode' => $this->barcode,
          'description' => $this->description,
          'serial_number' => $this->serial_number,
          'property_number' => $this->property_number,
          'ics_number' => $this->ics_number,
          'iar_number' => $this->iar_number,
          'po_number' => $this->po_number,
          'control_number' => $this->control_number,
          'date_issued' => $this->date_issued,
          'date_acquired' => $this->date_acquired,
          'date_accepted' => $this->date_accepted,
          'date_installed' => $this->date_installed,
          'ip_address' => $this->ip_address,
          'mac_address' => $this->mac_address,
          'status' => $this->status,
          'inventory_type' => $this->inventory_type,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
        ];
    }
}
