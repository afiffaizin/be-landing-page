@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Pengaturan</a>
    <span>/</span>
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-900">Manajemen Pengguna</a>
    <span>/</span>
    <span class="text-slate-800">Tambah Baru</span>
@endsection

@section('page_title', 'Tambah Pengguna Baru')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.users.index') }}"
            class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shrink-0">
            Batalkan
        </a>
        <button type="submit" form="user-form"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Simpan User</span>
        </button>
    </div>
@endsection

@section('page_headline', 'Buat Akun User Baru')
@section('page_subtitle', 'Tentukan nama, email, password, role, dan permission akses modul konten.')

@section('content')
    <form id="user-form" action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI: Data Akun -->
            <div class="lg:col-span-8 space-y-6">

                <!-- CARD 1: Informasi Akun -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Informasi Akun</h3>
                            <p class="text-xs text-slate-500">Data login dan identitas user.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 mb-2">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                maxlength="255" placeholder="Contoh:Admin"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-2">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                maxlength="255" placeholder="Contoh: admin@pengabdian.id"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>

                        <!-- Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="password" class="block text-xs font-bold text-slate-700 mb-2">
                                    Password <span class="text-rose-500">*</span>
                                </label>
                                <input type="password" id="password" name="password" required
                                    placeholder="Minimal 8 karakter"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-2">
                                    Konfirmasi Password <span class="text-rose-500">*</span>
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    placeholder="Ulangi password"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Permission Modul -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Permission Akses Modul</h3>
                            <p class="text-xs text-slate-500">Pilih modul konten yang boleh diakses user ini. Super Admin
                                otomatis mendapat semua akses.</p>
                        </div>
                    </div>

                    <div id="permissions-section" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @php
                            $permissionLabels = [
                                'manage_home_sections' => ['Beranda', 'Kelola banner dan konten beranda'],
                                'manage_about_sections' => ['Tentang Kami', 'Kelola bagian tentang program'],
                                'manage_product_sections' => ['Produk', 'Kelola katalog produk'],
                                'manage_how_to_order' => ['Cara Pesan', 'Kelola langkah pemesanan'],
                                'manage_testimonials' => ['Testimoni', 'Kelola testimoni pelanggan'],
                                'manage_contact_sections' => ['Kontak', 'Kelola info kontak'],
                            ];
                        @endphp

                        @foreach ($permissions as $perm)
                            @php $label = $permissionLabels[$perm->name] ?? [$perm->name, '']; @endphp
                            <label
                                class="flex items-start gap-3 p-3.5 rounded-xl border border-gray-200 bg-gray-50/50 hover:bg-emerald-50/50 hover:border-emerald-200 transition-all cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                    {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}
                                    class="mt-0.5 w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                                <div>
                                    <span class="text-xs font-bold text-slate-800">{{ $label[0] }}</span>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $label[1] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <!-- Info: Super Admin bypass -->
                    <div class="mt-4 p-3 bg-amber-50/70 border border-amber-100 rounded-xl flex items-start gap-2.5 text-xs text-amber-800"
                        id="superadmin-info" style="display: none;">
                        <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-bold block text-amber-900">Super Admin</span>
                            <p class="text-[11px] text-amber-700/90 mt-0.5">Role Super Admin secara otomatis mendapat akses
                                ke <strong>semua modul</strong>. Checklist permission di atas tidak berlaku.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Role -->
            <div class="lg:col-span-4 space-y-6">

                <!-- CARD 3: Role -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Role User</h3>
                            <p class="text-xs text-slate-500">Tentukan level akses user.</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach ($roles as $role)
                            <label
                                class="flex items-start gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all {{ old('role') === $role->name ? 'border-emerald-500 bg-emerald-50/50' : 'border-gray-200 bg-gray-50/50 hover:border-gray-300' }}">
                                <input type="radio" name="role" value="{{ $role->name }}"
                                    {{ old('role') === $role->name ? 'checked' : '' }}
                                    onchange="handleRoleChange(this.value)"
                                    class="mt-0.5 w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                <div>
                                    <span class="text-sm font-bold text-slate-900">
                                        {{ $role->name === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                    </span>
                                    <p class="text-[11px] text-slate-500 mt-0.5">
                                        @if ($role->name === 'super_admin')
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

                <!-- Info Card -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Informasi</h3>
                            <p class="text-xs text-slate-500">Panduan membuat akun user.</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="flex items-start gap-2">
                            <span
                                class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5">1</span>
                            <p>Isi data lengkap: nama, email, dan password.</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span
                                class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5">2</span>
                            <p>Pilih role: <strong>Super Admin</strong> (semua akses) atau <strong>Admin</strong> (akses
                                terbatas).</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span
                                class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5">3</span>
                            <p>Untuk role Admin, centang permission modul yang boleh diakses.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Mobile Submit -->
        <div class="sm:hidden mt-6 bg-white rounded-2xl border border-gray-200/80 shadow-xs p-4 space-y-3">
            <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Simpan User</span>
            </button>
            <a href="{{ route('admin.users.index') }}"
                class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Batalkan & Kembali
            </a>
        </div>
    </form>
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
                checkboxes.forEach(cb => {
                    cb.checked = true;
                    cb.disabled = true;
                });
            } else {
                permSection.style.opacity = '1';
                permSection.style.pointerEvents = 'auto';
                superAdminInfo.style.display = 'none';
                checkboxes.forEach(cb => {
                    cb.disabled = false;
                });
            }

            // Update radio label styling
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

        // Init on page load
        document.addEventListener('DOMContentLoaded', function() {
            const selectedRole = document.querySelector('input[name="role"]:checked');
            if (selectedRole) {
                handleRoleChange(selectedRole.value);
            }
        });
    </script>
@endpush
