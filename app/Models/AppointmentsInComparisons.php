<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentsInComparisons extends Model
{
    protected $table = 'appointments_in_comparisons';
    protected $primaryKey = 'aic_id';
    public $timestamps = false;

    protected $fillable = [
        'appointment_app_id',
        'report_comparison_rec_id',
    ];

    public function appointment() {
        return $this->belongsTo(Appointment::class, 'appointment_app_id', 'app_id');
    }

    public function reportComparison() {
        return $this->belongsTo(ReportComparisons::class, 'report_comparison_rec_id', 'rec_id');
    }
}
