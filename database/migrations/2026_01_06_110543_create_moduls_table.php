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
        Schema::create('moduls', function (Blueprint $table) {
           $table->id(); // PK

            $table->string('kelas_kode');
            $table->string('judul');
            $table->string('file_modul')->nullable();

            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('kelas_kode')
                ->references('kode_kelas')
                ->on('kelas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moduls');
    }
};
