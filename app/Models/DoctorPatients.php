<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorPatients extends Model
{
    protected $table = "doctor_patients";

    protected $primaryKey = "dop_id";

    public $timestamps = false;

    public const STATUS_PENDING = "pending";
    public const STATUS_LINKED = "linked";

    protected $fillable = [
        "dop_status",
        "patient_pat_id",
        "doctor_doc_id",
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, "patient_pat_id", "pat_id");
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class, "doctor_doc_id", "doc_id");
    }
}
