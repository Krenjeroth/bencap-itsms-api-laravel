<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BrandModelResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ItemTypeResource;
use App\Http\Resources\InventoryInternalComponentResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // $description = $this->brand_model->specification ? $this->brand_model->item_type->type . ', ' . $this->brand_model->specification . ', ' . $this->brand_model->brand->name . ' ' . $this->brand_model->name : $this->brand_model->item_type->type . ', ' .$this->brand_model->brand->name . ' ' . $this->brand_model->name;

        $employee_full_name = $this->employee ? $this->employee->full_name : null;

        $employee_full_name_formatted = $employee_full_name ? ' - ' . $employee_full_name : '';

        $inventory = $this?->loadMissing('internal_components');

        $internal_components = [];

        if($inventory) {
          foreach($inventory->internal_components as $internal_component) {
            $internal_components[] = [
              'id' => $internal_component->id,
              // 'inventory' => InventoryResource::make($internal_component->inventory),
              'brand_model' => BrandModelResource::make($internal_component->brand_model),
              'specific_serial_number' => $internal_component->specific_serial_number,
              'slot' => $internal_component->slot,
              'quantity' => $internal_component->quantity,
              'notes' => $internal_component->notes,
            ];
          }
        }

        $employee = EmployeeResource::make($this->whenLoaded('employee'));
        $inventory = InventoryResource::make($this->whenLoaded('parent_component'));
        $item_type = ItemTypeResource::make($this->whenLoaded('item_type'));
        $brand_model = BrandModelResource::make($this->whenLoaded('brand_model'));

        $computed_brand_model = $brand_model ? $brand_model : $item_type->brand_model;
        
        $computed_brand_model_search = is_null($brand_model->resource) ? $item_type->type : "{$brand_model->brand->name} $item_type->type";
        $employee_full_name = is_null($employee->resource) ? "{$inventory->employee->full_name}" : "{$employee->full_name}";
        // if($this->item_type_id === 1) {
        //   $computed_brand_model = $item_type->brand_model;
        // }

        return [
          'id' => $this->id,
          'employee' => $employee,
          'item_type' => $item_type,
          'brand_model' => $computed_brand_model,
          'inventory' => $inventory,
          
          'internal_components' => $internal_components,
          // 'internal_components' => InventoryInternalComponentResource::collection($this->whenLoaded('internal_components')),

          'ip_address' => $this->ip_address,
          'mac_address' => $this->mac_address,
          'remarks' => $this->remarks,
          'operating_system_name' => $this->operating_system_name,
          'os_license_number' => $this->os_license_number,
          'anti_virus_name' => $this->anti_virus_name,
          'anti_virus_license_number' => $this->anti_virus_license_number,
          'microsoft_office_name' => $this->microsoft_office_name,
          'ms_office_license_number' => $this->ms_office_license_number,
          'other_installed_applications' => $this->other_installed_applications,
          'property_number' => $this->property_number,
          'date_acquired' => $this->date_acquired,
          'warranty_expiration_date' => $this->warranty_expiration_date,
          'serial_number' => $this->serial_number,
          'status' => $this->status,

          // 'parent_component' => $this->parent_component,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,

          // Options
          'inventory_option_attribute' => "$this->property_number - $computed_brand_model_search ({$employee_full_name})",
        ];
    }
}
