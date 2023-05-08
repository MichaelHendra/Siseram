<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransaksiExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $transact = DB::table('tb_transaksi_detail')
        ->join('tb_transaksi','tb_transaksi_detail.kode_transaksi','=','tb_transaksi.kode_transaksi')
        ->join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        ->Where('tb_transaksi.valid','=','1')
        ->whereMonth('tb_transaksi.tanggal', Carbon::now()->month)
        ->select([
            DB::raw('tb_transaksi_detail.kode_barang'),
            DB::raw('tb_parfum.nama_barang'),
            DB::raw('tb_parfum.h_beli'),
            DB::raw('tb_parfum.h_agen'),
            DB::raw('sum(jumlah) as total_brg'),
            DB::raw('sum(harga) as total_harga'),
            DB::raw('tb_transaksi.valid')
        ])->groupBy('tb_transaksi_detail.kode_barang','tb_parfum.nama_barang','tb_parfum.h_beli','tb_parfum.h_agen','tb_transaksi.valid')
        ->get();
        return $transact;
    }
}
