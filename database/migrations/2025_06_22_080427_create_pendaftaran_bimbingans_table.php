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
        Schema::create('pendaftaran_bimbingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->foreignId('jadwal_bimbingan_id')->constrained('jadwal_bimbingans')->onDelete('cascade');
            $table->string('topik_mahasiswa');
            $table->text('deskripsi_mahasiswa');
            $table->string('dokumen_mahasiswa')->nullable();
            $table->enum('status_pengajuan', ['Diajukan', 'Diterima', 'Ditolak', 'Selesai'])->default('Diajukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_bimbingans');
    }
};
