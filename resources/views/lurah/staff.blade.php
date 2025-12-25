<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Staff - Ruang Lurah</title>
    
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
                    <a href="{{ route('lurah.rekap') }}" class="text-slate-500 hover:text-indigo-600 transition pb-0.5">Rekap Data</a>
                    <a href="{{ route('lurah.staff.index') }}" class="text-indigo-600 border-b-2 border-indigo-600 pb-0.5">Staff Admin</a>
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
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Staff Admin</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola akun petugas yang memiliki akses ke panel admin.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-24">
                    <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Tambah Admin Baru
                    </h3>
                    
                    <form action="{{ route('lurah.staff.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full border-slate-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Petugas Budi">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                            <input type="email" name="email" required class="w-full border-slate-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="budi@admin.com">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No. WhatsApp</label>
                            <input type="text" name="no_hp" required class="w-full border-slate-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0812xxxx">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password</label>
                            <input type="password" name="password" required class="w-full border-slate-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Minimal 8 karakter">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                            Simpan Data
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-700">Daftar Admin Aktif</h3>
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-1 rounded-full">{{ $staffs->count() }} Orang</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs">
                                <tr>
                                    <th class="px-6 py-3">Nama & Email</th>
                                    <th class="px-6 py-3">Kontak</th>
                                    <th class="px-6 py-3">Bergabung</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($staffs as $staff)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-800">{{ $staff->name }}</div>
                                            <div class="text-xs text-slate-400">{{ $staff->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $staff->no_hp ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-xs">
                                            {{ $staff->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('lurah.staff.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                            Belum ada data staff admin. Silakan tambah baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>