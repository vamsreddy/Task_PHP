<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table= "patients";
    protected $fillable= [
        'patient_no',
        'date',
        'patient_name',
        'age',
        'gender',
        'contact_no',
        'room_bed_no',
        'doctor_name',
        'specialist',
        'treatment_details',
        'prepared_by'
    ];

}
