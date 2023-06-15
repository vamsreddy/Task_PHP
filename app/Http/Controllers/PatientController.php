<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use PDF;
use Illuminate\Support\Facades\Response;
use App\Exports\PatientExport;
use App\Services\PatientService;
use Maatwebsite\Excel\Facades\Excel;

class PatientController extends PatientService
{
    public function index()
    {
        $patient = Patient::all();  //getting the list of patients
        return response()->json([
            "status" => true,
            "message" => "Patients List.",
            "data" => $patient
        ]);
    }

    public function store(Request $request)
    {  
        $validData = $this->storeValidate($request->all());

        if ($validData) {

            $patient = new Patient;   //creating a new record of patient
            $patient->patient_no = 'P.no-' . (Patient::count() + 1); //generating the system generated patient_no
            $patient->date = $request->date;
            $patient->patient_name = $request->patient_name;
            $patient->age = $request->age;
            $patient->gender = $request->gender;
            $patient->contact_no = $request->contact_no;
            $patient->room_bed_no = $request->room_bed_no;
            $patient->doctor_name = $request->doctor_name;
            $patient->specialist = $request->specialist;
            $patient->treatment_details = $request->treatment_details;
            $patient->prepared_by = $request->prepared_by;
            $patient->save();

            return response()->json([
                "status" => true,
                "message" => "Record created successfully.",
                "data" => $patient
                ]);
            }else{
            return response()->json([
                "status" => false,
                "message" => "Record not created",
                "errors" => $this->error]);
            }
    }
    
    public function update(Request $request, int $id)
    {
        $validData = $this->updateValidate($request->all());
        
        if ($validData) {

            $patient = Patient::where('id', $id)->update([   //updating the Patient Record
                'date' => $request->date,
                'patient_name' => $request->patient_name,
                'age' => $request->age,
                'gender' => $request->gender,
                'contact_no' => $request->contact_no,
                'room_bed_no' => $request->room_bed_no,
                'doctor_name' => $request->doctor_name,
                'specialist' => $request->specialist,
                'treatment_details' => $request->treatment_details,
                'prepared_by' => $request->prepared_by,
            ]);if ($patient) { 
                        $data=Patient::find($id);
                        return response()->json([
                            "status" => true,
                            "message" => "Record updated successfully.",
                            "data" => $data
                        ]);
                    }else{
                        return response()->json([
                            "status" => false,
                            "message" => "Record not found."]);
                    }
            }else{ 
                return response()->json([
                "status" => false,
                "message" => "Validation errors",
                "errors" => $this->error]); 
            } 
    }

    public function destroy(Request $request)
    {
        $validData = $this->destroyValidate($request->all());

        if ($validData) {

            $patients = $request->input('ids', []);
        
            $ids=Patient::whereIn('id', $patients)->delete();  //deletes the given ids record
        
                if ($ids == null) {
                return response()->json([
                    "status" => false,
                    "message" => "Record not found."]);
                }
                return response()->json([
                    "status" => true,
                    "message" => "Record deleted successfully."]);
            }else{ 
                return response()->json([
                "status" => false,
                "message" => "Validation errors",
                "errors" => $this->error]); 
            }  
    }

    public function pdf($id)
    {
        $patient = Patient::find($id);

        $pdf = PDF::loadView('patient.pdf', ['patient' => $patient]); //generate the PDF view

        $base64Pdf = base64_encode($pdf->output()); // convert pdf to base64 format

        if (!$patient) {
            return response()->json([
                 "status" => false,
                 "message" => "Record not found."]);
        }
        return response()->json([
                "status" => true,
                "message" => "PDF generated successfully",
                "data" => $base64Pdf
            ]);
    }

    public function excel()
    {
        $patient = Patient::all(); // get all patient details from the database

        $filePath = storage_path('app/reports/patients.xlsx');

        Excel::store(new PatientExport($patient), 'reports/patients.xlsx');

        $file = file_get_contents($filePath);

        $base64file = base64_encode($file);   // convert excel to base64 format

        return response()->json([
                "status" => true,
                "message" => "Excel generated successfully",
                "data" => $base64file
            ]);
    }  

}