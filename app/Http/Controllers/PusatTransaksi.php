<?php

namespace App\Http\Controllers;

use App\Models\Parfum;
use App\Models\Transaksip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PusatTransaksi extends Controller
{
    public function transkasiPusat()
    {
        $transaksi = Transaksip:: join('tb_agen','tb_agen.kode_agen','=','tb_transaksi_pusat.kode_agen')
        ->select('tb_transaksi_pusat.*','tb_agen.nama_agen')
        ->get();
        return view('transaksi/pusat/transaksiPusat',[
    
                "tP" => $transaksi,
            
        ]);
    }
}
