<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parfum extends Model
{
    use HasFactory;
    protected $table = 'tb_parfum';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $fillable = ['kode_barang', 'nama_barang', 'h_beli', 'h_agen'];
    public $timestamps = true;
}
