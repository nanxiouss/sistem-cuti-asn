<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pangkats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pangkat', 100);
            $table->string('golongan', 10);    
            $table->string('ruang', 5);         
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pangkats');
    }
};