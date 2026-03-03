<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jenis_cuti_id')->constrained('jenis_cutis');
            $table->foreignId('id_atasan')->constrained('users');
            $table->text('alasan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->integer('lama_cuti');
            $table->text('alamat_cuti');
            $table->string('no_telepon');
            $table->string('file_bukti')->nullable();
            $table->string('status')->default('Menunggu Kasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
