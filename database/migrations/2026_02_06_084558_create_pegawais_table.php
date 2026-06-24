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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('atasan_id')->nullable();
            $table->foreign('atasan_id')->references('id')->on('users')->onDelete('set null');
            $table->foreignId('bidang_id')->nullable()->constrained('bidangs')->nullOnDelete();
            $table->foreignId('pangkat_id')->nullable()->constrained('pangkats')->nullOnDelete();
            $table->string('jabatan', 100)->nullable();
            $table->date('masa_kerja')->nullable();
            $table->integer('sisa_cuti_tahunan')->default(12);
            $table->integer('sisa_cuti_besar')->default(90);
            $table->integer('sisa_cuti_melahirkan')->default(90);
            $table->string('no_telepon', 20)->nullable();

            $table->string('foto_profil')->nullable();
            $table->string('foto_ttd')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
