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
        Schema::create('jabatan_hierarki', function (Blueprint $table) {
            $table->increments('id_hierarki');
            $table->unsignedInteger('id_jabatan');
            $table->unsignedInteger('id_atasan')->nullable();
            $table->timestamps();

            $table->foreign('id_jabatan')
                ->references('id_jabatan')
                ->on('jabatan_organisasi')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_atasan')
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
        Schema::dropIfExists('jabatan_hierarki');
    }
};
