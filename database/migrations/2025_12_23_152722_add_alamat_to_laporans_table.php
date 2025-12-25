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
        Schema::table('laporans', function (Blueprint $table) {
            $table->text('alamat_manual')->after('longitude'); // Wajib
            $table->string('patokan')->nullable()->after('alamat_manual'); // Opsional
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['alamat_manual', 'patokan']);
        });
    }
};
