<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['nullable', 'exists:employees,id'],
            'item_type_id' => ['nullable', 'exists:item_types,id'],
            'brand_model_id' => ['nullable', 'exists:brand_models,id'],
            
            'ip_address' => ['nullable', 'string', 'max:255'],
            'mac_address' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:1000'],

            'operating_system_name' => ['nullable', 'string', 'max:255'],
            'os_license_number' => ['nullable', 'string', 'max:255'],
            'anti_virus_name' => ['nullable', 'string', 'max:255'],
            'anti_virus_license_number' => ['nullable', 'string', 'max:255'],
            'microsoft_office_name' => ['nullable', 'string', 'max:255'],
            'ms_office_license_number' => ['nullable', 'string', 'max:255'],
            'other_installed_applications' => ['nullable', 'string', 'max:1000'],
            'property_number' => ['required', 'string', 'max:255', 'unique:inventories,property_number'],
            'date_acquired' => ['nullable', 'date'],
            'warranty_expiration_date' => ['nullable', 'date'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],

            'internal_components' => 'array',
            'internal_components.*.brand_model.id' => 'required|integer',
            'internal_components.*.quantity' => 'required|integer|min:1',
            
            // 'internal_components.*.brand_model.id' => ['nullable', 'exists:brand_models,id'],
            // 'internal_components.*.quantity' => ['nullable', 'integer'],
            
            // 'parent_component' => ['nullable', 'string', 'max:255'],
            // 'inventory_type' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array {
        return [
            'brand_model_id' => 'Brand Model',
            'employee_id' => 'Employee',
            'parent_component' => 'Parent Component',
            'property_number' => 'Property Number',
            'date_issued' => 'Date Issued',
            'date_acquired' => 'Date Acquired',
            'date_accepted' => 'Date Accepted',
            'date_installed' => 'Date Installed',
            'ip_address' => 'IP Address',
            'mac_address' => 'MAC Address',
            'inventory_type' => 'Inventory Type',
            'status' => 'Status',
        ];
    }
}
