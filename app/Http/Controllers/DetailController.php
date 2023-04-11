<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function detailTapil(string $id)
    {
        $transact = Transaksi::find($id)
        ->join('tb_agen','tb_agen.kode_agen','=','tb_transaksi.kode_agen')
        ->select('tb_transaksi.*','tb_agen.nama_agen')
        ->first();
        
        return view('transaksi/Pusat/transaksi-detail',[
        'ngeng' => $transact, 
        ]);
    }
}
