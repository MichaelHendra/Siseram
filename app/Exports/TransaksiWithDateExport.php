<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiWithDateExport implements FromCollection,WithHeadings, ShouldAutoSize
{
    private $newdatefrom;
    private $newdateto;
    private $jenis;
    private $kode_agen;

    use Exportable;
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Nama Agen',
            'Harga Pusat',
            'Harga Agen',
            'jumlah',
            'Sub Total',
        ];
    }
    public function __construct(string $newdatefrom,string $newdateto,string $jenis, string $kode_agen)
    {
        $this->newdatefrom = $newdatefrom;
        $this->newdateto = $newdateto;
        $this->jenis = $jenis;
        $this->kode_agen = $kode_agen;
    }
    public function collection()
    {
        $transact = DB::table('tb_transaksi_detail')
        ->join('tb_transaksi','tb_transaksi_detail.kode_transaksi','=','tb_transaksi.kode_transaksi')
        ->join('tb_agen','tb_transaksi.kode_agen','=','tb_agen.kode_agen')
        ->join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        ->Where('tb_transaksi.valid','=','1')
        ->where('tb_transaksi.jenis','=', $this->jenis)
        ->where('tb_agen.kode_agen','=', $this->kode_agen)
        ->select([
            DB::raw('tb_transaksi_detail.kode_barang'),
            DB::raw('tb_parfum.nama_barang'),
            DB::raw('tb_agen.nama_agen'),
            DB::raw('tb_parfum.h_beli'),
            DB::raw('tb_parfum.h_agen'),
            DB::raw('sum(jumlah) as total_brg'),
            DB::raw('sum(harga) as total_harga'),
        ])->groupBy('tb_transaksi_detail.kode_barang','tb_parfum.nama_barang','tb_agen.nama_agen','tb_parfum.h_beli','tb_parfum.h_agen')
        ->get();
        return $transact;
    }
}
