<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
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
<body class="h-full flex items-center justify-center p-4 antialiased bg-gray-50 text-slate-800 relative overflow-hidden">
    <!-- Subtle Background Ambient Accents -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-100/60 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-100/50 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-50/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 items-center justify-center text-white shadow-md shadow-emerald-500/25 mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19.5c-4.478 0-8-3.582-8-7.5 0-3.918 3.522-7.5 8-7.5s8 3.582 8 7.5c0 1.5-.5 2.9-1.4 4.1L20 21l-3.5-1.2c-1.3.5-2.8.7-4.5.7zM9 10c0 1.657 1.343 3 3 3s3-1.343 3-3"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 14.5c1.5 2 3.5 3 5 3s3.5-1 5-3"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Eco-Enzyme Admin Portal</h1>
            <div class="flex items-center justify-center gap-2 mt-1.5">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">CMS Studio v2.4</span>
                <span class="text-slate-300">•</span>
                <span class="text-xs font-medium text-slate-500">Pengabdian Dosen</span>
            </div>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-8 sm:p-9">
            @if(session('success'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email', 'admin@admin.com') }}"
                               required
                               autofocus
                               placeholder="admin@pengabdian.id"
                               class="w-full px-4 py-3 bg-gray-50/70 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               placeholder="••••••••"
                               value="password"
                               class="w-full px-4 py-3 bg-gray-50/70 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500/20 focus:ring-2">
                        <span class="text-xs font-medium text-slate-600">Ingat saya</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 active:from-emerald-800 active:to-emerald-900 text-white font-semibold text-sm rounded-xl shadow-sm shadow-emerald-500/25 hover:shadow-md hover:shadow-emerald-500/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} Platform Pengabdian Dosen. All rights reserved.
        </p>
    </div>
</body>
</html>
