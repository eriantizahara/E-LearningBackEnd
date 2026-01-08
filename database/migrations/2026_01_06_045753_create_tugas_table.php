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
        Schema::create('tugas', function (Blueprint $table) {
            // PRIMARY KEY
            $table->string('kode_tugas', 20)->primary();

            // FOREIGN KEY ke KELAS
            $table->string('kelas_kode', 20);
            $table->foreign('kelas_kode')
                ->references('kode_kelas')
                ->on('kelas')
                ->onDelete('cascade');

            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('upload_file_tugas')->nullable(); // file dari dosen
            $table->dateTime('deadline')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
