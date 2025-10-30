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
        Schema::create('supersub_kriteria_indikator', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_supersub_kriteria')->nullable();
            $table->text('indikator')->nullable();
            $table->integer('nilai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supersub_kriteria_indikator');
    }
};
