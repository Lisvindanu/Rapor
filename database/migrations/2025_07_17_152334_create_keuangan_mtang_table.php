<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing table first if you want complete fresh start
        Schema::dropIfExists('keuangan_mtang');

        // Create new structure with proper field sizes for Roman numerals and longer names
        Schema::create('keuangan_mtang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_mata_anggaran', 50)->unique(); // Increased from 20 to 50
            $table->string('nama_mata_anggaran', 500); // Increased from 255 to 500
            $table->uuid('parent_mata_anggaran')->nullable();
            $table->enum('kategori', ['debet', 'kredit']);
            $table->timestamps();

            // Indexes
            $table->index(['parent_mata_anggaran']);
            $table->index(['kategori']);
            $table->index(['kode_mata_anggaran']);
        });

        // Add foreign key constraint setelah tabel dibuat
        Schema::table('keuangan_mtang', function (Blueprint $table) {
            $table->foreign('parent_mata_anggaran')
                ->references('id')
                ->on('keuangan_mtang')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan_mtang');
    }
};
