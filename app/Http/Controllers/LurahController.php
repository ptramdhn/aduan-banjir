<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LurahController extends Controller
{
    public function dashboard()
    {
        // 1. Statistik Ringkas
        $stats = [
            'total'   => Laporan::count(),
            'pending' => Laporan::where('status', 'pending')->count(),
            'proses'  => Laporan::where('status', 'proses')->count(),
            'selesai' => Laporan::where('status', 'selesai')->count(),
        ];

        // --- LOGIKA RESPONSE TIME ---
        $laporanDirespon = Laporan::with('logs')->where('status', '!=', 'pending')->get();
        $totalMenit = 0;
        $jumlahData = 0;
        foreach ($laporanDirespon as $laporan) {
            $logPertama = $laporan->logs->sortBy('created_at')->first();
            if ($logPertama) {
                $totalMenit += $laporan->created_at->diffInMinutes($logPertama->created_at);
                $jumlahData++;
            }
        }
        $avgResponseTime = $jumlahData > 0 ? round($totalMenit / $jumlahData) : 0;
        $stats['response_time'] = $avgResponseTime > 60
            ? floor($avgResponseTime / 60) . ' Jam ' . ($avgResponseTime % 60) . ' Mnt'
            : $avgResponseTime . ' Menit';

        // 2. Data Grafik Mingguan
        $chartData = Laporan::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        $labels = $chartData->pluck('date');
        $data   = $chartData->pluck('count');

        // 3. Review Terbaru
        $reviews = Review::with(['user', 'laporan'])->latest()->take(5)->get();

        // --- 4. DATA PETA SEBARAN (BARU) ---
        // Kita ambil data laporan yang belum selesai (pending/proses) agar Lurah fokus ke masalah aktif.
        // Atau ambil semua juga boleh. Di sini kita ambil yang statusnya belum 'selesai' & 'tolak'.
        $mapData = Laporan::whereIn('status', ['pending', 'proses'])
            ->select('latitude', 'longitude', 'ketinggian_air', 'alamat_manual', 'status')
            ->get();

        return view('lurah.dashboard', compact('stats', 'labels', 'data', 'reviews', 'mapData'));
    }

    // --- HALAMAN REKAP LAPORAN (Baru) ---
    public function rekap(Request $request)
    {
        $query = Laporan::with('user')->latest();

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Tanggal (Start - End)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $laporans = $query->paginate(10)->withQueryString(); // withQueryString agar filter tidak hilang saat ganti halaman

        return view('lurah.rekap', compact('laporans'));
    }

    // --- MANAJEMEN STAFF ---

    public function staff()
    {
        // Ambil hanya user dengan role 'admin'
        $staffs = User::where('role', 'admin')->latest()->get();
        return view('lurah.staff', compact('staffs'));
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'password' => Hash::make($request->password),
            'role'     => 'admin', // Otomatis set sebagai Admin
        ]);

        return back()->with('success', 'Staff admin baru berhasil ditambahkan!');
    }

    public function destroyStaff($id)
    {
        $user = User::where('role', 'admin')->findOrFail($id);
        $user->delete();

        return back()->with('success', 'Akun staff berhasil dihapus.');
    }
}
