<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Portal') - Eco-Enzyme Admin</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Quill.js WYSIWYG Editor CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #a7f3d0;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6ee7b7;
        }
        /* Sidebar scrollbar */
        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.15);
        }
        /* Quill custom styling */
        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            border-color: #e2e8f0;
            background-color: #f8fafc;
        }
        .ql-container.ql-snow {
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            border-color: #e2e8f0;
            font-family: inherit;
            font-size: 0.95rem;
        }
        .ql-editor {
            min-height: 140px;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full antialiased text-slate-800 bg-gray-50 flex flex-col md:flex-row">

    <!-- Mobile Header / Nav Toggle -->
    <div class="md:hidden flex items-center justify-between bg-emerald-900 px-4 py-3 sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center text-white font-bold shadow-sm shadow-emerald-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19.5c-4.478 0-8-3.582-8-7.5 0-3.918 3.522-7.5 8-7.5s8 3.582 8 7.5c0 1.5-.5 2.9-1.4 4.1L20 21l-3.5-1.2c-1.3.5-2.8.7-4.5.7zM9 10c0 1.657 1.343 3 3 3s3-1.343 3-3"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 14.5c1.5 2 3.5 3 5 3s3.5-1 5-3"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-sm font-bold text-white leading-tight">Eco-Enzyme Admin</h1>
                <p class="text-[11px] text-emerald-300 font-medium">Pengabdian Dosen</p>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="p-2 rounded-lg text-emerald-300 hover:bg-emerald-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-emerald-900 via-emerald-900 to-emerald-950 flex flex-col transition-transform duration-200 ease-in-out -translate-x-full md:translate-x-0 md:static md:h-screen md:shrink-0">
        <!-- Brand Header -->
        <div class="p-5 border-b border-emerald-700/50 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-md shadow-emerald-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19.5c-4.478 0-8-3.582-8-7.5 0-3.918 3.522-7.5 8-7.5s8 3.582 8 7.5c0 1.5-.5 2.9-1.4 4.1L20 21l-3.5-1.2c-1.3.5-2.8.7-4.5.7zM9 10c0 1.657 1.343 3 3 3s3-1.343 3-3"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 14.5c1.5 2 3.5 3 5 3s3.5-1 5-3"></path>
                </svg>
            </div>
            <div>
                <span class="text-base font-bold text-white tracking-tight block">Eco-Enzyme</span>
                <span class="text-[11px] font-medium text-emerald-300 bg-emerald-800/60 border border-emerald-600/40 px-2 py-0.5 rounded-md inline-block mt-0.5">Admin Portal</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto px-3.5 py-5 space-y-6">
            <!-- Main Navigation -->
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Group: Landing Page -->
            <div>
                <p class="px-3 text-[11px] font-bold text-emerald-400 uppercase tracking-wider mb-2">
                    Landing Page
                </p>
                <div class="space-y-1">
                    <a href="{{ route('admin.home-sections.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.home-sections.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.home-sections.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                            </svg>
                            <span>Home Section</span>
                        </div>
                        @if(request()->routeIs('admin.home-sections.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.about-sections.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.about-sections.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.about-sections.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>About Section</span>
                        </div>
                        @if(request()->routeIs('admin.about-sections.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>
                </div>
            </div>
        </nav>

        <!-- User Profile & Logout Bottom Card -->
        <div class="p-4 border-t border-emerald-700/50 bg-emerald-950/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-700 text-emerald-200 font-bold flex items-center justify-center text-xs border border-emerald-600/50">
                        {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 2)) }}
                    </div>
                    <div class="truncate max-w-[110px]">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin Kreatif' }}</p>
                        <p class="text-xs text-emerald-400 truncate">{{ Auth::user()->email ?? 'admin@pengabdian.id' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar" class="p-2 text-emerald-400 hover:text-rose-400 hover:bg-emerald-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 md:h-screen md:overflow-y-auto">
        <!-- Top App Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30 px-4 sm:px-6 py-3.5 sm:py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-1.5 text-xs font-medium text-slate-400 mb-1">
                    @yield('breadcrumbs')
                </nav>
                <!-- Page Title -->
                <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">
                    @yield('page_title', 'Dashboard')
                </h1>
            </div>

            <!-- Top Action Buttons Slot -->
            <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto justify-between sm:justify-end">
                @yield('header_actions')
            </div>
        </header>

        <!-- Subtitle & Mode Banner -->
        @hasSection('page_subtitle')
        <div class="bg-white border-b border-gray-200 px-6 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-sm font-semibold text-slate-800">@yield('page_headline')</h2>
                <p class="text-xs text-slate-500">@yield('page_subtitle')</p>
            </div>
            <div>
                @yield('status_badge')
            </div>
        </div>
        @endif

        <!-- Flash Messages -->
        <main class="flex-1 p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 shadow-xs">
                    <div class="flex items-center gap-2 mb-2 font-semibold text-sm text-amber-800">
                        <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Mohon periksa kembali isian formulir:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-amber-700 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Quill.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    @stack('scripts')
</body>
</html>
