<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PatientReport;
use App\Models\ReportComparisons;

class ReportsInComparisons extends Model
{
    protected $table = 'reports_in_comparisons';
    protected $primaryKey = 'ric_id';
    public $timestamps = false;

    protected $fillable = [
        'patient_report_par_id',
        'report_comparison_rec_id',
    ];

    public function patientReport() {
        return $this->belongsTo(PatientReport::class, 'patient_report_par_id', 'par_id');
    }

    public function reportComparison() {
        return $this->belongsTo(ReportComparisons::class, 'report_comparison_rec_id', 'rec_id');
    }
}
