@extends('layouts.admin')

@section('title', 'Edit Pengguna - ' . $user->name)

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Pengaturan</a>
    <span>/</span>
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-900">Manajemen Pengguna</a>
    <span>/</span>
    <span class="text-slate-800">Edit</span>
@endsection

@section('page_title', 'Edit Pengguna: ' . $user->name)

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shrink-0">
            Kembali
        </a>
        <button type="submit" form="user-form" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Simpan Perubahan</span>
        </button>
    </div>
@endsection

@section('page_headline', 'Edit Data & Permission User')
@section('page_subtitle', 'Ubah informasi akun, role, dan permission akses modul konten.')

@section('content')
<div class="space-y-6">

    <!-- User Info Form -->
    <form id="user-form" action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI: Data Akun & Permissions -->
            <div class="lg:col-span-8 space-y-6">

                <!-- CARD 1: Informasi Akun -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Informasi Akun</h3>
                            <p class="text-xs text-slate-500">Data identitas dan email user.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 mb-2">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="255"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-2">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Permission Modul -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Permission Akses Modul</h3>
                            <p class="text-xs text-slate-500">Centang modul konten yang boleh diakses user ini.</p>
                        </div>
                    </div>

                    @php
                        $permissionLabels = [
                            'manage_home_sections' => ['Beranda', 'Kelola banner dan konten beranda'],
                            'manage_about_sections' => ['Tentang Kami', 'Kelola bagian tentang program'],
                            'manage_product_sections' => ['Produk', 'Kelola katalog produk'],
                            'manage_how_to_order' => ['Cara Pesan', 'Kelola langkah pemesanan'],
                            'manage_testimonials' => ['Testimoni', 'Kelola testimoni pelanggan'],
                            'manage_contact_sections' => ['Kontak', 'Kelola info kontak'],
                        ];
                        $userPermissions = old('permissions', $user->getDirectPermissions()->pluck('name')->toArray());
                    @endphp

                    <div id="permissions-section" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($permissions as $perm)
                            @php $label = $permissionLabels[$perm->name] ?? [$perm->name, '']; @endphp
                            <label class="flex items-start gap-3 p-3.5 rounded-xl border border-gray-200 bg-gray-50/50 hover:bg-emerald-50/50 hover:border-emerald-200 transition-all cursor-pointer">
                                <input type="checkbox"
                                       name="permissions[]"
                                       value="{{ $perm->name }}"
                                       {{ in_array($perm->name, $userPermissions) ? 'checked' : '' }}
                                       class="mt-0.5 w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                                <div>
                                    <span class="text-xs font-bold text-slate-800">{{ $label[0] }}</span>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $label[1] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-4 p-3 bg-amber-50/70 border border-amber-100 rounded-xl flex items-start gap-2.5 text-xs text-amber-800" id="superadmin-info" style="display: none;">
                        <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-bold block text-amber-900">Super Admin</span>
                            <p class="text-[11px] text-amber-700/90 mt-0.5">Role Super Admin secara otomatis mendapat akses ke <strong>semua modul</strong>. Checklist permission di atas tidak berlaku.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Role & Reset Password -->
            <div class="lg:col-span-4 space-y-6">

                <!-- CARD 3: Role -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Role User</h3>
                            <p class="text-xs text-slate-500">Level akses pengguna.</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach($roles as $role)
                            @php $currentRole = old('role', $user->getRoleNames()->first() ?? 'admin'); @endphp
                            <label class="flex items-start gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all {{ $currentRole === $role->name ? 'border-emerald-500 bg-emerald-50/50' : 'border-gray-200 bg-gray-50/50 hover:border-gray-300' }}">
                                <input type="radio" name="role" value="{{ $role->name }}"
                                       {{ $currentRole === $role->name ? 'checked' : '' }}
                                       onchange="handleRoleChange(this.value)"
                                       class="mt-0.5 w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                <div>
                                    <span class="text-sm font-bold text-slate-900">
                                        {{ $role->name === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                    </span>
                                    <p class="text-[11px] text-slate-500 mt-0.5">
                                        @if($role->name === 'super_admin')
                                            Akses penuh ke seluruh sistem termasuk manajemen user.
                                        @else
                                            Akses terbatas sesuai permission yang diberikan.
                                        @endif
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- CARD 4: Metadata -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Info Akun</h3>
                            <p class="text-xs text-slate-500">Metadata akun user.</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center text-slate-500">
                            <span>Status:</span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-rose-50 text-rose-600 border border-rose-200/60' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500">
                            <span>Dibuat:</span>
                            <span class="text-slate-700 font-medium">{{ $user->created_at->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <span class="text-slate-700 font-medium">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Mobile Submit -->
        <div class="sm:hidden mt-6 bg-white rounded-2xl border border-gray-200/80 shadow-xs p-4 space-y-3">
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Simpan Perubahan</span>
            </button>
            <a href="{{ route('admin.users.index') }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Kembali
            </a>
        </div>
    </form>

    <!-- Reset Password Section (Separate Form) -->
    @if($user->id !== auth()->id())
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
        <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
            <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Reset Password</h3>
                <p class="text-xs text-slate-500">Atur password baru untuk user ini.</p>
            </div>
        </div>

        <form action="{{ route('admin.users.reset-password', $user) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="new_password" class="block text-xs font-bold text-slate-700 mb-2">
                        Password Baru <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="new_password" name="new_password" required placeholder="Minimal 8 karakter"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                </div>
                <div>
                    <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 mb-2">
                        Konfirmasi Password <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Ulangi password baru"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl shadow-sm transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Reset Password</span>
                </button>
            </div>
        </form>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function handleRoleChange(role) {
        const permSection = document.getElementById('permissions-section');
        const superAdminInfo = document.getElementById('superadmin-info');
        const checkboxes = permSection.querySelectorAll('input[type="checkbox"]');

        if (role === 'super_admin') {
            permSection.style.opacity = '0.5';
            permSection.style.pointerEvents = 'none';
            superAdminInfo.style.display = 'flex';
            checkboxes.forEach(cb => { cb.checked = true; cb.disabled = true; });
        } else {
            permSection.style.opacity = '1';
            permSection.style.pointerEvents = 'auto';
            superAdminInfo.style.display = 'none';
            checkboxes.forEach(cb => { cb.disabled = false; });
        }

        document.querySelectorAll('input[name="role"]').forEach(radio => {
            const label = radio.closest('label');
            if (radio.checked) {
                label.classList.remove('border-gray-200', 'bg-gray-50/50');
                label.classList.add('border-emerald-500', 'bg-emerald-50/50');
            } else {
                label.classList.remove('border-emerald-500', 'bg-emerald-50/50');
                label.classList.add('border-gray-200', 'bg-gray-50/50');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectedRole = document.querySelector('input[name="role"]:checked');
        if (selectedRole) {
            handleRoleChange(selectedRole.value);
        }
    });
</script>
@endpush
