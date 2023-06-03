<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentists extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'password', 'CRO', 'admin'];
}
