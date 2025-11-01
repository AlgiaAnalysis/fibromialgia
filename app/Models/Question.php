<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = "questions";

    protected $primaryKey = "que_id";

    public $timestamps = false;

    public const DOMAIN_MICRO_DAILY = "micro_daily";
    public const DOMAIN_FIRST_DOMAIN = "first_domain";
    public const DOMAIN_SECOND_DOMAIN = "second_domain";
    public const DOMAIN_THIRD_DOMAIN = "third_domain";
    public const DOMAIN_APPOINTMENT_QUESTIONS = "appointment_questions";

    protected $fillable = [
        "que_name",
        "que_domain",
        "que_index",
    ];
}
