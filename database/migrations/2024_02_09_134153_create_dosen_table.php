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
        Schema::create('dosens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('nidn')->unique();
            $table->string('nip')->unique();
            $table->string('email')->unique();
            $table->string('nohp')->nullable();
            $table->date('tanggallahir');
            $table->string('tempatlahir');
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('golpangkat')->nullable();
            $table->string('homebase')->nullable();
            $table->string('jabatanfungsional')->nullable();
            $table->string('jabatanstruktural')->nullable();
            $table->string('jeniskelamin')->nullable();
            $table->string('jenispegawai')->nullable();
            $table->string('pendidikanterakhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
