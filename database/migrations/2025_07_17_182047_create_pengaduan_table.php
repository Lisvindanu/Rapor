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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id'); // Menggunakan UUID untuk compatibility dengan users table
            $table->foreignId('kategori_id')->constrained('kategori_pengaduan')->onDelete('cascade');
            $table->string('kode_pengaduan')->unique();
            $table->string('judul_pengaduan');
            $table->text('deskripsi_pengaduan');
            $table->datetime('tanggal_pengaduan');
            $table->enum('status_pengaduan', ['pending', 'proses', 'selesai', 'ditolak'])->default('pending');
            $table->boolean('is_anonim')->default(false);
            $table->string('evidence_path')->nullable();
            $table->text('admin_response')->nullable();
            $table->uuid('handled_by')->nullable(); // Menggunakan UUID untuk user yang menangani
            $table->datetime('closed_at')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('handled_by')->references('id')->on('users')->onDelete('set null');

            // Index untuk performa
            $table->index(['user_id', 'status_pengaduan']);
            $table->index('kode_pengaduan');
            $table->index('tanggal_pengaduan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};