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
        Schema::create('form_contact_us', function (Blueprint $table) {
            $table->increments('id_form');
            $table->string('nama_lengkap',100);
            $table->string('email',100);
            $table->string('no_telp',15);
            $table->string('subjek',100);
            $table->text('pesan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_contact_us');
    }
};
