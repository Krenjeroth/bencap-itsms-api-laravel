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

        $description = $this->brand_model->specification ? $this->brand_model->item_type->type . ', ' . $this->brand_model->specification . ', ' . $this->brand_model->brand->name . ' ' . $this->brand_model->name : $this->brand_model->item_type->type . ', ' .$this->brand_model->brand->name . ' ' . $this->brand_model->name;

        $employee_full_name = $this->employee ? $this->employee->full_name : null;

        $employee_full_name_formatted = $employee_full_name ? ' - ' . $employee_full_name : '';

        return [
          'id' => $this->id,
          'brand_model' => BrandModelResource::make($this->whenLoaded('brand_model')),
          'employee' => EmployeeResource::make($this->whenLoaded('employee')),
          'parent_component' => $this->parent_component,
          'code' => $this->code,
          'barcode' => $this->barcode,
          'description' => $description,
          // 'description' => $this->brand_model->specification ? $this->brand_model->item_type->type . ', ' . $this->brand_model->specification . ', ' . $this->brand_model->brand->name . ' ' . $this->brand_model->name : $this->brand_model->item_type->type . ', ' .$this->brand_model->brand->name . ' ' . $this->brand_model->name,
          'serial_number' => $this->serial_number,
          'property_number' => $this->property_number,
          'inventory_option_attribute' => $this->property_number . ' (' . $description . ')' . $employee_full_name_formatted,
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
