<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = "appointments";

    protected $primaryKey = "app_id";

    public $timestamps = false;

    protected $fillable = [
        "app_date",
        "app_diagnosis",
        "patient_pat_id",
        "doctor_doc_id",
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, "patient_pat_id", "pat_id");
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class, "doctor_doc_id", "doc_id");
    }

    public function appointmentAnswers() {
        return $this->hasMany(AppointmentAnswer::class, "appointment_app_id", "app_id");
    }
}
