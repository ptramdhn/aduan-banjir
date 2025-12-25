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
        Schema::create('laporan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->onDelete('cascade');
            // Siapa admin yang update? (Opsional, tapi bagus buat audit)
            $table->foreignId('admin_id')->constrained('users');

            $table->enum('status', ['pending', 'proses', 'selesai', 'tolak']);
            $table->text('keterangan'); // Isi pesan (Misal: "Tim OTW bawa perahu")

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_logs');
    }
};
