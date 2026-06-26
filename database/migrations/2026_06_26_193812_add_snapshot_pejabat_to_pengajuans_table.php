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
    Schema::table('pengajuans', function (Blueprint $table) {

        // Kasi
        $table->string('nama_kasi')->nullable();
        $table->string('nip_kasi')->nullable();
        $table->string('jabatan_kasi')->nullable();

        // Kabid
        $table->string('nama_kabid')->nullable();
        $table->string('nip_kabid')->nullable();
        $table->string('jabatan_kabid')->nullable();

        // Kasubbag
        $table->string('nama_kasubbag')->nullable();
        $table->string('nip_kasubbag')->nullable();
        $table->string('jabatan_kasubbag')->nullable();

        // Sekdin
        $table->string('nama_sekdin')->nullable();
        $table->string('nip_sekdin')->nullable();
        $table->string('jabatan_sekdin')->nullable();

        // Kadin
        $table->string('nama_kadin')->nullable();
        $table->string('nip_kadin')->nullable();
        $table->string('jabatan_kadin')->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            //
        });
    }
};
