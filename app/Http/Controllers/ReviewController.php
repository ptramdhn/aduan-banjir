<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $laporan_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $laporan = Laporan::findOrFail($laporan_id);

        // Pastikan hanya pemilik laporan yang bisa review & status harus selesai
        if ($laporan->user_id != Auth::id() || $laporan->status != 'selesai') {
            return abort(403, 'Aksi tidak diizinkan.');
        }

        // Cek apakah sudah pernah review
        if ($laporan->review) {
            return back()->with('error', 'Anda sudah memberikan ulasan.');
        }

        Review::create([
            'laporan_id' => $laporan->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih atas masukan Anda! ⭐');
    }
}
