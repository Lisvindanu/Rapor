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
        Schema::create('keuangan_tandatangan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_ttd', 50)->unique();
            $table->string('jabatan', 200);
            $table->string('nama', 200);
            $table->text('gambar_ttd')->nullable();
            $table->timestamps();

            // Index untuk PostgreSQL
            $table->index('nomor_ttd');
            $table->index('nama');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_tandatangan');
    }
};
