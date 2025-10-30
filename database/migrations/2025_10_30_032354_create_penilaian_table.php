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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('id_dokumen_penilaian');
            $table->unsignedBigInteger('id_supersub_kriteria');
            $table->integer('id_dokumen_penilaian_kaitan');
            $table->text('judul');
            $table->text('keterangan');
            $table->text('link_file');
            $table->boolean('status_aktif')->default(1);
            $table->text('isi');
            $table->text('hasil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
