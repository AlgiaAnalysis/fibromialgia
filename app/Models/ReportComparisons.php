<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportComparisons extends Model
{
    protected $table = 'report_comparisons';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    protected $fillable = [
        'rec_ia_analysis',
    ];
}
