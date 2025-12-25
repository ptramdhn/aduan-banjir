<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #{{ $laporan->id }} - Siaga Banjir</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style> body { font-family: 'Inter', sans-serif; } #map { height: 350px; width: 100%; border-radius: 0.75rem; z-index: 0; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 px-4 h-16 flex items-center justify-between shadow-sm">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-slate-600 hover:text-blue-600 font-bold transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
        <div class="flex items-center gap-2">
            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Tiket Laporan</span>
            <span class="bg-slate-100 text-slate-800 px-3 py-1 rounded-full font-bold text-sm">#{{ $laporan->id }}</span>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2 pb-3 border-b border-slate-100">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Data Pelapor
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Nama Lengkap</p>
                            <p class="font-bold text-slate-800 text-base">{{ $laporan->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Kontak (WhatsApp)</p>
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-slate-800 text-base">{{ $laporan->user->no_hp ?? '-' }}</p>
                                
                                @if($laporan->user->no_hp)
                                    {{-- LOGIKA FORMAT NOMOR HP KE WA --}}
                                    @php
                                        $nohp = $laporan->user->no_hp;
                                        // 1. Hapus karakter selain angka (spasi, strip, plus, dll)
                                        $nohp = preg_replace('/[^0-9]/', '', $nohp);

                                        // 2. Cek awalan nomor
                                        if(substr($nohp, 0, 1) == '0'){
                                            // Ubah 08... jadi 628...
                                            $nohp = '62'.substr($nohp, 1);
                                        }
                                        elseif(substr($nohp, 0, 2) == '62'){
                                            // Sudah format 62, biarkan
                                            $nohp = $nohp;
                                        }
                                        else {
                                            // Asumsi input 8... langsung tambah 62 di depan
                                            $nohp = '62'.$nohp;
                                        }
                                    @endphp

                                    <a href="https://wa.me/{{ $nohp }}" target="_blank" class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-bold hover:bg-green-200 transition flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        Chat WA
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Email</p>
                            <p class="font-medium text-slate-800">{{ $laporan->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Waktu Lapor</p>
                            <p class="font-medium text-slate-800">{{ $laporan->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2 pb-3 border-b border-slate-100">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Lokasi & Detail
                    </h2>

                    <div class="mb-6 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div class="mb-3">
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Alamat Lengkap</p>
                            <p class="text-slate-800 font-medium leading-relaxed">{{ $laporan->alamat_manual ?? 'Alamat tidak diisi oleh pelapor.' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Patokan / Landmark</p>
                            <p class="text-slate-800 font-medium">{{ $laporan->patokan ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Perhatian:</strong> Titik peta di bawah ini otomatis dari GPS HP warga. Bisa jadi kurang akurat (radius 10-50m). <br>
                                    Selalu prioritaskan <strong>Alamat Lengkap</strong> di atas atau hubungi pelapor via WhatsApp untuk konfirmasi lokasi pasti.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div id="map" class="mb-6 bg-slate-100 border border-slate-200"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Ketinggian Air</p>
                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold border border-blue-200">
                                {{ ucfirst(str_replace('_', ' ', $laporan->ketinggian_air)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Deskripsi Kejadian</p>
                            <p class="text-slate-700 italic">"{{ $laporan->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}"</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-2">Bukti Foto Lapangan</p>
                        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                            @php 
                                $fotos = is_array($laporan->foto_bukti) ? $laporan->foto_bukti : [$laporan->foto_bukti];
                            @endphp
                            @foreach($fotos as $foto)
                                <a href="{{ asset('storage/'.$foto) }}" target="_blank" class="group relative">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition rounded-lg"></div>
                                    <img src="{{ asset('storage/'.$foto) }}" class="h-32 w-32 object-cover rounded-lg border border-slate-200 shadow-sm">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat Penanganan
                    </h2>
                    
                    <div class="relative border-l-2 border-slate-200 ml-3 space-y-8">
                        @foreach($laporan->logs as $log)
                            <div class="relative pl-8">
                                <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full border-2 border-white 
                                    {{ $log->status == 'selesai' ? 'bg-green-500' : ($log->status == 'proses' ? 'bg-blue-500' : ($log->status == 'tolak' ? 'bg-red-500' : 'bg-yellow-400')) }}">
                                </div>
                                
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <div>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded border 
                                            {{ $log->status == 'selesai' ? 'bg-green-100 text-green-700 border-green-200' : ($log->status == 'proses' ? 'bg-blue-100 text-blue-700 border-blue-200' : ($log->status == 'tolak' ? 'bg-red-100 text-red-700 border-red-200' : 'bg-yellow-100 text-yellow-700 border-yellow-200')) }}">
                                            {{ $log->status }}
                                        </span>
                                        <p class="mt-2 text-slate-800 text-sm font-medium">{{ $log->keterangan }}</p>
                                        <p class="text-xs text-slate-400 mt-1">Oleh: {{ $log->admin->name ?? 'Admin' }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400 mt-2 sm:mt-0 font-mono">{{ $log->created_at->format('d/m H:i') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100 sticky top-24">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Update Status
                    </h2>
                    
                    <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Pilih Status Baru</label>
                            <select name="status" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5">
                                <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>⏳ Pending (Menunggu)</option>
                                <option value="proses" {{ $laporan->status == 'proses' ? 'selected' : '' }}>🚀 Proses (Sedang Ditangani)</option>
                                <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>✅ Selesai (Kasus Tutup)</option>
                                <option value="tolak" {{ $laporan->status == 'tolak' ? 'selected' : '' }}>❌ Tolak (Laporan Palsu)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Catatan Petugas</label>
                            <textarea name="keterangan" rows="4" required 
                                placeholder="Jelaskan tindakan yang diambil..."
                                class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            <p class="text-xs text-slate-400 mt-2">*Wajib diisi sebagai log penanganan.</p>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-slate-200 transition transform hover:-translate-y-1 flex justify-center items-center gap-2">
                            <span>Kirim Update</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map', { scrollWheelZoom: false }).setView([{{ $laporan->latitude }}, {{ $laporan->longitude }}], 16);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var redIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        L.marker([{{ $laporan->latitude }}, {{ $laporan->longitude }}], {icon: redIcon}).addTo(map)
         .bindPopup("<b>Titik Laporan</b><br>Radius akurasi GPS HP pelapor.").openPopup();
    </script>
</body>
</html>