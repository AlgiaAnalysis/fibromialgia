<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = "doctors";

    protected $primaryKey = "doc_id";

    public $timestamps = false;

    protected $fillable = [
        "doc_crm",
    ];
}
