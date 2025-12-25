<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    // Halaman Dashboard Warga (Riwayat Laporan)
    public function index()
    {
        // Ambil laporan milik user login beserta relasi 'logs' (riwayat) dan 'review' (ulasan)
        $laporans = Laporan::with(['logs', 'review'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('warga.dashboard', compact('laporans'));
    }

    // Halaman Form Lapor (Ada Petanya nanti)
    public function create()
    {
        return view('warga.lapor');
    }

    // Proses Simpan Laporan ke Database
    public function store(Request $request)
    {
        // 1. Validasi (Maksimal 3 foto)
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'foto_bukti' => 'required|array|max:3', // Harus array & Max 3 item
            'foto_bukti.*' => 'image|max:5120', // Tiap item harus gambar & max 5MB
            'ketinggian_air' => 'required',
            'deskripsi' => 'nullable|string',
            'alamat_manual' => 'required|string',
            'patokan' => 'nullable|string',
        ]);

        // 2. Proses Upload Multiple Files
        $fotoPaths = [];
        if ($request->hasFile('foto_bukti')) {
            foreach ($request->file('foto_bukti') as $file) {
                // Simpan tiap file dan masukkan path-nya ke array
                $fotoPaths[] = $file->store('bukti-banjir', 'public');
            }
        }

        // 3. Simpan ke Database
        Laporan::create([
            'user_id' => Auth::id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'foto_bukti' => $fotoPaths, // Laravel otomatis mengubah array ini jadi JSON
            'ketinggian_air' => $request->ketinggian_air,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
            'alamat_manual' => $request->alamat_manual,
            'patokan' => $request->patokan,
        ]);

        return redirect()->route('warga.dashboard')->with('success', 'Laporan berhasil dikirim!');
    }
}
