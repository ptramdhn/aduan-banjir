<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Siaga Banjir</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 h-16 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight text-slate-900">Siaga<span class="text-blue-600">Banjir</span></span>
                </div>
                <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-md border border-red-200">PANEL ADMIN</span>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <div class="text-xs text-slate-500 font-medium">Login sebagai</div>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-bold text-slate-800 hover:text-blue-600 transition cursor-pointer" title="Edit Profil">
                        {{ Auth::user()->name }}
                    </a>
                </div>

                <div class="h-8 w-px bg-slate-200 mx-2 hidden md:block"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-slate-500 hover:text-red-600 transition font-medium text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="hidden md:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 flex-grow">
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Laporan</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['total'] }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-yellow-400">
                <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider">Pending</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['pending'] }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-blue-500">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Sedang Proses</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['proses'] }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-green-500">
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Selesai</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['selesai'] }}</h2>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg">Daftar Laporan Masuk</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs">
                        <tr>
                            <th class="px-6 py-4">Tanggal & Pelapor</th>
                            <th class="px-6 py-4">Lokasi & Foto</th>
                            <th class="px-6 py-4">Kondisi & Prioritas</th> <th class="px-6 py-4">Status Saat Ini</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 align-top">
                                    <div class="font-bold text-slate-800">{{ $laporan->user->name }}</div>
                                    <div class="text-xs text-slate-400 mt-1">{{ $laporan->created_at->format('d M Y, H:i') }}</div>
                                    <div class="text-xs text-slate-500 mt-2 bg-slate-100 inline-block px-2 py-1 rounded">
                                        {{ $laporan->user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="flex gap-3">
                                        @php
                                            $thumb = is_array($laporan->foto_bukti) ? ($laporan->foto_bukti[0] ?? null) : $laporan->foto_bukti;
                                        @endphp
                                        <div class="w-16 h-16 rounded-lg bg-slate-200 overflow-hidden flex-shrink-0 border">
                                            <img src="{{ asset('storage/' . $thumb) }}" class="w-full h-full object-cover">
                                        </div>
                                        
                                        <div class="flex flex-col justify-center">
                                            <a href="https://www.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}" 
                                            target="_blank" 
                                            class="text-blue-600 hover:text-blue-800 font-bold text-xs flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Lihat Peta
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="font-bold block text-slate-800">
                                        {{ ucfirst(str_replace('_', ' ', $laporan->ketinggian_air)) }}
                                    </span>
                                    
                                    <div class="mt-2">
                                        @php
                                            $priority = match($laporan->ketinggian_air) {
                                                'tenggelam', 'sedada' => ['label' => 'URGENT ⚡', 'class' => 'bg-red-100 text-red-700 border-red-200 animate-pulse'],
                                                'sepinggang', 'selutut' => ['label' => 'MEDIUM ⚠️', 'class' => 'bg-orange-100 text-orange-700 border-orange-200'],
                                                default => ['label' => 'LOW 🟢', 'class' => 'bg-slate-100 text-slate-600 border-slate-200'],
                                            };
                                        @endphp
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded border {{ $priority['class'] }}">
                                            {{ $priority['label'] }}
                                        </span>
                                    </div>

                                    <p class="text-xs text-slate-500 mt-2 italic line-clamp-2">
                                        "{{ Str::limit($laporan->deskripsi, 50) }}"
                                    </p>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span @class([
                                        'px-3 py-1 rounded-full text-xs font-bold uppercase border',
                                        'bg-yellow-50 text-yellow-700 border-yellow-200' => $laporan->status == 'pending',
                                        'bg-blue-50 text-blue-700 border-blue-200'       => $laporan->status == 'proses',
                                        'bg-green-50 text-green-700 border-green-200'    => $laporan->status == 'selesai',
                                        'bg-red-50 text-red-700 border-red-200'          => $laporan->status == 'tolak',
                                    ])>
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-middle text-center">
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" 
                                       class="inline-flex items-center gap-1 bg-slate-800 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-slate-700 transition shadow-lg shadow-slate-300/50">
                                        <span>Proses & Detail</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p>Belum ada data laporan masuk.</p>
                                    </div>
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

    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="text-xs text-slate-400">© {{ date('Y') }} Sistem Pelaporan Banjir Kelurahan (Panel Admin).</p>
        </div>
    </footer>
</body>
</html>