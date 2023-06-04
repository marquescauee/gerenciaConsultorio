<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentists extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'speciality_id', 'CRO', 'admin'];
}
