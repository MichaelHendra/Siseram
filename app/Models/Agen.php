<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{
    use HasFactory;
    protected $table = 'tb_agen';
    protected $primaryKey = 'kode_agen';
    public $incrementing = false;
    protected $fillable = ['kode_agen', 'nama_agen','status'];
    public $timestamps = true;
}
