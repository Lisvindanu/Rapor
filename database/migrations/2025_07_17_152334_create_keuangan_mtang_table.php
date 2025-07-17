<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan_mtang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_mata_anggaran', 20)->unique();
            $table->string('nama_mata_anggaran', 255);
            $table->string('nama_mata_anggaran_en', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->uuid('parent_mata_anggaran')->nullable();
            $table->tinyInteger('level_mata_anggaran')->default(0);
            $table->string('kategori', 100)->nullable();
            $table->decimal('alokasi_anggaran', 15, 2)->default(0);
            $table->decimal('sisa_anggaran', 15, 2)->default(0);
            $table->year('tahun_anggaran');
            $table->boolean('status_aktif')->default(true);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();

            // Indexes (buat dulu sebelum foreign key)
            $table->index(['parent_mata_anggaran']);
            $table->index(['tahun_anggaran']);
            $table->index(['status_aktif']);
            $table->index(['kode_mata_anggaran', 'tahun_anggaran']);
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
