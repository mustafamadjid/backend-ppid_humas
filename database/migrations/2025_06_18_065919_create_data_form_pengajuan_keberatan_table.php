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
        Schema::create('data_form_pengajuan_keberatan', function (Blueprint $table) {
            $table->increments('id_pemohon'); 
            $table->string('nama_pemohon');
            $table->string('no_ktp_pemohon')->nullable();
            $table->text('alamat_pemohon')->nullable();
            $table->string('no_telp_pemohon')->nullable();
            $table->string('email_pemohon')->nullable();
            $table->string('pekerjaan_pemohon')->nullable();
            $table->text('tujuan_pengajuan')->nullable();
            $table->text('alasan_pengajuan')->nullable();
            $table->string('path_file_bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_form_pengajuan_keberatan');
    }
};
