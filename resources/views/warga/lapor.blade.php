<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - Siaga Banjir</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        #map { height: 400px; width: 100%; border-radius: 0.75rem; z-index: 0; }
        .preview-img { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 h-16 flex items-center max-w-3xl">
            <a href="{{ route('warga.dashboard') }}" class="flex items-center gap-2 text-slate-600 hover:text-blue-600 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8 max-w-3xl">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    📝 Form Laporan Banjir
                </h1>
                <p class="text-slate-500 text-sm mt-1">Isi data dengan akurat agar petugas dapat segera merespon.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-slate-700">
                            1. Titik Lokasi <span class="text-red-500">*</span>
                        </label>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 flex gap-3 text-sm text-yellow-800">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <span class="font-bold">PENTING:</span> Periksa kembali posisi pin merah di peta!
                                <ul class="list-disc ml-4 mt-1 text-xs">
                                    <li>Gunakan tombol 🔍 di peta untuk mencari nama jalan/tempat.</li>
                                    <li>Geser pin merah manual jika posisi GPS kurang pas.</li>
                                    <li>Alamat akan terisi otomatis, tapi Anda bisa mengeditnya.</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="relative group">
                            <div id="map" class="shadow-inner border border-slate-300"></div>
                            
                            <button type="button" onclick="getLocation()" class="absolute bottom-4 right-4 z-[400] bg-white p-2 rounded-lg shadow-md border border-slate-200 hover:bg-slate-50 text-blue-600" title="Gunakan Lokasi Saya Saat Ini">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" name="latitude" id="latitude" readonly placeholder="Latitude" class="bg-slate-100 border-none rounded text-xs text-slate-500 w-full">
                            <input type="text" name="longitude" id="longitude" readonly placeholder="Longitude" class="bg-slate-100 border-none rounded text-xs text-slate-500 w-full">
                        </div>
                    </div>

                    <hr class="border-slate-100">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-semibold text-slate-700">2. Alamat Detail <span class="text-red-500">*</span></label>
                                <span id="loading-address" class="text-xs text-blue-600 hidden animate-pulse">Sedang mengambil alamat...</span>
                            </div>
                            <textarea name="alamat_manual" id="alamat_manual" rows="3" required placeholder="Alamat akan muncul otomatis di sini, silakan lengkapi..."
                                    class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm bg-blue-50/30"></textarea>
                            <p class="text-[10px] text-slate-400">Anda tetap bisa mengedit alamat di atas jika kurang lengkap.</p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700">Patokan (Opsional)</label>
                            <input type="text" name="patokan" placeholder="Contoh: Depan Masjid Al-Ikhlas / Warung Madura"
                                class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2.5 text-sm">
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-slate-700">
                            3. Bukti Foto <span class="text-red-500">*</span>
                        </label>

                        <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-6 hover:border-blue-500 hover:bg-blue-50 transition-colors text-center group cursor-pointer">
                            <input type="file" name="foto_bukti[]" id="foto_input" multiple accept="image/*"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   onchange="handleFiles(this)">
                            
                            <div class="space-y-2 pointer-events-none">
                                <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto group-hover:bg-blue-100 group-hover:text-blue-500 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-sm text-slate-600 font-medium">Klik untuk tambah foto (Bisa satu per satu)</p>
                            </div>
                        </div>
                        
                        <button type="button" onclick="resetFiles()" class="text-xs text-red-500 hover:text-red-700 underline hidden" id="reset-btn">Hapus Semua Foto</button>
                        <div id="preview-container" class="grid grid-cols-3 gap-3 mt-4 empty:hidden"></div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700">4. Ketinggian Air <span class="text-red-500">*</span></label>
                            <select name="ketinggian_air" class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                <option value="semata_kaki">Semata Kaki (± 10-30cm)</option>
                                <option value="selutut">Selutut (± 30-60cm)</option>
                                <option value="sepinggang">Sepinggang (± 60-100cm)</option>
                                <option value="sedada">Sedada (± 100-140cm)</option>
                                <option value="tenggelam">Atap Rumah / Tenggelam (> 2m)</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700">5. Deskripsi Kondisi</label>
                            <textarea name="deskripsi" rows="3" placeholder="Contoh: Arus deras, ada lansia terjebak..."
                                      class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-200 transform hover:-translate-y-1 transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            KIRIM LAPORAN SEKARANG
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        // --- LOGIKA PETA + SEARCH + AUTO ADDRESS ---
        var map = L.map('map').setView([-6.1751, 106.8650], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);

        var marker;

        // 1. Tambahkan Kontrol Pencarian (Search Box)
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(e) {
            var bbox = e.geocode.bbox;
            var poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]); // Zoom ke area hasil pencarian
            map.fitBounds(poly.getBounds());
            
            // Set marker di hasil pencarian
            setLocation(e.geocode.center.lat, e.geocode.center.lng);
        })
        .addTo(map);

        function updateInput(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Fungsi Reverse Geocoding (Koordinat -> Alamat Tulisan)
        async function getAddressFromCoords(lat, lng) {
            const loadingText = document.getElementById('loading-address');
            const alamatInput = document.getElementById('alamat_manual');
            
            loadingText.classList.remove('hidden');
            
            try {
                // Panggil API Nominatim (Gratis dari OpenStreetMap)
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
                const data = await response.json();
                
                if(data.display_name) {
                    alamatInput.value = data.display_name;
                }
            } catch (error) {
                console.error("Gagal mengambil alamat:", error);
                // Jangan hapus inputan user kalau gagal, biarkan saja
            } finally {
                loadingText.classList.add('hidden');
            }
        }

        function setLocation(lat, lng) {
            // Pindahkan Peta
            map.setView([lat, lng], 17);
            
            // Pindahkan / Buat Marker
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng], {draggable: true}).addTo(map);
            
            // Update Input
            updateInput(lat, lng);
            
            // Ambil Alamat Otomatis
            getAddressFromCoords(lat, lng);

            // Listener kalau marker digeser manual lagi
            marker.on('dragend', function (e) {
                var coord = e.target.getLatLng();
                updateInput(coord.lat, coord.lng);
                getAddressFromCoords(coord.lat, coord.lng);
            });
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) { setLocation(position.coords.latitude, position.coords.longitude); },
                    function (error) { alert("Gagal mengambil lokasi GPS."); }
                );
            } else { alert("Browser tidak mendukung GPS."); }
        }
        
        // Inisialisasi awal
        getLocation();
        
        // Klik peta untuk pindah pin
        map.on('click', function(e) { 
            setLocation(e.latlng.lat, e.latlng.lng); 
        });


        // --- LOGIKA UPLOAD FOTO (FIX TUMPUK) ---
        const dt = new DataTransfer(); 

        function handleFiles(input) {
            const preview = document.getElementById('preview-container');
            const resetBtn = document.getElementById('reset-btn');

            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                let isDuplicate = false;
                for (let j = 0; j < dt.items.length; j++) {
                    if (dt.items[j].getAsFile().name === file.name && dt.items[j].getAsFile().size === file.size) {
                        isDuplicate = true; break;
                    }
                }
                if (!isDuplicate) dt.items.add(file);
            }

            if (dt.items.length > 3) {
                alert("Maksimal 3 foto!");
                while (dt.items.length > 3) dt.items.remove(3); 
            }

            input.files = dt.files;
            preview.innerHTML = '';
            
            if (dt.files.length > 0) {
                resetBtn.classList.remove('hidden');
                for (let i = 0; i < dt.files.length; i++) {
                    const file = dt.files[i];
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = document.createElement("div");
                        div.className = "relative aspect-square rounded-lg overflow-hidden border border-slate-200 preview-img group";
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.className = "w-full h-full object-cover";
                        const badge = document.createElement("span");
                        badge.className = "absolute top-1 left-1 bg-black/50 text-white text-[10px] px-1.5 rounded";
                        badge.innerText = "#" + (i + 1);
                        div.appendChild(img);
                        div.appendChild(badge);
                        preview.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }
            }
        }

        function resetFiles() {
            const input = document.getElementById('foto_input');
            const preview = document.getElementById('preview-container');
            const resetBtn = document.getElementById('reset-btn');
            dt.items.clear();
            input.files = dt.files;
            preview.innerHTML = '';
            resetBtn.classList.add('hidden');
        }
    </script>
</body>
</html>