<?php

namespace App\Exports;

use App\Models\Stok;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StokFilter implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $kode_agen;
    use Exportable;
    public function __construct(String $kode_agen)
    {
        $this->kode_agen = $kode_agen;
    }
    public function headings(): array
    {
        return [
            'Kode Agen',
            'Nama Agen',
            'Nama Barang',
            'Jumlah',
        ];
    }
    public function collection()
    {
        $stok = Stok::join('tb_parfum', 'tb_stok.kode_barang', '=', 'tb_parfum.kode_barang')
            ->join('tb_agen', 'tb_stok.kode_agen', '=', 'tb_agen.kode_agen')
            ->select('tb_stok.kode_agen', 'tb_agen.nama_agen', 'tb_parfum.nama_barang', 'tb_stok.jumlah', )
            ->where('tb_stok.kode_agen', $this->kode_agen)
            ->get();
        return $stok;
    }
}
