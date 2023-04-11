<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_parfum', function (Blueprint $table) {
            $table->string('kode_barang')->primary();
            $table->string('nama_barang');
            $table->bigInteger('h_beli');
            $table->bigInteger('h_agen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_parfum');
    }
};
