<?php

namespace App\Http\Controllers;

use App\Exports\StokAll;
use App\Exports\StokFilter;
// use PDF;
use App\Http\Controllers\Controller;
use App\Models\Agen;
use App\Models\Stok;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StokController extends Controller
{
    public function stokTampil()
    {
        $stok = Stok::join('tb_parfum', 'tb_stok.kode_barang', '=', 'tb_parfum.kode_barang')
            ->join('tb_agen', 'tb_stok.kode_agen', '=', 'tb_agen.kode_agen')
            ->select('tb_stok.*', 'tb_parfum.nama_barang', 'tb_agen.nama_agen')
            ->get();
        $Agen = Agen::distinct('kode_agen')->select('kode_agen', 'nama_agen')->get();
        // dd($Agen);
        // dd($stok);
        return view('lapor/stok/stok1', [
            'STok' => $stok,
            'Agen' => $Agen,

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
        $Agen = Agen::distinct('kode_agen')->select('kode_agen', 'nama_agen')->get();
        // $hidden = '<input type="text" value="' . $dar . '">';
        // $search = $this->export_excel($dar);
        // $this->export_excel($dar);
        session(['data' => $dar]);
        return view('lapor/stok/stok1', [
            'STok' => $stok,
            'Agen' => $Agen,
            // 'hidden' => $hidden,

        ]);

    }
    //all
    public function export()
    {
        return Excel::download(new StokAll, 'stok-semua.xlsx');
    }
    //filtered
    public function export_excel()
    {

        // $tes=Input::get('nama');
        $kode_agen = session('data');
        // dd($kode_agen);
        return Excel::download(new StokFilter($kode_agen), 'stok.xlsx');
    }
}
