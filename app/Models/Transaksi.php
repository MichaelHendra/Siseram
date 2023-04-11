<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'tb_transaksi';
    protected $primaryKey = 'kode_transaksi';
    public $incrementing = false;
    protected $fillable = ['kode_transaksi', 'kode_agen', 'nama_agen', 'tanggal', 'jenis', 'valid'];
    public $timestamps = true;
}
