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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();

            // Definisi Foreign Key yang benar
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dosenpa_id')->nullable()->constrained('dosenpas')->onDelete('set null');

            // Menambahkan prodi_id sesuai permintaan
            $table->foreignId('prodi_id')->constrained('prodis')->onDelete('cascade');
            
            // Kolom-kolom yang tersisa
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('jenis_kelamin');
            $table->string('foto')->nullable();

            // Kolom email, password, dan id_tingkat telah dihapus
            // karena email dan password seharusnya dikelola oleh tabel 'users'.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
