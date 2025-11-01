<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = "patients";

    protected $primaryKey = "pat_id";

    public $timestamps = false;

    protected $fillable = [
        "pat_disease_discover_date",
        "pat_stopped_treatment",
        "pat_streak",
        "pat_gave_informed_diagnosis",
        "pat_hundred_days",
        "pat_two_hundred_days",
        "pat_three_days",
        "pat_gender",
        "pat_created_at",
    ];
}
