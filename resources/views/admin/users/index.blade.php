@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Pengaturan</a>
    <span>/</span>
    <span class="text-slate-800">Manajemen User</span>
@endsection

@section('page_title', 'Manajemen User')

@section('header_actions')
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah User</span>
    </a>
@endsection

@section('page_headline', 'Daftar Pengguna Sistem')
@section('page_subtitle', 'Kelola akun pengguna, atur role dan permission akses modul konten.')

@section('content')
<div class="space-y-5">

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full">
            <div class="relative flex-1 w-full">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan nama atau email..."
                       class="w-full pl-10 pr-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto shrink-0">
                <select name="role" onchange="this.form.submit()" class="w-full sm:w-auto py-2.5 px-3 pr-8 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 cursor-pointer">
                    <option value="">Semua Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                            {{ $role->name === 'super_admin' ? 'Super Admin' : 'Admin' }}
                        </option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto py-2.5 px-3 pr-8 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-sm transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Cari</span>
                    </button>

                    @if(request('search') || request('role') || request('status'))
                        <a href="{{ route('admin.users.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-xl transition-all" title="Reset Filter">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-5">User</th>
                        <th class="py-3.5 px-5">Role</th>
                        <th class="py-3.5 px-5">Permissions</th>
                        <th class="py-3.5 px-5 text-center">Status</th>
                        <th class="py-3.5 px-5">Dibuat</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full {{ $user->hasRole('super_admin') ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }} font-bold flex items-center justify-center text-xs shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="truncate">
                                        <div class="font-bold text-slate-900 text-sm">{{ $user->name }}</div>
                                        <div class="text-slate-500 text-[11px]">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                @if($user->hasRole('super_admin'))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Super Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Admin
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5">
                                @if($user->hasRole('super_admin'))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-medium text-[10px] border border-amber-200/80">
                                        Semua Akses
                                    </span>
                                @else
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        @forelse($user->getDirectPermissions() as $perm)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-medium text-[10px] border border-slate-200/80">
                                                {{ str_replace('manage_', '', $perm->name) }}
                                            </span>
                                        @empty
                                            <span class="text-slate-400 text-[11px]">Belum ada permission</span>
                                        @endforelse
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap text-center">
                                @if($user->id === auth()->id())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif (Anda)
                                    </span>
                                @else
                                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                title="{{ $user->is_active ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold transition-all cursor-pointer {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap text-slate-500 text-[11px]">
                                <div class="font-medium text-slate-700">{{ $user->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400">{{ $user->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                       title="Edit User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form id="delete-form-{{ $user->id }}"
                                              action="{{ route('admin.users.destroy', $user) }}"
                                              method="POST"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    onclick="confirmDelete(document.getElementById('delete-form-{{ $user->id }}'))"
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                    title="Hapus User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">Belum Ada User</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Tambahkan user baru untuk mengelola konten landing page.
                                </p>
                                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Tambah User Baru</span>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
