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
        Schema::create('kelas', function (Blueprint $table) {
            // PRIMARY KEY
            $table->string('kode_kelas', 20)->primary();

            // FOREIGN KEY
            $table->string('matakuliah_kode', 20); // FK ke matakuliahs
            $table->string('dosen_nidn', 20);      // FK ke dosens

            // DATA KELAS
            $table->string('hari', 20);        // Senin, Selasa, dll
            $table->time('jam_mulai');          // Jam mulai kuliah
            $table->time('jam_selesai');        // Jam selesai kuliah
            $table->string('ruang', 20);        // Ruang kelas
            $table->integer('kapasitas');       // Kuota kelas

            $table->timestamps();

            // RELASI
            $table->foreign('matakuliah_kode')
                ->references('kode_matakuliah')
                ->on('matakuliahs')
                ->onDelete('cascade');

            $table->foreign('dosen_nidn')
                ->references('nidn')
                ->on('dosens')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
