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
        Schema::create('data_kantor', function (Blueprint $table) {
            $table->increments('id_data');
            $table->string('alamat_kantor');
            $table->string('telepon_kantor');
            $table->string('email_kantor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kantor');
    }
};
