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
        // Cek apakah tabel sudah ada, jika ya drop dulu untuk clean install
        if (Schema::hasTable('pengaduan_terlapor')) {
            Schema::dropIfExists('pengaduan_terlapor');
        }

        // Pastikan tabel whistle_pengaduan ada
        if (!Schema::hasTable('whistle_pengaduan')) {
            throw new \Exception('Tabel whistle_pengaduan tidak ditemukan. Pastikan migration create_pengaduan_table sudah dijalankan.');
        }

        Schema::create('pengaduan_terlapor', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke whistle_pengaduan dengan UUID
            $table->uuid('pengaduan_id');
            $table->foreign('pengaduan_id')->references('id')->on('whistle_pengaduan')->onDelete('cascade');
            
            $table->string('nama_terlapor');
            $table->enum('status_terlapor', ['mahasiswa', 'pegawai']);
            $table->string('nomor_identitas')->nullable(); 
            $table->string('unit_kerja_fakultas')->nullable(); 
            $table->string('kontak_terlapor')->nullable(); 
            $table->timestamps();

            // Index untuk performa
            $table->index(['pengaduan_id']);
            $table->index(['status_terlapor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan_terlapor');
    }
};