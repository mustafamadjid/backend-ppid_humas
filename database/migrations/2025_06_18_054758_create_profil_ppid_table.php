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
        Schema::create('profil_ppid', function (Blueprint $table) {
            $table->increments('id_profil');
            $table->string('deskripsi_profil');
            $table->string('visi_ppid');
            $table->string('misi_ppid');
            $table->string('tugas_ppid');
            $table->string('fungsi_ppid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_ppid');
    }
};
