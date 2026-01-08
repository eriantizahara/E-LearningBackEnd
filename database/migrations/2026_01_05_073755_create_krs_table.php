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
        Schema::create('krs', function (Blueprint $table) {
            // PRIMARY KEY
            $table->string('kode_krs', 20)->primary();

            // FOREIGN KEY + UNIQUE (1 mahasiswa = 1 KRS)
            $table->string('mahasiswa_nobp', 20)->unique();

            $table->enum('status', ['approved', 'pending']);

            $table->timestamps();

            // RELASI MAHASISWA
            $table->foreign('mahasiswa_nobp')
                ->references('nobp')
                ->on('mahasiswas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
