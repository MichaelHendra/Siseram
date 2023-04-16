<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'tb_stok';
    protected $primaryKey = 'kode_stok';
    public $incrementing = true;
    protected $fillable = ['kode_stok', 'kode_agen', 'kode_barang', 'jumlah'];
    public $timestamps = true;
}
