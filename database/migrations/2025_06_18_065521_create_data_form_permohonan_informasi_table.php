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
        Schema::create('data_form_permohonan_informasi', function (Blueprint $table) {
            $table->increments('id_permohonan'); // Primary key, integer auto increment
            $table->string('nama_pemohon');
            $table->string('no_ktp_pemohon')->nullable();
            $table->text('alamat_pemohon')->nullable();
            $table->string('no_telp_pemohon')->nullable();
            $table->string('email_pemohon')->nullable();
            $table->text('kebutuhan_informasi_pemohon')->nullable();
            $table->text('alasan_permintaan')->nullable();

            $table->string('nama_pengguna')->nullable();
            $table->string('no_ktp_pengguna')->nullable();
            $table->text('alamat_pengguna')->nullable();
            $table->string('no_telp_pengguna')->nullable();
            $table->string('email_pengguna')->nullable();
            $table->text('kebutuhan_informasi_pengguna')->nullable();
            $table->text('alasan_penggunaan')->nullable();

            $table->text('cara_perolehan_informasi')->nullable();
            $table->string('format_informasi')->nullable();
            $table->string('cara_pengiriman_informasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_form_permohonan_informasi');
    }
};
