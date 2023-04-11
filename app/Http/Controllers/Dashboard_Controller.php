<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard_Controller extends Controller
{
    public function dashboardT()
    {
        return view('dashboard');
    }
}
