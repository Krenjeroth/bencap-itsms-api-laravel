<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryReportExport implements FromCollection, WithHeadings
{
    public function __construct(private Collection $rows)
    {
    }

    public function collection()
    {
        return $this->rows->map(function ($row) {
            return [
                'property_number' => $row['property_number'],
                'employee_name' => $row['employee_name'],
                'office' => $row['office'],
                'item_type' => $row['item_type'],
                'brand_model' => $row['brand_model'],
                'serial_number' => $row['serial_number'],
                'status' => $row['status'],
                'date_acquired' => $row['date_acquired'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Property Number',
            'Employee Name',
            'Office',
            'Item Type',
            'Brand / Model',
            'Serial Number',
            'Status',
            'Date Acquired',
        ];
    }
}