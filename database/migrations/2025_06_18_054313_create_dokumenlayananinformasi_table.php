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
        Schema::create('dokumenlayananinformasi', function (Blueprint $table) {
            $table->increments('id_dokumen');
            $table->string('nama_dokumen');
            $table->string('path_dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumenlayananinformasi');
    }
};
