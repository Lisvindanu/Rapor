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
        Schema::create('keuangan_sumberdana', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_sumber_dana', 200)->unique();
            $table->timestamps();

            // Indexes untuk optimasi pencarian
            $table->index(['nama_sumber_dana']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_sumberdana');
    }
};
