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
        Schema::create('aktivitas_terbaru', function (Blueprint $table) {
            $table->increments('id_aktivitas');
            $table->string("username",100)->nullable();
            $table->string("jenis_aktivitas",100);
            $table->string("deskripsi_aktivitas",200);
            $table->dateTime("waktu_aktivitas");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_activity');
    }
};
