<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siaga Banjir - Pelaporan Cepat & Akurat</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Animasi smooth untuk FAQ */
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
        details[open] summary ~ * { animation: sweep .3s ease-in-out; }
        @keyframes sweep { 
            0%    { opacity: 0; transform: translateY(-10px); }
            100%  { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased">

    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="container mx-auto px-4 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">Siaga<span class="text-blue-600">Banjir</span></span>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="#tutorial" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Cara Lapor</a>
                @if(isset($reviews) && $reviews->count() > 0)
                    <a href="#reviews" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Kata Warga</a>
                @endif
                <a href="#faq" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">FAQ</a>
                
                @if (Route::has('login'))
                    <div class="flex items-center gap-3 ml-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">
                                Ke Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 px-5 rounded-full shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 bg-slate-50 overflow-hidden relative">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>

        <div class="container mx-auto px-4 relative z-10 text-center max-w-4xl">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-100 text-blue-700 text-xs font-bold tracking-wide mb-6">
                🚀 SISTEM PELAPORAN TERINTEGRASI
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-slate-900 leading-tight mb-6">
                Bantu Lingkunganmu,<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Lapor Banjir Cepat & Tepat.</span>
            </h1>
            <p class="text-lg text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform resmi kelurahan untuk memantau dan menindaklanjuti laporan banjir secara real-time. Laporkan genangan air di sekitarmu agar bantuan segera datang.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('warga.dashboard') }}" class="bg-blue-600 text-white text-lg font-bold py-4 px-8 rounded-full shadow-xl hover:shadow-2xl hover:bg-blue-700 transition transform hover:-translate-y-1">
                        Buat Laporan Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white text-lg font-bold py-4 px-8 rounded-full shadow-xl hover:shadow-2xl hover:bg-blue-700 transition transform hover:-translate-y-1">
                        Daftar Akun Warga
                    </a>
                    <a href="{{ route('login') }}" class="bg-white text-slate-700 border border-slate-200 text-lg font-bold py-4 px-8 rounded-full hover:bg-slate-50 transition">
                        Masuk Akun
                    </a>
                @endauth
            </div>

            <div class="mt-12 flex justify-center gap-8 text-slate-500 text-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Gratis 100%</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Respon Cepat</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Lokasi Akurat</span>
                </div>
            </div>
        </div>
    </section>

    <section id="tutorial" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Cara Melapor</h2>
                <p class="text-slate-600">Ikuti 4 langkah mudah ini untuk berkontribusi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 transition text-center group">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold group-hover:scale-110 transition">1</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Daftar Akun</h3>
                    <p class="text-sm text-slate-500">Buat akun menggunakan email aktif untuk dapat mengakses fitur pelaporan.</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 transition text-center group">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold group-hover:scale-110 transition">2</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Buka Dashboard</h3>
                    <p class="text-sm text-slate-500">Login dan klik tombol "Lapor Sekarang" yang tersedia di halaman utama.</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 transition text-center group">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold group-hover:scale-110 transition">3</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Isi Data & Lokasi</h3>
                    <p class="text-sm text-slate-500">Tentukan titik lokasi di peta, upload bukti foto, dan jelaskan kondisi banjir.</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 transition text-center group">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold group-hover:scale-110 transition">4</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Tunggu Verifikasi</h3>
                    <p class="text-sm text-slate-500">Admin akan memverifikasi laporanmu dan petugas akan segera meluncur.</p>
                </div>
            </div>
        </div>
    </section>

    @if(isset($reviews) && $reviews->count() > 0)
    <section id="reviews" class="py-20 bg-blue-50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-32 h-32 bg-blue-100 rounded-br-full opacity-50"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 bg-blue-100 rounded-tl-full opacity-50"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold text-xs tracking-wider uppercase mb-2 block">Suara Warga</span>
                <h2 class="text-3xl font-bold text-slate-900">Apa Kata Mereka?</h2>
                <p class="text-slate-600 mt-2">Ulasan asli dari warga yang telah terbantu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($reviews as $review)
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 relative group hover:-translate-y-2 transition duration-300">
                        <div class="absolute top-4 right-6 text-6xl text-blue-50 font-serif leading-none select-none group-hover:text-blue-100 transition">
                            &rdquo;
                        </div>

                        <div class="flex gap-1 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400 fill-yellow-400' : 'text-slate-200' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                </svg>
                            @endfor
                        </div>

                        <p class="text-slate-600 mb-6 leading-relaxed relative z-10">
                            "{{ $review->komentar }}"
                        </p>

                        <div class="flex items-center gap-4 border-t border-slate-50 pt-4">
                            @php
                                $colors = ['bg-red-100 text-red-600', 'bg-green-100 text-green-600', 'bg-blue-100 text-blue-600', 'bg-purple-100 text-purple-600', 'bg-orange-100 text-orange-600'];
                                $randomColor = $colors[$loop->index % count($colors)];
                            @endphp
                            <div class="w-10 h-10 {{ $randomColor }} rounded-full flex items-center justify-center font-bold text-sm">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">{{ $review->user->name }}</h4>
                                <p class="text-xs text-slate-400">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section id="faq" class="py-20 bg-slate-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Pertanyaan Umum (FAQ)</h2>
                <p class="text-slate-600">Hal-hal yang sering ditanyakan warga.</p>
            </div>

            <div class="space-y-4">
                <details class="group bg-white rounded-xl border border-slate-200 overflow-hidden transition-all duration-300 open:shadow-md">
                    <summary class="flex justify-between items-center p-5 cursor-pointer font-bold text-slate-700 hover:text-blue-600">
                        Apakah layanan ini berbayar?
                        <span class="transform transition-transform duration-200 group-open:rotate-180">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <div class="p-5 pt-0 text-slate-600 text-sm leading-relaxed border-t border-transparent group-open:border-slate-100">
                        Tidak. Layanan SiagaBanjir sepenuhnya <strong>gratis</strong> untuk seluruh warga kelurahan.
                    </div>
                </details>

                <details class="group bg-white rounded-xl border border-slate-200 overflow-hidden transition-all duration-300 open:shadow-md">
                    <summary class="flex justify-between items-center p-5 cursor-pointer font-bold text-slate-700 hover:text-blue-600">
                        Berapa lama laporan saya akan direspon?
                        <span class="transform transition-transform duration-200 group-open:rotate-180">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <div class="p-5 pt-0 text-slate-600 text-sm leading-relaxed border-t border-transparent group-open:border-slate-100">
                        Admin kami memantau sistem 24/7. Verifikasi biasanya dalam 10-30 menit.
                    </div>
                </details>

                <details class="group bg-white rounded-xl border border-slate-200 overflow-hidden transition-all duration-300 open:shadow-md">
                    <summary class="flex justify-between items-center p-5 cursor-pointer font-bold text-slate-700 hover:text-blue-600">
                        Apakah wajib punya akun?
                        <span class="transform transition-transform duration-200 group-open:rotate-180">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <div class="p-5 pt-0 text-slate-600 text-sm leading-relaxed border-t border-transparent group-open:border-slate-100">
                        Ya, demi validitas data, pelapor wajib mendaftar akun terlebih dahulu.
                    </div>
                </details>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-300 py-12">
        <div class="container mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-2 mb-6">
                 <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xl font-bold text-white">SiagaBanjir</span>
            </div>
            <p class="text-sm mb-6">&copy; {{ date('Y') }} Sistem Pelaporan Banjir Kelurahan. Dilindungi Hak Cipta.</p>
            <div class="flex justify-center gap-6 text-sm font-medium">
                <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white transition">Hubungi Kami</a>
            </div>
        </div>
    </footer>

</body>
</html>