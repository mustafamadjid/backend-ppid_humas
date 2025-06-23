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
        Schema::create('data_form_pengaduan', function (Blueprint $table) {
            $table->increments('id_pelapor'); 
            $table->string('nama_pelapor');
            $table->string('no_ktp_pelapor')->nullable();
            $table->text('alamat_pelapor')->nullable();
            $table->string('no_telp_pelapor')->nullable();
            $table->string('email_pelapor')->nullable();

            $table->string('nama_terlapor')->nullable();
            $table->string('jabatan_terlapor')->nullable();
            $table->text('deskripsi_penyalahgunaan')->nullable();
            $table->string('path_file_bukti')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_form_pengaduan');
    }
};
