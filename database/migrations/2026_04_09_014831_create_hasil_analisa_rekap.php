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
        Schema::create('hasil_analisa_rekap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_supersub_kriteria')->nullable();
            $table->text('deskripsi')->nullable();
            $table->float('nilai_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_analisa_rekap');
    }
};
