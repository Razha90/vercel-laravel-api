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
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->id('kode');
            $table->string('nama_matakuliah', 100)->nullable(false);
            $table->bigInteger('daya_tampung')->unsigned();
            $table->dateTime("jadwal");
            $table->unsignedBigInteger('id_dosen');
            $table->foreign('id_dosen')->references('nim')->on('dosen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matakuliah');
    }
};
