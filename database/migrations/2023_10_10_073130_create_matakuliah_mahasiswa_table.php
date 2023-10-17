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
        Schema::create('matakuliah_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_matakuliah');
            $table->foreign('id_matakuliah')->references('kode')->on('matakuliah')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_mahasiswa')->references('nim')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matakuliah_mahasiswa');
    }
};
