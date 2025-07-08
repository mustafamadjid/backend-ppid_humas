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
        Schema::create('sematan_aplikasi', function (Blueprint $table) {
            $table->increments('id_sematan');
            $table->string('judul_sematan',50);
            $table->string('url_sematan',255);
            $table->string('icon',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sematan_aplikasi');
    }
};
