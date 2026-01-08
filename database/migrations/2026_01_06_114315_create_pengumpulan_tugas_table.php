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
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('tugas_kode'); // FK ke tabel tugas
            $table->string('mahasiswa_nobp'); // FK ke tabel mahasiswa
            $table->string('upload_file_jawaban')->nullable();
            $table->decimal('nilai', 5, 2)->nullable(); // nilai bisa desimal
            $table->timestamps(); // created_at = waktu submit, updated_at = waktu terakhir diubah

            // FOREIGN KEY
            $table->foreign('tugas_kode')
                ->references('kode_tugas')
                ->on('tugas')
                ->onDelete('cascade');

            $table->foreign('mahasiswa_nobp')
                ->references('nobp')
                ->on('mahasiswas')
                ->onDelete('cascade');

            // Satu mahasiswa hanya boleh submit satu kali per tugas
            $table->unique(['tugas_kode', 'mahasiswa_nobp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
