<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            // HRIS-native fields
            'employee_id_number'  => $this['employee_id_number'] ?? null,
            'fullname'  => $this['fullname'] ?? null,
            'fname' => $this['fname'] ?? null,
            'mname' => $this['mname'] ?? null,
            'lname' => $this['lname'] ?? null,

            'office_desc' => $this['office_desc'] ?? null,
            'office_code' => $this['office_code'] ?? null,
            'position_title'  => $this['position_title'] ?? null,

            'type'  => $this['type'] ?? null,
            'salary_grade_id' => $this['salary_grade_id'] ?? null,
            'grade' => $this['grade'] ?? null,
            'division'  => $this['division'] ?? null,
            'unit'  => $this['unit'] ?? null,
            'salary'  => $this['salary'] ?? null,

            // Optional aliases for your existing UI conventions
            // 'firstname' => $this['fname'] ?? null,
            // 'middlename'  => $this['mname'] ?? null,
            // 'lastname'  => $this['lname'] ?? null,
        ];
    }
}
