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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Pemohon)
            // onDelete cascade: Jika User dihapus, riwayat cutinya ikut hilang
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke Jenis Cuti
            $table->foreignId('jenis_cuti_id')->constrained('jenis_cutis')->onDelete('cascade');

            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->integer('lama_cuti'); // Disimpan angka biar gampang dihitung (sum)
            $table->text('alasan');

            // Untuk upload surat dokter/bukti lain (nullable alias boleh kosong)
            $table->string('file_bukti')->nullable();

            // Status: Menunggu Konfirmasi, Disetujui, Ditolak, Dibatalkan
            $table->string('status')->default('Menunggu Konfirmasi');

            // Kalau ditolak, atasan bisa isi alasannya di sini
            $table->text('catatan_atasan')->nullable();

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
