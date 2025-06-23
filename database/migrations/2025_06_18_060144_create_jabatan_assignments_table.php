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
        Schema::create('jabatan_assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pegawai');
            $table->unsignedInteger('id_jabatan')->nullable();
            $table->timestamps();

            $table->foreign('id_pegawai')
                ->references('id_pegawai')
                ->on('pegawai')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_jabatan')
                ->references('id_jabatan')
                ->on('jabatan_organisasi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan_assignments');
    }
};
