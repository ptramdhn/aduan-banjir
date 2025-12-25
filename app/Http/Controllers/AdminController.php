<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LaporanLog; // Pastikan Model ini ada (sesuai langkah sebelumnya)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin (Statistik & Tabel Laporan Terbaru)
     */
    public function index()
    {
        // 1. Ambil Data Statistik (Optimized Count)
        // Kita hitung sekaligus agar lebih rapi
        $stats = [
            'total'   => Laporan::count(),
            'pending' => Laporan::where('status', 'pending')->count(),
            'proses'  => Laporan::where('status', 'proses')->count(),
            'selesai' => Laporan::where('status', 'selesai')->count(),
        ];

        // 2. Ambil Data Laporan (Terbaru & Pagination)
        // 'with' digunakan untuk mencegah N+1 Query Problem (Loading data user sekaligus)
        $laporans = Laporan::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('stats', 'laporans'));
    }

    /**
     * Menampilkan Halaman Detail Laporan (Peta, Foto, & Timeline)
     */
    public function show($id)
    {
        // Ambil laporan spesifik dengan relasi User dan Logs (serta Admin di dalam logs)
        $laporan = Laporan::with(['user', 'logs.admin'])
            ->findOrFail($id);

        return view('admin.show', compact('laporan'));
    }

    /**
     * Memproses Update Status & Menambahkan Catatan Log
     */
    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'status'     => 'required|in:pending,proses,selesai,tolak',
            'keterangan' => 'required|string|max:1000', // Keterangan wajib diisi agar tracking jelas
        ]);

        // Gunakan DB Transaction agar data konsisten (Atomic)
        // Jika salah satu gagal (update status atau create log), semua dibatalkan.
        DB::transaction(function () use ($request, $id) {

            // A. Ambil Data Laporan
            $laporan = Laporan::findOrFail($id);

            // B. Update Status di Tabel Utama
            $laporan->update([
                'status' => $request->status
            ]);

            // C. Buat Riwayat Baru di Tabel Logs
            LaporanLog::create([
                'laporan_id' => $laporan->id,
                'admin_id'   => Auth::id(),     // ID Admin yang sedang login
                'status'     => $request->status,
                'keterangan' => $request->keterangan,
            ]);
        });

        // 2. Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Status laporan diperbarui & riwayat tercatat!');
    }
}
