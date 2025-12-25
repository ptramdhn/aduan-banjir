<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Siaga Banjir</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-center items-center relative overflow-hidden p-4">

    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50 z-0"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50 z-0"></div>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 relative z-10 overflow-hidden">
        
        <div class="bg-white p-8 pb-6 text-center">
            <a href="/" class="inline-flex items-center gap-2 mb-6 group">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200 group-hover:scale-110 transition duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">Siaga<span class="text-blue-600">Banjir</span></span>
            </a>
            
            <h2 class="text-2xl font-bold text-slate-800">Selamat Datang</h2>
            <p class="text-sm text-slate-500 mt-2">Masuk untuk melaporkan situasi banjir.</p>
        </div>

        <x-auth-session-status class="mb-4 px-8" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="px-8 pb-8 space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 text-sm text-slate-800 bg-slate-50 placeholder-slate-400 transition"
                    placeholder="nama@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="relative">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 pl-4 pr-12 text-sm text-slate-800 bg-slate-50 placeholder-slate-400 transition"
                        placeholder="••••••••">
                    
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-blue-600 focus:outline-none">
                        <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        
                        <svg id="eye-closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transform hover:-translate-y-0.5 transition duration-200 flex justify-center items-center gap-2">
                Masuk Sekarang
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
            
            <div class="text-center mt-6 pt-4 border-t border-slate-100">
                <p class="text-sm text-slate-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-500 transition">
                        Daftar Gratis
                    </a>
                </p>
            </div>
        </form>
    </div>

    <div class="absolute bottom-4 text-center w-full">
        <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Sistem Pelaporan Banjir Kelurahan.</p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>