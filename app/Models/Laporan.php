<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi (kecuali ID)
    protected $guarded = ['id'];

    protected $casts = [
        'foto_bukti' => 'array', // Casting otomatis JSON ke Array
    ];

    // Relasi: Setiap Laporan dimiliki oleh 1 User (Warga)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        // Urutkan dari yang terbaru (agar timeline nanti rapi)
        return $this->hasMany(LaporanLog::class)->latest();
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
