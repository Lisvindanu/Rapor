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
        Schema::create('master_invoice', function (Blueprint $table) {
            $table->string('id')->primary(); // contoh: 476912-624023
            $table->bigInteger('id_tagihan');
            $table->bigInteger('id_transaksi');
            $table->string('kode_transaksi');
            $table->string('id_periode');
            $table->string('uraian')->nullable();
            $table->timestamp('tanggal_transaksi')->nullable();
            $table->timestamp('tanggal_akhir')->nullable();
            $table->string('nim');
            $table->string('nama_mahasiswa');
            $table->bigInteger('id_pendaftar')->nullable();
            $table->string('nama_pendaftar')->nullable();
            $table->string('id_periode_daftar')->nullable();
            $table->string('id_jenis_akun');
            $table->string('jenis_akun');
            $table->string('id_mata_uang');
            $table->decimal('nominal_tagihan', 15, 2)->default(0);
            $table->decimal('nominal_denda', 15, 2)->default(0);
            $table->decimal('nominal_potongan', 15, 2)->default(0);
            $table->decimal('total_potongan', 15, 2)->default(0);
            $table->decimal('nominal_terbayar', 15, 2)->default(0);
            $table->decimal('nominal_sisa_tagihan', 15, 2)->default(0);
            $table->boolean('is_lunas')->default(false);
            $table->boolean('is_batal')->default(false);
            $table->boolean('is_rekon')->default(false);
            $table->timestamp('waktu_rekon')->nullable();
            $table->timestamp('tanggal_suspend')->nullable();
            $table->boolean('is_transfer_nanti')->default(false);
            $table->timestamp('tanggal_transfer')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_invoice');
    }
};
