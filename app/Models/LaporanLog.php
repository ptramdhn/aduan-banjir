<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanLog extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Laporan Induk
    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    // Relasi ke Admin yang update
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
