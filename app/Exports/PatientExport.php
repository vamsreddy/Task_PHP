<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientExport implements FromCollection , WithHeadings , ShouldAutoSize , WithStyles , WithTitle
{
    protected $patients;

    public function __construct($patients)
    {
        $this->patients = $patients;
    }

    public function collection()
    {
        return $this->patients;
        
    }

    public function headings(): array
    {
        return [
            __('id'),
            __('patient_no'),
            __('date'),
            __('patient_name'),
            __('age'),
            __('gender'),
            __('contact_no'),
            __('room_bed_no'),
            __('doctor_name'),
            __('specialist'),
            __('treatment_details'),
            __('prepared_by'),
            __('created_at'),
            __('updated_at')
            ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
        // Style the first row as bold text.
        1    => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Patients_Report';
    }
}
