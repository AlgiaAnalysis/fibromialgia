<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientReport extends Model
{
    protected $table = "patient_reports";

    protected $primaryKey = "par_id";

    public $timestamps = false;

    public const STATUS_PENDING = "pending";
    public const STATUS_COMPLETED = "completed";

    public const TYPE_DAILY = "domain_daily";
    public const TYPE_FIQR = "fiqr";

    protected $fillable = [
        "par_period_starts",
        "par_period_end",
        "par_status",
        "par_medication",
        "par_score",
        "par_cli_resume",
        "par_type",
        "par_observation",
        "patient_pat_id",
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, "patient_pat_id", "pat_id");
    }

    public function patientDomainReports() {
        return $this->hasMany(PatientDomainReport::class, "patient_report_par_id", "par_id");
    }
}
