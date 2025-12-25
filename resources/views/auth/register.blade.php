<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Siaga Banjir</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <div class="fixed top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50 z-0 pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50 z-0 pointer-events-none"></div>

    <main class="flex-grow flex items-center justify-center p-6 relative z-10">
        
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden mt-4 mb-4">
            
            <div class="bg-white p-8 pb-4 text-center">
                <a href="/" class="inline-flex items-center gap-2 mb-4 group">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200 group-hover:scale-110 transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-900">Siaga<span class="text-blue-600">Banjir</span></span>
                </a>
                
                <h2 class="text-2xl font-bold text-slate-800">Buat Akun Baru</h2>
                <p class="text-sm text-slate-500 mt-1">Lengkapi data diri untuk mulai melapor.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="px-8 pb-8 space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 text-sm text-slate-800 bg-slate-50 placeholder-slate-400 transition"
                        placeholder="Nama Lengkap Anda">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 text-sm text-slate-800 bg-slate-50 placeholder-slate-400 transition"
                        placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div>
                    <label for="no_hp" class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp / Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <input id="no_hp" type="text" name="no_hp" :value="old('no_hp')" required
                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 pl-10 text-sm text-slate-800 bg-slate-50 placeholder-slate-400 transition"
                            placeholder="08xxxxxxxxxx">
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1 ml-1 flex items-center gap-1">
                        <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.654-.701c.969.585 1.834.885 3.104.886 3.182.001 5.769-2.587 5.769-5.767s-2.586-5.769-5.767-5.769zm3.333 7.936c-.167.465-1.025.862-1.428.877-.428.016-.906.012-2.784-.734-2.147-.852-3.523-3.134-3.629-3.275-.106-.142-.865-1.151-.865-2.195 0-1.044.536-1.558.73-1.77.17-.186.376-.231.503-.231.127 0 .254.002.38.007.135.006.316-.051.495.378.188.449.638 1.558.694 1.672.057.114.095.242.013.407-.083.166-.125.269-.247.411-.116.135-.244.301-.348.406-.115.116-.236.242-.1.474.136.233.602.99 1.29 1.602.885.787 1.631 1.031 1.861 1.144.23.113.364.094.501-.063.136-.157.585-.683.741-.917.156-.234.332-.195.559-.111.226.084 1.432.674 1.677.797.245.123.408.183.466.284.057.102.057.591-.11 1.056z"/></svg>
                        Disarankan nomor aktif WhatsApp untuk koordinasi darurat.
                    </p>
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 pl-4 pr-12 text-sm text-slate-800 bg-slate-50 placeholder-slate-400 transition"
                            placeholder="Minimal 8 karakter">
                        
                        <button type="button" onclick="togglePassword('password', 'icon-pass')" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-blue-600 focus:outline-none">
                            <svg id="icon-pass-open" class="w-5 h-5 hidden icon-pass" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg id="icon-pass-closed" class="w-5 h-5 icon-pass" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 pl-4 pr-12 text-sm text-slate-800 bg-slate-50 placeholder-slate-400 transition"
                            placeholder="Ulangi password">
                        
                        <button type="button" onclick="togglePassword('password_confirmation', 'icon-conf')" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-blue-600 focus:outline-none">
                            <svg id="icon-conf-open" class="w-5 h-5 hidden icon-conf" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg id="icon-conf-closed" class="w-5 h-5 icon-conf" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transform hover:-translate-y-0.5 transition duration-200 flex justify-center items-center gap-2">
                        Daftar Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
                
                <div class="text-center mt-6 pt-4 border-t border-slate-100">
                    <p class="text-sm text-slate-500">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-500 transition">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </main>

    <footer class="py-6 text-center relative z-10">
        <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Sistem Pelaporan Banjir Kelurahan.</p>
    </footer>

    <script>
        function togglePassword(inputId, iconClassPrefix) {
            const input = document.getElementById(inputId);
            const iconOpen = document.getElementById(iconClassPrefix + '-open');
            const iconClosed = document.getElementById(iconClassPrefix + '-closed');

            if (input.type === 'password') {
                input.type = 'text';
                iconOpen.classList.remove('hidden');
                iconClosed.classList.add('hidden');
            } else {
                input.type = 'password';
                iconOpen.classList.add('hidden');
                iconClosed.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>