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
        Schema::create('keuangan_tahun_anggaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tahun_anggaran', 10)->unique();
            $table->date('tgl_awal_anggaran');
            $table->date('tgl_akhir_anggaran');
            $table->timestamps();

            // Indexes
            $table->index(['tahun_anggaran']);
            $table->index(['tgl_awal_anggaran']);
            $table->index(['tgl_akhir_anggaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_tahun_anggaran');
    }
};
