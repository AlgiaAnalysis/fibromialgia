<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportAnswer extends Model
{
    protected $table = "report_answers";

    protected $primaryKey = "rea_id";

    public $timestamps = false;

    protected $fillable = [
        "rea_value",
        "rea_week_day",
        "patient_domain_report_pdr_id",
        "question_que_id",
    ];

    public function patientDomainReport() {
        return $this->belongsTo(PatientDomainReport::class, "patient_domain_report_pdr_id", "pdr_id");
    }

    public function question() {
        return $this->belongsTo(Question::class, "question_que_id", "que_id");
    }
}
