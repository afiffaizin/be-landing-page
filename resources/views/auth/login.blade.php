<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-screen bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Eco-Enzyme Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8 antialiased text-slate-800 relative bg-slate-50">
    <!-- Subtle Background Ambient Accents -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-200/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-200/50 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-200 h-200 bg-emerald-50/60 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative z-10 my-auto py-4">
        <!-- Logo & Header -->
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-block p-1.5 rounded-2xl bg-white shadow-sm border border-gray-100 mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Eco-Enzyme Logo" class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl object-cover">
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Eco-Enzyme</h1>
            <p class="mt-1.5 text-xs sm:text-sm text-slate-500 font-medium">Portal Manajemen Admin</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl shadow-slate-200/50 border border-white p-6 sm:p-8 md:p-10">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm font-medium flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-800 text-sm font-medium flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6" autocomplete="off">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5">
                        Alamat Email
                    </label>
                    <div class="relative group">
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="off"
                               placeholder="admin@pengabdian.id"
                               class="w-full px-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 focus:bg-white transition-all">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative group">
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="••••••••"
                               class="w-full px-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 focus:bg-white transition-all">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" name="remember" class="peer sr-only">
                            <div class="w-5 h-5 border-2 border-slate-300 rounded peer-checked:bg-emerald-600 peer-checked:border-emerald-600 transition-all"></div>
                            <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-600 group-hover:text-slate-800 transition-colors">Ingat saya</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-4 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transition-all flex items-center justify-center gap-2 cursor-pointer transform hover:-translate-y-0.5">
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </form>
        </div>

        <p class="text-center text-xs font-medium text-slate-400 mt-8">
            &copy; {{ date('Y') }} Platform Pengabdian Dosen.<br>All rights reserved.
        </p>
    </div>
</body>
</html>
