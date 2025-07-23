<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_bukti', 50)->unique();
            $table->date('tanggal');
            $table->text('sudah_terima_dari');
            $table->text('uang_sebanyak');
            $table->decimal('uang_sebanyak_angka', 15, 2);
            $table->text('untuk_pembayaran');

            // Master data relations (UUID)
            $table->uuid('mata_anggaran_id');
            $table->uuid('program_id');
            $table->uuid('sumber_dana_id');
            $table->uuid('tahun_anggaran_id');

            // Signatures (UUID, nullable)
            $table->uuid('dekan_id')->nullable();
            $table->uuid('wakil_dekan_ii_id')->nullable();
            $table->uuid('ksb_keuangan_id')->nullable();
            $table->uuid('penerima_id')->nullable();

            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'paid'])->default('draft');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            // Foreign keys
            $table->foreign('mata_anggaran_id')->references('id')->on('keuangan_mtang');
            $table->foreign('program_id')->references('id')->on('keuangan_program');
            $table->foreign('sumber_dana_id')->references('id')->on('keuangan_sumberdana');
            $table->foreign('tahun_anggaran_id')->references('id')->on('keuangan_tahun_anggaran');
            $table->foreign('dekan_id')->references('id')->on('keuangan_tandatangan');
            $table->foreign('wakil_dekan_ii_id')->references('id')->on('keuangan_tandatangan');
            $table->foreign('ksb_keuangan_id')->references('id')->on('keuangan_tandatangan');
            $table->foreign('penerima_id')->references('id')->on('keuangan_tandatangan');

            // Indexes
            $table->index(['tanggal', 'status']);
            $table->index('nomor_bukti');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan_pengeluaran');
    }
};
