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
        Schema::create('detail_krs', function (Blueprint $table) {
            $table->id();

            $table->string('krs_kode', 20);
            $table->string('kelas_kode', 20);

            $table->timestamps();

            $table->foreign('krs_kode')
                ->references('kode_krs')
                ->on('krs')
                ->onDelete('cascade');

            $table->foreign('kelas_kode')
                ->references('kode_kelas')
                ->on('kelas')
                ->onDelete('cascade');

            // mencegah kelas yang sama diambil dua kali dalam satu KRS
            $table->unique(['krs_kode', 'kelas_kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_krs');
    }
};
