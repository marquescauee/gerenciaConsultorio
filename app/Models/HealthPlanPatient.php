<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPlanPatient extends Model
{
    use HasFactory;

    protected $fillable = ['id_health_plan', 'id_patient'];
    protected $table = 'health_plans_patients';
    protected $primaryKey = 'id_patient';
}
