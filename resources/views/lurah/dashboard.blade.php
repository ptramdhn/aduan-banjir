<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Lurah - Monitoring Wilayah</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

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
                    <a href="{{ route('lurah.dashboard') }}" class="text-indigo-600 border-b-2 border-indigo-600 pb-0.5">Dashboard</a>
                    <a href="{{ route('lurah.rekap') }}" class="text-slate-500 hover:text-indigo-600 transition pb-0.5">Rekap Data</a>
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
        
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Executive Dashboard</h1>
                <p class="text-slate-500 text-sm mt-1">Ringkasan aktivitas pelaporan dan kinerja penanganan banjir.</p>
            </div>
            <div class="text-sm text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200 shadow-sm">
                📅 {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-indigo-600 p-5 rounded-2xl shadow-lg shadow-indigo-200 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-indigo-200 uppercase tracking-wider">Rata-rata Respon</p>
                        <h2 class="text-2xl font-bold mt-1">{{ $stats['response_time'] ?? '-' }}</h2>
                    </div>
                    <div class="p-2 bg-indigo-500 rounded-lg text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-[10px] mt-2 text-indigo-100">Waktu dari lapor s/d diproses</p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Laporan</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total'] }}</h2>
            </div>
            
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 border-b-4 border-b-yellow-400">
                <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider">Pending</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['pending'] }}</h2>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 border-b-4 border-b-blue-500">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Proses</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['proses'] }}</h2>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 border-b-4 border-b-green-500">
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Selesai</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['selesai'] }}</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Peta Sebaran Banjir (Real-time)
                </h3>
                <div class="flex gap-2 text-[10px] font-bold">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-600"></span> BAHAYA</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-orange-500"></span> SIAGA</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> WASPADA</span>
                </div>
            </div>
            
            <div id="map" class="h-96 w-full rounded-xl border border-slate-200 z-0"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Tren Laporan 7 Hari Terakhir
                </h3>
                <div class="relative h-72 w-full">
                    <canvas id="laporanChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    Suara Warga Terbaru
                </h3>
                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($reviews as $review)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex justify-between items-start mb-1">
                                <span class="font-bold text-xs text-slate-700">{{ $review->user->name }}</span>
                                <span class="text-[10px] text-slate-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex gap-0.5 mb-1">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-slate-200' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                @endfor
                            </div>
                            <p class="text-xs text-slate-600 italic">"{{ Str::limit($review->komentar, 60) }}"</p>
                        </div>
                    @empty
                        <p class="text-center text-slate-400 text-sm py-4">Belum ada ulasan.</p>
                    @endforelse
                </div>
            </div>
        </div>
        
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="text-xs text-slate-400">© {{ date('Y') }} Sistem Pelaporan Banjir Kelurahan (Panel Lurah).</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // --- 1. CONFIG CHART.JS ---
            const ctx = document.getElementById('laporanChart');
            const labels = {!! json_encode($labels) !!};
            const data = {!! json_encode($data) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: data,
                        borderWidth: 2,
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        pointBackgroundColor: '#4F46E5',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { 
                        y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { borderDash: [2, 4] } }, 
                        x: { grid: { display: false } } 
                    }
                }
            });

            // --- 2. CONFIG LEAFLET MAP ---
            const map = L.map('map').setView([-6.200000, 106.816666], 13); // Default Jakarta (Akan auto center nanti)

            // Tile Layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Data Laporan dari Controller
            const mapData = {!! json_encode($mapData) !!};
            const markers = [];

            mapData.forEach(item => {
                let color = 'blue';
                let radius = 8;
                
                // Logika Warna Berdasarkan Ketinggian
                if (item.ketinggian_air === 'tenggelam' || item.ketinggian_air === 'sedada') {
                    color = 'red'; radius = 12;
                } else if (item.ketinggian_air === 'sepinggang' || item.ketinggian_air === 'selutut') {
                    color = 'orange'; radius = 10;
                }

                // Buat Circle Marker
                const marker = L.circleMarker([item.latitude, item.longitude], {
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.7,
                    radius: radius
                }).addTo(map);

                // Popup Info
                marker.bindPopup(`
                    <div class="text-xs font-sans">
                        <strong class="uppercase text-${color}-600">${item.ketinggian_air.replace('_', ' ')}</strong><br>
                        <span class="text-slate-500">${item.alamat_manual}</span><br>
                        <span class="text-[10px] font-bold mt-1 inline-block px-1 rounded bg-slate-100">${item.status}</span>
                    </div>
                `);

                markers.push(marker);
            });

            // Auto Zoom agar semua marker terlihat
            if (markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        });
    </script>

</body>
</html>