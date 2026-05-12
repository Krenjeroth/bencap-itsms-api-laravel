<?php

namespace App\Http\Controllers;

use App\Exports\InventoryReportExport;
use App\Models\Inventory;
use App\Services\HrisClientService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ItemType;
use Carbon\Carbon;

class InventoryReportController extends Controller
{
    public function exportExcel(Request $request, HrisClientService $hris)
    {
        $rows = $this->getReportRows($request, $hris);

        return Excel::download(
            new InventoryReportExport($rows),
            'inventory-report-' . now()->format('Y-m-d-His') . '.xlsx'
        );
    }

    public function exportPdf(Request $request, HrisClientService $hris) {
        try {
            $rows = $this->getReportRows($request, $hris);

            $employees = collect($hris->getEmployeesCached());
            $itemType = ItemType::find($request->input('item_type'));
            $employee = $employees->firstWhere('id', (int) $request->input('employee'));

            $officeDesc = null;
            if ($request->filled('office')) {
                $officeId = (string) $request->input('office');

                $officeDesc = $employees
                    ->first(function ($employee) use ($officeId) {
                        return (string) data_get($employee, 'office_id') === $officeId;
                    });

                $officeDesc = data_get($officeDesc, 'office_desc');
            }

            $filters = [
                'item_type' => $itemType?->type ?? 'All',
                'employee' => data_get($employee, 'fullname')
                    ?: data_get($employee, 'full_name')
                    ?: 'All',
                'office' => $officeDesc ?: 'All',
                'status' => $this->cleanPdfText($request->input('status')) ?: 'All',
            ];

            $summary = collect($rows)
                ->groupBy('item_type')
                ->map(fn ($items) => count($items))
                ->sortKeys();

            $customPaper = [0, 0, 576, 936];

            $pdf = Pdf::loadView('reports.inventory-report', [
                'rows' => $rows,
                'filters' => $filters,
                'generatedAt' => now(),
                'summary' => $summary,
            ])->setPaper($customPaper, 'landscape');

            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            return $pdf->download('inventory-report-' . now()->format('Y-m-d-His') . '.pdf');
        } catch (\Throwable $e) {
            Log::error('Inventory PDF export failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to generate PDF report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function getReportRows(Request $request, HrisClientService $hris) {
        $employeeMap = collect($hris->getEmployeesCached())
            ->filter(fn ($e) => isset($e['id']))
            ->keyBy(fn ($e) => (int) $e['id']);

        $query = Inventory::query()
            ->with([
                'item_type',
                'brand_model',
                'parent_component',
                'parent_component.brand_model',
                'parent_component.item_type',
            ]);

        if ($request->filled('item_type')) {
            $query->where('item_type_id', $request->input('item_type'));
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', (int) $request->input('employee'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('office')) {
            $officeId = (string) $request->input('office');

            $employeeIds = $employeeMap
                ->filter(function ($employee) use ($officeId) {
                    return (string) data_get($employee, 'office_id') === $officeId;
                })
                ->keys()
                ->map(fn ($id) => (int) $id)
                ->values()
                ->all();

            if (empty($employeeIds)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('employee_id', $employeeIds);
            }
        }

        return $query
            ->orderBy('property_number')
            ->get()
            ->map(function ($inventory) use ($employeeMap) {
                $employee = $employeeMap->get((int) $inventory->employee_id);

                $employeeName =
                    data_get($employee, 'fullname') ?:
                    data_get($employee, 'full_name');

                $office =
                    data_get($employee, 'office_desc') ?:
                    data_get($employee, 'office_code');

                return [
                    'property_number' => $this->cleanPdfText($inventory->property_number),
                    'employee_name' => $this->cleanPdfText($employeeName),
                    'office' => $this->cleanPdfText($office),
                    'division_section' => $this->cleanPdfText(
                        data_get($employee, 'division_section')
                        ?: data_get($employee, 'division')
                        ?: data_get($employee, 'section')
                        ?: data_get($employee, 'division_desc')
                        ?: data_get($employee, 'section_desc')
                    ),
                    'item_type' => $this->cleanPdfText($inventory->item_type?->type),
                    'brand_model' => $this->cleanPdfText(
                        $inventory->brand_model?->option_attribute_description
                        ?? $inventory->brand_model?->specification
                    ),
                    'serial_number' => $this->cleanPdfText($inventory->serial_number),
                    'status' => $this->cleanPdfText($inventory->status),
                    'date_acquired' => $this->cleanPdfText(
                        $inventory->date_acquired
                            ? Carbon::parse($inventory->date_acquired)->format('F d, Y')
                            : ''
                    ),
                ];
            });
    }

    private function getReportQuery(Request $request) {
        $query = Inventory::query()->with([
            'item_type',
            'brand_model',
            'parent_component',
            'parent_component.brand_model',
            'parent_component.item_type',
        ]);

        if ($request->filled('item_type')) {
            $query->where('item_type_id', $request->input('item_type'));
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', (int) $request->input('employee'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('office')) {
            // office filter logic here
        }

        return $query;
    }

    private function cleanPdfText($value): string {
        if ($value === null) {
            return '';
        }

        $value = (string) $value;
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        $value = preg_replace('/[^\P{C}\n\r\t]+/u', '', $value);

        return trim($value);
    }
}
