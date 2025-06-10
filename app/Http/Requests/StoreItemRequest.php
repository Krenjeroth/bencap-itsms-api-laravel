<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreItemRequest extends FormRequest
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
            'item_type_id' => ['required', 'exists:item_types,id'],
            'brand_model_id' => ['required', 'exists:brand_models,id'],
            'parent_component' => ['nullable', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255', 'unique:items,code'],
            'barcode' => ['nullable', 'string', 'max:255', 'unique:items,barcode'],
            'description' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'property_number' => ['required', 'string', 'max:255'],
            'ics_number' => ['nullable', 'string', 'max:255'],
            'date_acquired' => ['nullable', 'date'],
            'ip_address' => ['nullable', 'string', 'max:255'],
            'mac_address' => ['nullable', 'string', 'max:255'],
            'inventory_type' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array {
        return [
            'item_type_id' => 'Item Type',
            'brand_model_id' => 'Brand Model',
            'parent_component' => 'Parent Component',
            'code' => 'Code',
            'barcode' => 'Barcode',
            'description' => 'Description',
            'serial_number' => 'Serial Number',
            'property_number' => 'Property Number',
            'ics_number' => 'ICS Number',
            'date_acquired' => 'Date Acquired',
            'ip_address' => 'IP Address',
            'mac_address' => 'MAC Address',
            'inventory_type' => 'Inventory Type',
            'status' => 'Status',
        ];
    }

    // public function messages(): array {
    //     return [
    //         'item_type.required'   => 'The :attribute is required.',
    //         'brand_model.required'   => 'The :attribute is required.',
    //         'parent_component.required'   => 'The :attribute is required.',
    //         'code.required'   => 'The :attribute is required.',
    //         'barcode.required'   => 'The :attribute is required.',
    //         'description.required'   => 'The :attribute is required.',
    //         'serial_number.required'   => 'The :attribute is required.',
    //         'property_number.required'   => 'The :attribute is required.',
    //         'ics_number.required'   => 'The :attribute is required.',
    //         'date_acquired.required'   => 'The :attribute is required.',
    //         'ip_address.required'   => 'The :attribute is required.',
    //         'mac_address.required'   => 'The :attribute is required.',
    //         'status.required'   => 'The :attribute is required.',
    //         'inventory_type.required'   => 'The :attribute is required.',
    //     ];
    // }
}
