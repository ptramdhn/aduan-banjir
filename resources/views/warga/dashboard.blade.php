<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga - Siaga Banjir</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 h-16 flex justify-between items-center max-w-2xl">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="font-bold text-lg tracking-tight text-slate-900">Siaga<span class="text-blue-600">Banjir</span></span>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="hidden md:flex flex-col text-right">
                    <span class="text-xs text-slate-500 font-medium">Halo, Warga</span>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-bold text-slate-800 leading-none hover:text-blue-600 transition cursor-pointer" title="Edit Profil">
                        {{ Auth::user()->name }}
                    </a>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 rounded-full hover:bg-slate-100 text-slate-500 hover:text-red-600 transition" title="Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-6 max-w-2xl">
        
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl p-6 text-white shadow-xl shadow-blue-200 mb-8 relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl group-hover:scale-150 transition duration-700"></div>
            
            <div class="relative z-10">
                <h2 class="text-2xl font-bold mb-1">Butuh Bantuan Darurat?</h2>
                <p class="text-blue-100 text-sm mb-6 max-w-xs">Laporkan banjir di sekitarmu agar petugas segera meluncur ke lokasi.</p>
                
                <a href="{{ route('lapor.create') }}" class="inline-flex items-center gap-2 bg-white text-blue-700 font-bold py-3 px-6 rounded-full shadow-lg hover:shadow-xl hover:bg-slate-50 transform hover:-translate-y-1 transition duration-200 w-full md:w-auto justify-center">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                    BUAT LAPORAN SEKARANG
                </a>
            </div>
        </div>
        
        <div class="flex items-center justify-between mb-4 px-1">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Riwayat Laporan
            </h3>
            <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-md">{{ $laporans->count() }} Laporan</span>
        </div>
        
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3 shadow-sm animate-fade-in-down">
                <div class="flex-shrink-0 text-green-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-green-800">Berhasil!</h4>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3 shadow-sm animate-fade-in-down">
                <div class="flex-shrink-0 text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-red-800">Ups!</h4>
                    <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

        <div class="space-y-4 pb-12">
            @forelse($laporans as $laporan)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition duration-200 group">
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-24 h-24 md:w-28 md:h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-100 relative">
                                @php
                                    $thumbnail = is_array($laporan->foto_bukti) ? ($laporan->foto_bukti[0] ?? null) : $laporan->foto_bukti;
                                @endphp
                                <img src="{{ asset('storage/' . $thumbnail) }}" alt="Bukti" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 flex flex-col justify-between py-0.5">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                        {{ $laporan->created_at->diffForHumans() }}
                                    </p>
                                    
                                    <span @class([
                                        'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border',
                                        'bg-yellow-50 text-yellow-700 border-yellow-200' => $laporan->status == 'pending',
                                        'bg-blue-50 text-blue-700 border-blue-200'       => $laporan->status == 'proses',
                                        'bg-green-50 text-green-700 border-green-200'    => $laporan->status == 'selesai',
                                        'bg-red-50 text-red-700 border-red-200'          => $laporan->status == 'tolak',
                                    ])>
                                        {{ $laporan->status }}
                                    </span>
                                </div>

                                <h4 class="text-base font-bold text-slate-800 truncate leading-tight mb-1">
                                    {{ ucfirst(str_replace('_', ' ', $laporan->ketinggian_air)) }}
                                </h4>
                                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $laporan->deskripsi ?? 'Tidak ada keterangan tambahan.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($laporan->logs->count() > 0)
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-3 tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Progres Penanganan:
                            </p>
                            
                            <div class="space-y-3 pl-1">
                                @foreach($laporan->logs as $log)
                                    <div class="flex gap-3 relative">
                                        @if(!$loop->last)
                                            <div class="absolute left-[3.5px] top-2 bottom-[-12px] w-px bg-slate-200"></div>
                                        @endif

                                        <div class="mt-1.5 flex-shrink-0 z-10">
                                            @if($log->status == 'selesai')
                                                <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_0_3px_rgba(34,197,94,0.15)]"></div>
                                            @elseif($log->status == 'proses')
                                                <div class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_0_3px_rgba(59,130,246,0.15)]"></div>
                                            @elseif($log->status == 'tolak')
                                                <div class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_0_3px_rgba(239,68,68,0.15)]"></div>
                                            @else
                                                <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-slate-800 leading-snug">
                                                {{ $log->keterangan }}
                                            </p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">
                                                {{ $log->created_at->format('d M, H:i') }} • Oleh Petugas
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif($laporan->status !== 'pending')
                         <div class="mt-3 pt-3 border-t border-slate-100">
                             <p class="text-xs text-slate-500 italic">Status telah diperbarui menjadi {{ $laporan->status }}, menunggu catatan petugas.</p>
                         </div>
                    @endif

                    @if($laporan->status == 'selesai')
                        <div class="mt-5 pt-5 border-t-2 border-dashed border-slate-100">
                            
                            @if($laporan->review)
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Ulasan Anda:</p>
                                    <div class="flex items-center gap-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $laporan->review->rating ? 'text-yellow-400 fill-yellow-400' : 'text-slate-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                            </svg>
                                        @endfor
                                        <span class="text-sm font-bold text-slate-700 ml-2">
                                            {{ $laporan->review->rating }}.0
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-600 italic">"{{ $laporan->review->komentar ?? 'Tidak ada komentar.' }}"</p>
                                </div>

                            @else
                                <div x-data="{ rating: 0 }" class="bg-blue-50 rounded-xl p-5 border border-blue-100 text-center">
                                    <h4 class="text-sm font-bold text-blue-800 mb-1">Bagaimana kinerja tim kami?</h4>
                                    <p class="text-xs text-blue-600 mb-4">Beri rating agar kami bisa melayani lebih baik.</p>

                                    <form action="{{ route('review.store', $laporan->id) }}" method="POST">
                                        @csrf
                                        
                                        <div class="flex justify-center flex-row-reverse gap-2 mb-4 group">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" name="rating" id="star{{$i}}_{{$laporan->id}}" value="{{$i}}" class="hidden peer" required>
                                                <label for="star{{$i}}_{{$laporan->id}}" class="cursor-pointer text-slate-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition transform hover:scale-110">
                                                    <svg class="w-8 h-8 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>

                                        <textarea name="komentar" rows="2" placeholder="Tulis pengalamanmu (opsional)..." class="w-full text-sm border-blue-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 mb-3 placeholder-blue-300"></textarea>

                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg text-sm shadow-md transition">
                                            Kirim Ulasan ⭐
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-slate-200">
                    <div class="mx-auto w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-slate-900 font-medium">Belum ada laporan</h3>
                    <p class="text-slate-500 text-sm mt-1">Laporan banjir kamu akan muncul di sini.</p>
                </div>
            @endforelse
        </div>
        
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Sistem Pelaporan Banjir Kelurahan.</p>
        </div>
    </footer>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>