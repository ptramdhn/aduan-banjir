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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            // Siapa yang lapor?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Lokasi (Koordinat GPS)
            $table->string('latitude');
            $table->string('longitude');

            // Data Laporan
            $table->json('foto_bukti');
            $table->text('deskripsi')->nullable();

            $table->enum('ketinggian_air', [
                'semata_kaki',
                'selutut',
                'sepinggang',
                'sedada',
                'tenggelam'
            ]);

            // Status Laporan (Alur Admin)
            $table->enum('status', ['pending', 'proses', 'selesai', 'tolak'])
                ->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
