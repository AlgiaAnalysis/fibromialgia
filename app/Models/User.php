<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "users";

    protected $primaryKey = "usr_id";

    public $timestamps = false;

    public const ROLE_ADMIN = "admin";
    public const ROLE_DOCTOR = "doctor";
    public const ROLE_PATIENT = "patient";

    protected $fillable = [
        "usr_name",
        "usr_email",
        "usr_password",
        "usr_role",
        "usr_represented_agent",
        "usr_created_at",
        "usr_updated_at",
        "usr_cpf",
    ];

    public function doctor() {
        return $this->belongsTo(Doctor::class, "usr_represented_agent", "doc_id");
    }

    public function patient() {
        return $this->belongsTo(Patient::class, "usr_represented_agent", "pat_id");
    }
}
