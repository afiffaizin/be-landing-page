@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-indigo-600">Home</a>
    <span>/</span>
    <span class="text-slate-800">Dashboard</span>
@endsection

@section('page_title', 'Dashboard Overview')

@section('header_actions')
    <a href="{{ route('admin.home-sections.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-xs transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Buat Banner Baru</span>
    </a>
@endsection

@section('page_headline', 'Selamat Datang di Admin Portal CMS')
@section('page_subtitle', 'Kelola seluruh modul konten landing page publik Anda secara terpusat.')
@section('status_badge')
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        Sistem Berjalan Normal
    </span>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Home Section -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Home Sections</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalHome }}</h3>
                <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    {{ $activeHome }} Section Aktif
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"></path>
                </svg>
            </div>
        </div>

        <!-- Card 2: About Section -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">About Sections</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalAbout }}</h3>
                <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    {{ $activeAbout }} Section Aktif
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Card 3: Total Points -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Poin Keunggulan</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalPoints }}</h3>
                <p class="text-xs text-slate-500 mt-1">Total di About Sections</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>

        <!-- Card 4: API Endpoints -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Frontend API v1</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">2 Endpoints</h3>
                <p class="text-xs text-indigo-600 font-medium mt-1">GET /api/v1/...</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts & Module Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Home Section Box -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-slate-900">Modul Home Section</h4>
                        <p class="text-xs text-slate-500">Banner utama, heading hero, narasi dan tombol aksi (CTA).</p>
                    </div>
                </div>
                <a href="{{ route('admin.home-sections.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse($recentHome as $home)
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3 truncate max-w-sm">
                            @if($home->image)
                                <img src="{{ Storage::disk('public')->url($home->image) }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200" alt="thumbnail">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-slate-200 text-slate-400 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="truncate">
                                <h5 class="text-sm font-semibold text-slate-900 truncate">{{ $home->title }}</h5>
                                <p class="text-xs text-slate-400">{{ $home->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $home->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $home->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                            <a href="{{ route('admin.home-sections.edit', $home) }}" class="p-1.5 text-slate-400 hover:text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-3 text-center">Belum ada data home section.</p>
                @endforelse
            </div>
        </div>

        <!-- About Section Box -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-slate-900">Modul About Section</h4>
                        <p class="text-xs text-slate-500">Deskripsi latar belakang, visi misi, dan poin pilar program.</p>
                    </div>
                </div>
                <a href="{{ route('admin.about-sections.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse($recentAbout as $about)
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3 truncate max-w-sm">
                            @if($about->image)
                                <img src="{{ Storage::disk('public')->url($about->image) }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200" alt="thumbnail">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-slate-200 text-slate-400 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="truncate">
                                <h5 class="text-sm font-semibold text-slate-900 truncate">{{ $about->title }}</h5>
                                <p class="text-xs text-slate-400">{{ is_array($about->points) ? count($about->points) : 0 }} Poin Pilar</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $about->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $about->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                            <a href="{{ route('admin.about-sections.edit', $about) }}" class="p-1.5 text-slate-400 hover:text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-3 text-center">Belum ada data about section.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Frontend Integration Information Box -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-2xl p-6 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-indigo-400 text-xs font-bold uppercase tracking-wider mb-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Integrasi Headless Frontend</span>
                </div>
                <h4 class="text-lg font-bold">API Terhubung Siap Digunakan oleh Frontend</h4>
                <p class="text-xs text-slate-300 max-w-2xl mt-1">
                    Perubahan teks, gambar banner, dan poin pilar yang Anda simpan di admin dashboard ini langsung dapat ditarik secara instan oleh Frontend melalui REST API JSON.
                </p>
            </div>
            <div class="flex flex-wrap gap-2 text-xs font-mono">
                <a href="/api/v1/home" target="_blank" class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-white transition-colors">
                    GET /api/v1/home ↗
                </a>
                <a href="/api/v1/about" target="_blank" class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-white transition-colors">
                    GET /api/v1/about ↗
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
