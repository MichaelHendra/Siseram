<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Stok;

class TestExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $stok = Stok::join('tb_parfum', 'tb_stok.kode_barang', '=', 'tb_parfum.kode_barang')
        ->join('tb_agen', 'tb_stok.kode_agen', '=', 'tb_agen.kode_agen')
        ->select('tb_stok.kode_agen','tb_agen.nama_agen','tb_parfum.nama_barang','tb_stok.jumlah', )
        ->get();
        return $stok;
    }
}
