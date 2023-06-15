<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

class PatientService
{
    public function storeValidate($patient)
    {
        $rules = [
        'date' => ['required', 'date', 'date_format:Y-m-d'],
        'patient_name' => ['required', 'string', 'max:255'],
        'age' => ['required', 'string', 'max:100'],
        'gender' => ['required', 'string', 'max:6'],
        'contact_no' => ['required', 'string', 'max:10', 'unique:patients,contact_no'],
        'room_bed_no' => ['required', 'string', 'max:100', 'unique:patients,room_bed_no'],
        'doctor_name' => ['required', 'string', 'max:255'],
        'specialist' => ['required', 'string', 'max:255'],
        'treatment_details' => ['required', 'string', 'max:500'],
        'prepared_by' => ['required', 'string', 'max:255'],
    ];

    $validation = Validator::make($patient, $rules);

    if ($validation->fails()) {
        $this->error = $validation->errors();
        return false;
        } else {
        return true;
        }
    }

    public function updateValidate($patient)
    {
        $rules = [
        'date' => ['required', 'date', 'date_format:Y-m-d'],
        'patient_name' => ['required', 'string', 'max:255'],
        'age' => ['required', 'string', 'max:100'],
        'gender' => ['required', 'string', 'max:6'],
        'contact_no' => ['required', 'string', 'max:15'],
        'room_bed_no' => ['required', 'string', 'max:100'],
        'doctor_name' => ['required', 'string', 'max:255'],
        'specialist' => ['required', 'string', 'max:255'],
        'treatment_details' => ['required', 'string', 'max:500'],
        'prepared_by' => ['required', 'string', 'max:255'],
    ];

    $validation = Validator::make($patient, $rules);

    if ($validation->fails()) {
        $this->error = $validation->errors();
        return false;
        } else {
        return true;
        }
    }

    public function destroyValidate($patient)
    {
        $rules = [
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'integer'],
    ];

    $validation = Validator::make($patient, $rules);

    if ($validation->fails()) {
        $this->error = $validation->errors();
        return false;
        } else {
        return true;
        }
    }
}