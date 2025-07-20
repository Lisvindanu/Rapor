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
        Schema::create('keuangan_program', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_program', 100)->unique();
            $table->timestamps();

            // Indexes
            $table->index(['nama_program']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_program');
    }
};
