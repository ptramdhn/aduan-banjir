<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Siaga Banjir</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 h-16 flex items-center max-w-2xl">
            @php
                // Logika Penentuan Route Dashboard Berdasarkan Role
                $dashboardRoute = match(Auth::user()->role) {
                    'admin' => route('admin.dashboard'),
                    'lurah' => route('lurah.dashboard'), // Tambahan untuk Lurah
                    default => route('warga.dashboard'), // Default untuk warga
                };
            @endphp
            
            <a href="{{ $dashboardRoute }}" class="flex items-center gap-2 text-slate-600 hover:text-blue-600 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8 max-w-2xl space-y-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-6 py-6 border-b border-slate-100 flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-blue-200">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800">{{ $user->name }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border bg-slate-200 text-slate-600 border-slate-300">
                            {{ $user->role }}
                        </span>
                        <span class="text-sm text-slate-500">{{ $user->email }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required
                               class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                        @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-500 mb-2">Email Address <span class="text-xs font-normal">(Tidak dapat diubah)</span></label>
                        <input type="email" value="{{ $user->email }}" disabled
                               class="w-full border-slate-200 bg-slate-100 text-slate-500 rounded-xl py-3 cursor-not-allowed select-none">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-200 transform hover:-translate-y-0.5 transition duration-200">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Ubah Password
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Pastikan menggunakan password yang aman.</p>
            </div>

            <div class="p-6">
                @if (session('status') === 'password-updated')
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Password berhasil diubah!
                    </div>
                @endif

                <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    @method('put')

                    <div class="relative">
                        <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-2">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" required class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                        @error('current_password', 'updatePassword')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                        <input id="password" name="password" type="password" required class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                        @error('password', 'updatePassword')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Ulangi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full border-slate-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                        @error('password_confirmation', 'updatePassword')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-slate-200 transform hover:-translate-y-0.5 transition duration-200">
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </main>

</body>
</html>