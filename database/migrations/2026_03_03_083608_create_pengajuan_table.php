<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jenis_cuti_id')->constrained('jenis_cutis');

            $table->unsignedBigInteger('id_atasan')->nullable();
            $table->foreign('id_atasan')->references('id')->on('users');

            $table->text('alasan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->integer('lama_cuti');
            $table->text('alamat_cuti');
            $table->string('no_telepon');
            $table->string('file_bukti')->nullable();

            $table->text('catatan_admin')->nullable();
            $table->text('catatan_kasi')->nullable();
            $table->text('catatan_kabid')->nullable();
            $table->text('catatan_kasubbag')->nullable();
            $table->text('catatan_sekdin')->nullable();
            $table->text('catatan_kadin')->nullable();

            $table->text('ttd_pegawai');
            $table->text('ttd_kasi')->nullable();
            $table->text('ttd_kabid')->nullable();
            $table->text('ttd_kasubbag')->nullable();
            $table->text('ttd_sekdin')->nullable();
            $table->text('ttd_kadin')->nullable();

            $table->dateTime('tgl_ttd_kasi')->nullable();
            $table->dateTime('tgl_ttd_kabid')->nullable();
            $table->dateTime('tgl_ttd_kasubbag_umum')->nullable();
            $table->dateTime('tgl_ttd_sekdin')->nullable();
            $table->dateTime('tgl_ttd_kadin')->nullable();

            // DEFAULT STATUS SESUAI FLOWCHART: Lari ke Penelaah Teknis (Admin) dulu
            $table->string('status')->default('Menunggu Verifikasi Admin');
            $table->unsignedTinyInteger('snapshot_sisa_n')->nullable();
            $table->unsignedTinyInteger('snapshot_sisa_n1')->nullable();
            $table->unsignedTinyInteger('snapshot_sisa_n2')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
