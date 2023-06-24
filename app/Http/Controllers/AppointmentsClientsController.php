<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentsClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create() {
        return view('appointments.patients.create');
    }
}
