<?php

namespace App\Http\Controllers;

use App\Models\Agen;
use App\Models\Stok;
// use PDF;
use Illuminate\Http\Request;
use App\Exports\TestExport;
use Maatwebsite\Excel\Facades\Excel;


class StokController extends Controller
{
    public function stokTampil()
    {
        $stok = Stok::join('tb_parfum', 'tb_stok.kode_barang', '=', 'tb_parfum.kode_barang')
            ->join('tb_agen', 'tb_stok.kode_agen', '=', 'tb_agen.kode_agen')
            ->select('tb_stok.*', 'tb_parfum.nama_barang', 'tb_agen.nama_agen')
            ->get();
        $Agen = Agen::distinct('kode_agen')->select('kode_agen','nama_agen')->get();
        // dd($Agen);
        // dd($stok);
        return view('lapor/stok/stok1', [
            'STok' => $stok,
            'Agen'=>$Agen,
        ]);
    }

    public function stokAgen(Request $request)
    {
        $dar = $request->nama;
        
        $stok = Stok::join('tb_parfum', 'tb_stok.kode_barang', '=', 'tb_parfum.kode_barang')
            ->join('tb_agen', 'tb_stok.kode_agen', '=', 'tb_agen.kode_agen')
            ->where('tb_stok.kode_agen', '=', $dar)
            ->select('tb_stok.*', 'tb_parfum.nama_barang', 'tb_agen.nama_agen')
            ->get();
        $Agen = Agen::distinct('kode_agen')->select('kode_agen','nama_agen')->get();
        return view('lapor/stok/stok1', [
            'STok' => $stok,
            'Agen'=>$Agen,
        ]);
    }
    public function export_excel()
	{
		return Excel::download(new TestExport, 'stok.xlsx');
	}
}
