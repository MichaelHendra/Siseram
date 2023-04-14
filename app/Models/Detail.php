<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    protected $table = 'tb_transaksi_detail';
    protected $primaryKey = 'kode_detail';
    public $incrementing = true;
    protected $fillable = ['kode_detail', 'kode_transaksi', 'kode_barang', 'jumlah'];
    public $timestamps = true;
}
