<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Laporan - Ruang Lurah</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 h-16 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('lurah.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight text-slate-900">Siaga<span class="text-indigo-600">Banjir</span></span>
                </a>
                <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-1 rounded-md border border-indigo-200">RUANG LURAH</span>
            </div>

            <div class="flex items-center gap-6">
                <nav class="hidden md:flex gap-6 text-sm font-medium">
                    <a href="{{ route('lurah.dashboard') }}" class="text-slate-500 hover:text-indigo-600 transition pb-0.5">Dashboard</a>
                    <a href="{{ route('lurah.rekap') }}" class="text-indigo-600 border-b-2 border-indigo-600 pb-0.5">Rekap Data</a>
                    <a href="{{ route('lurah.staff.index') }}" class="text-slate-500 hover:text-indigo-600 transition pb-0.5">Staff Admin</a>
                </nav>
                <div class="h-6 w-px bg-slate-200 hidden md:block"></div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <div class="text-xs text-slate-500 font-medium">Login sebagai</div>
                        <a href="{{ route('profile.edit') }}" class="text-sm font-bold text-slate-800 hover:text-indigo-600 transition">
                            {{ Auth::user()->name }}
                        </a>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-slate-500 hover:text-red-600 transition font-medium text-sm" title="Keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 flex-grow">
        
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Rekapitulasi Laporan</h1>
            <p class="text-slate-500 text-sm mt-1">Arsip data laporan banjir yang masuk ke sistem.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 mb-6">
            <form action="{{ route('lurah.rekap') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status</label>
                    <select name="status" class="w-full md:w-40 border-slate-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border-slate-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border-slate-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter Data
                    </button>
                    <a href="{{ route('lurah.rekap') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2.5 rounded-lg text-sm font-bold transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Pelapor</th>
                            <th class="px-6 py-4">Lokasi & Alamat</th>
                            <th class="px-6 py-4">Kondisi Air</th>
                            <th class="px-6 py-4 text-center">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $laporan->created_at->format('d/m/Y') }} <br>
                                    <span class="text-xs text-slate-400">{{ $laporan->created_at->format('H:i') }} WIB</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $laporan->user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $laporan->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate">
                                    <a href="http://maps.google.com/?q={{ $laporan->latitude }},{{ $laporan->longitude }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Lihat Peta
                                    </a>
                                    <div class="text-xs text-slate-500 mt-1 truncate" title="{{ $laporan->alamat_manual }}">
                                        {{ $laporan->alamat_manual ?? 'Alamat tidak diisi' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800">
                                        {{ ucfirst(str_replace('_', ' ', $laporan->ketinggian_air)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span @class([
                                        'px-2.5 py-1 rounded-full text-xs font-bold uppercase border',
                                        'bg-yellow-50 text-yellow-700 border-yellow-200' => $laporan->status == 'pending',
                                        'bg-blue-50 text-blue-700 border-blue-200'       => $laporan->status == 'proses',
                                        'bg-green-50 text-green-700 border-green-200'    => $laporan->status == 'selesai',
                                        'bg-red-50 text-red-700 border-red-200'          => $laporan->status == 'tolak',
                                    ])>
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    Tidak ada data laporan yang sesuai filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $laporans->links() }}
            </div>
        </div>
        
    </main>

</body>
</html>