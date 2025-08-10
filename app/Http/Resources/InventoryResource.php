<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BrandModelResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ItemTypeResource;

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

        return [
          'id' => $this->id,
          'employee' => EmployeeResource::make($this->whenLoaded('employee')),
          'item_type' => ItemTypeResource::make($this->whenLoaded('item_type')),
          'brand_model' => BrandModelResource::make($this->whenLoaded('brand_model')),
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
        ];
    }
}
