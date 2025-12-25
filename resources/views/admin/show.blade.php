<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #{{ $laporan->id }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; } #map { height: 300px; width: 100%; border-radius: 0.75rem; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 px-4 h-16 flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-slate-600 hover:text-blue-600 font-bold">
            &larr; Kembali ke Dashboard
        </a>
        <div class="font-bold text-slate-800">Tiket Laporan #{{ $laporan->id }}</div>
    </nav>

    <main class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        👤 Data Pelapor
                    </h2>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-slate-500">Nama Lengkap</p>
                            <p class="font-bold text-slate-800">{{ $laporan->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Nomor Telepon/WA</p>
                            <p class="font-bold text-slate-800 flex items-center gap-2">
                                {{ $laporan->user->no_hp ?? '-' }}
                                @if($laporan->user->no_hp)
                                    <a href="https://wa.me/{{ $laporan->user->no_hp }}" target="_blank" class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs hover:bg-green-200">Chat WA</a>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-500">Email</p>
                            <p class="font-medium text-slate-800">{{ $laporan->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Waktu Lapor</p>
                            <p class="font-medium text-slate-800">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">📍 Detail Kejadian</h2>
                    
                    <div id="map" class="mb-4 bg-slate-100 z-0"></div>

                    <div class="mb-4">
                        <p class="text-slate-500 text-sm mb-1">Ketinggian Air</p>
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">
                            {{ ucfirst(str_replace('_', ' ', $laporan->ketinggian_air)) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-slate-500 text-sm mb-1">Deskripsi Warga</p>
                        <div class="bg-slate-50 p-4 rounded-xl text-slate-700 border border-slate-100 italic">
                            "{{ $laporan->deskripsi ?? 'Tidak ada deskripsi.' }}"
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-slate-500 text-sm mb-2">Bukti Foto</p>
                        <div class="flex gap-2 overflow-x-auto pb-2">
                            @php 
                                $fotos = is_array($laporan->foto_bukti) ? $laporan->foto_bukti : [$laporan->foto_bukti];
                            @endphp
                            @foreach($fotos as $foto)
                                <a href="{{ asset('storage/'.$foto) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$foto) }}" class="h-24 w-24 object-cover rounded-lg border border-slate-200 hover:opacity-75 transition">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 mb-6">🕒 Riwayat Penanganan</h2>
                    
                    <div class="relative border-l-2 border-slate-200 ml-3 space-y-8">
                        @foreach($laporan->logs as $log)
                            <div class="relative pl-8">
                                <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full border-2 border-white 
                                    {{ $log->status == 'selesai' ? 'bg-green-500' : ($log->status == 'proses' ? 'bg-blue-500' : ($log->status == 'tolak' ? 'bg-red-500' : 'bg-yellow-400')) }}">
                                </div>
                                
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                    <div>
                                        <span class="text-xs font-bold uppercase px-2 py-0.5 rounded 
                                            {{ $log->status == 'selesai' ? 'bg-green-100 text-green-700' : ($log->status == 'proses' ? 'bg-blue-100 text-blue-700' : ($log->status == 'tolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                            {{ $log->status }}
                                        </span>
                                        <p class="mt-1 text-slate-800 font-medium">{{ $log->keterangan }}</p>
                                        <p class="text-xs text-slate-400 mt-1">Oleh: {{ $log->admin->name ?? 'Admin' }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400 mt-1 sm:mt-0">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100 sticky top-24">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">⚡ Update Status</h2>
                    
                    <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Status Baru</label>
                            <select name="status" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="proses" {{ $laporan->status == 'proses' ? 'selected' : '' }}>🚀 Proses (Sedang Ditangani)</option>
                                <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>✅ Selesai (Kasus Tutup)</option>
                                <option value="tolak" {{ $laporan->status == 'tolak' ? 'selected' : '' }}>❌ Tolak (Laporan Palsu)</option>
                                <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>⏳ Pending (Menunggu)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Catatan / Keterangan Update</label>
                            <textarea name="keterangan" rows="4" required 
                                placeholder="Contoh: Tim sedang bergerak ke lokasi membawa perahu karet..."
                                class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            <p class="text-xs text-slate-500 mt-1">*Wajib diisi agar warga tau progresnya.</p>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-200 transition transform hover:-translate-y-1">
                            Kirim Update Status 📤
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi Peta Mini (Read Only)
        var map = L.map('map', { scrollWheelZoom: false }).setView([{{ $laporan->latitude }}, {{ $laporan->longitude }}], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([{{ $laporan->latitude }}, {{ $laporan->longitude }}]).addTo(map)
         .bindPopup("Lokasi Kejadian").openPopup();
    </script>
</body>
</html>