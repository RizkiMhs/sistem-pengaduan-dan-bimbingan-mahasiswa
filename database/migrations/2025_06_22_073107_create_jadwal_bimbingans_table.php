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
        Schema::create('jadwal_bimbingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosenpa_id')->constrained('dosenpas')->onDelete('cascade');
            $table->foreignId('kategori_bimbingan_id')->constrained('kategori_bimbingans')->onDelete('cascade');
            $table->string('topik_umum');
            $table->dateTime('waktu_mulai');
            $table->unsignedTinyInteger('kuota_per_hari')->default(3);
            $table->enum('status', ['Tersedia', 'Penuh', 'Ditutup'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_bimbingans');
    }
};
