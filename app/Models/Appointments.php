<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    protected $fillable = ['id_procedure', 'id_patient', 'id_dentist', 'date', 'start_time', 'end_time'];
}
