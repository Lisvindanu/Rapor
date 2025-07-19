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
        Schema::create('pengaduan_terlapor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->onDelete('cascade');
            $table->string('nama_terlapor');
            $table->enum('status_terlapor', ['mahasiswa', 'pegawai']);
            $table->string('nomor_identitas')->nullable(); // NIM untuk mahasiswa, NIP untuk pegawai
            $table->string('unit_kerja_fakultas')->nullable(); // Fakultas/Prodi/Unit Kerja
            $table->string('kontak_terlapor')->nullable(); // Email/No HP untuk konfirmasi
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