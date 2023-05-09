<?php

namespace App\Http\Controllers;

use App\Models\Agen;
use App\Models\Parfum;
use App\Models\Transaksi;

class Dashboard_Controller extends Controller
{
    public function dashboardT()
    {
        $valid = Transaksi::where('valid', 1)->count();
        $noValid = Transaksi::where('valid', 0)->count();
        $parfum = Parfum::count();
        $agen = Agen::where('status', 0)->count();
        return view('dashboard', compact('valid', 'noValid', 'parfum', 'agen'));
    }
}
