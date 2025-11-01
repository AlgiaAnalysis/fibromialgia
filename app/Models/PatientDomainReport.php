<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientDomainReport extends Model
{
    protected $table = "patient_domain_reports";

    protected $primaryKey = "pdr_id";

    public $timestamps = false;

    public const DOMAIN_DAILY = "daily_domain";
    public const DOMAIN_FIRST = "first_domain";
    public const DOMAIN_SECOND = "second_domain";
    public const DOMAIN_THIRD = "third_domain";

    protected $fillable = [
        "pdr_domain",
        "pdr_score",
        "pdr_weekday",
        "patient_report_par_id",
    ];

    public function patientReport() {
        return $this->belongsTo(PatientReport::class, "patient_report_par_id", "par_id");
    }

    public function reportAnswers() {
        return $this->hasMany(ReportAnswer::class, "patient_domain_report_pdr_id", "pdr_id");
    }
}
