<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'inventory_item_id' => ['required', 'exists:inventory_items,id'],
            'employee_id' => ['required', 'exists:employees,id'],
            'parent_component' => ['nullable', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255', 'unique:items,code,' . $this->item->id],
            'barcode' => ['nullable', 'string', 'max:255', 'unique:items,barcode,' . $this->item->id],
            'description' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'property_number' => ['required', 'string', 'max:255', 'unique:items,property_number,' . $this->item->id],
            'ics_number' => ['nullable', 'string', 'max:255'],
            'iar_number' => ['nullable', 'string', 'max:255'],
            'po_number' => ['nullable', 'string', 'max:255'],
            'control_number' => ['nullable', 'string', 'max:255'],
            'date_issued' => ['nullable', 'date'],
            'date_acquired' => ['nullable', 'date'],
            'date_accepted' => ['nullable', 'date'],
            'date_installed' => ['nullable', 'date'],
            'ip_address' => ['nullable', 'string', 'max:255'],
            'mac_address' => ['nullable', 'string', 'max:255'],
            'inventory_type' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array {
        return [
            'inventory_item_id' => 'Inventory Item',
            'employee_id' => 'Employee',
            'parent_component' => 'Parent Component',
            'code' => 'Code',
            'barcode' => 'Barcode',
            'description' => 'Description',
            'serial_number' => 'Serial Number',
            'property_number' => 'Property Number',
            'ics_number' => 'ICS Number',
            'iar_number' => 'IAR Number',
            'po_number' => 'PO Number',
            'control_number' => 'Control Number',
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
