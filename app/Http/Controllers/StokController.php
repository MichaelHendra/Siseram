<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function stokTampil()
    {
        $stok = Stok::join('tb_parfum','tb_stok.kode_barang','=','tb_parfum.kode_barang')
        ->join('tb_agen','tb_stok.kode_agen','=','tb_agen.kode_agen')
        ->select('tb_stok.*','tb_parfum.nama_barang','tb_agen.nama_agen')
        ->get();
        $stok1 = Stok::join('tb_parfum','tb_stok.kode_barang','=','tb_parfum.kode_barang')
        ->join('tb_agen','tb_stok.kode_agen','=','tb_agen.kode_agen')
        ->select('tb_stok.*','tb_parfum.nama_barang','tb_agen.nama_agen')
        ->get();
        // dd($stok);
        return view('lapor/stok/stok1',[
            'STok' => $stok,
            'STok1'=> $stok1,
        ]);
    }

    public function stokAgen(Request $request)
    {
        $dar = $request->nama;
        $stok = Stok::join('tb_parfum','tb_stok.kode_barang','=','tb_parfum.kode_barang')
        ->join('tb_agen','tb_stok.kode_agen','=','tb_agen.kode_agen')
        ->where('tb_stok.kode_agen','=',$dar)
        ->select('tb_stok.*','tb_parfum.nama_barang','tb_agen.nama_agen')
        ->get();
        $stok1 = Stok::join('tb_parfum','tb_stok.kode_barang','=','tb_parfum.kode_barang')
        ->join('tb_agen','tb_stok.kode_agen','=','tb_agen.kode_agen')
        ->select('tb_stok.*','tb_parfum.nama_barang','tb_agen.nama_agen')
        ->get();
        return view('lapor/stok/stok1',[
            'STok' => $stok,
            'STok1'=> $stok1,
        ]);
    }
}
