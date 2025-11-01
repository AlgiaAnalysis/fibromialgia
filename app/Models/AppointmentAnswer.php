<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentAnswer extends Model
{
    protected $table = "appointment_answers";

    protected $primaryKey = "apa_id";

    public $timestamps = false;

    protected $fillable = [
        "apa_answer",
        "question_que_id",
        "appointment_app_id",
    ];

    public function question() {
        return $this->belongsTo(Question::class, "question_que_id", "que_id");
    }

    public function appointment() {
        return $this->belongsTo(Appointment::class, "appointment_app_id", "app_id");
    }
}

