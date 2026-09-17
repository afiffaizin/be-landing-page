@extends('layouts.admin')

@section('title', 'Buat About Section Baru')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Landing Page</a>
    <span>/</span>
    <a href="{{ route('admin.about-sections.index') }}" class="text-slate-500 hover:text-slate-900">About Section</a>
    <span>/</span>
    <span class="text-slate-800">Create</span>
@endsection

@section('page_title', 'Kelola About Section (Tentang Program)')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.about-sections.index') }}"
            class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-slate-50 transition-colors shrink-0">
            Batalkan
        </a>
        <button type="button" onclick="submitWithAction('draft')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs hover:border-gray-300 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            <span>Simpan Draft</span>
        </button>
        <button type="button" onclick="submitWithAction('publish')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Publikasikan</span>
        </button>
    </div>
@endsection

@section('page_headline', 'Create About Section')
@section('page_subtitle',
    'Kelola informasi judul, deskripsi utama tentang program, serta daftar kartu (cards)
    kegiatan.')
@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
        Status Section: Mode Edit Baru
    </span>
@endsection

@section('content')
    <form action="{{ route('admin.about-sections.store') }}" method="POST" id="about-section-form"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="action" id="form-action" value="publish">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI (8 Kolom): Konten Utama & Daftar Cards -->
            <div class="lg:col-span-8 space-y-6">

                <!-- CARD 1: Konten Utama & Deskripsi -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Konten Utama Section</h3>
                            <p class="text-xs text-slate-500">Kelola judul utama dan narasi deskripsi section tentang
                                program.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Judul Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="title" class="block text-xs font-bold text-slate-700">
                                    Judul <span class="text-rose-500">*</span>
                                </label>
                                <span id="title-counter" class="text-[11px] text-slate-400 font-mono">0 / 255 Karakter</span>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                maxlength="255" placeholder="Contoh: Tentang Program Pengabdian"
                                oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Gunakan judul yang jelas dan mencerminkan esensi program.
                            </p>
                        </div>

                        <!-- Deskripsi Rich Editor -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">
                                Deskripsi <span class="text-rose-500">*</span>
                            </label>
                            <x-form.rich-editor name="description" :value="old('description')" placeholder="Tulis latar belakang, visi, atau penjelasan rinci tentang program..." />
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Tulis latar belakang dan tujuan program secara lengkap.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Daftar Cards Program / Fitur (Multiple) -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-slate-900">Cards Program</h3>
                                </div>
                                <p class="text-xs text-slate-500">Setiap card berisi judul, icon, gambar, dan deskripsi.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <button type="button" onclick="collapseAllCards()"
                                class="text-slate-500 hover:text-slate-900 underline">Collapse All</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="expandAllCards()"
                                class="text-slate-500 hover:text-slate-900 underline">Expand All</button>
                        </div>
                    </div>

                    <!-- Cards Container (Repeater) -->
                    <div id="cards-container" class="space-y-4">
                        <!-- Default Initial Card -->
                        <div class="card-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                            data-index="0">
                            <!-- Card Item Header -->
                            <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                                onclick="toggleCardAccordion(this)">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center card-badge-num">1</span>
                                    <span class="card-header-title text-xs font-bold text-slate-800">Card 1</span>
                                </div>
                                <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                    <button type="button" onclick="removeCardItem(this)" title="Hapus Card"
                                        class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                    <button type="button" onclick="toggleCardAccordion(this.parentElement)"
                                        class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 card-accordion-icon transform transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Item Body -->
                            <div class="card-body p-4 space-y-4 bg-white">
                                <!-- Judul Card -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Judul Card <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="cards[0][title]" value="{{ old('cards.0.title') }}"
                                        required placeholder="Contoh: Pemberdayaan Masyarakat"
                                        oninput="updateCardHeaderTitle(this)"
                                        class="card-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                </div>

                                <!-- Icon Selection -->
                                <x-form.icon-picker
                                    name="cards[0][icon_name]"
                                    :value="old('cards.0.icon_name')"
                                    label="Icon Card (Opsional)"
                                    :with-upload="true"
                                    upload-name="cards[0][icon_image]"
                                    remove-name="cards[0][remove_icon_image]"
                                />

                                <!-- Gambar Card Upload -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Gambar Card (Opsional)
                                    </label>
                                    <div class="card-image-dropzone border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl p-4 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                                        onclick="this.querySelector('.card-image-input').click()">
                                        <input type="file" name="cards[0][image]"
                                            accept="image/png,image/jpeg,image/jpg,image/webp"
                                            onchange="handleCardImagePreview(this)" class="card-image-input hidden">

                                        <!-- Preview Image -->
                                        <div class="card-preview-wrapper hidden mb-2">
                                            <img src="#" alt="Preview"
                                                class="card-preview-img w-full max-h-48 object-cover rounded-lg border border-slate-200 shadow-2xs mb-2">
                                            <button type="button"
                                                onclick="event.stopPropagation(); removeCardSelectedImage(this)"
                                                class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline">
                                                Hapus / Ganti Gambar
                                            </button>
                                        </div>

                                        <!-- Dropzone Placeholder Content -->
                                        <div class="card-dropzone-content">
                                            <svg class="w-8 h-8 text-slate-400 mx-auto mb-1.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <p class="text-xs font-medium text-slate-700">
                                                Klik atau seret gambar untuk card ini
                                            </p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">
                                                Format: PNG, JPG, WEBP • Maks 2MB
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Deskripsi Card -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Deskripsi Card <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea name="cards[0][description]" rows="3" required
                                        placeholder="Jelaskan secara ringkas kegiatan atau manfaat dari program pada card ini..."
                                        class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">{{ old('cards.0.description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <button type="button" onclick="addNewCardItem()"
                        class="mt-5 w-full py-3 border-2 border-dashed border-emerald-300 hover:border-emerald-500 bg-emerald-50/30 hover:bg-emerald-50/80 rounded-xl text-xs font-bold text-emerald-800 hover:text-emerald-900 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Tambah Card Baru</span>
                    </button>
                </div>

            </div>

            <!-- KOLOM KANAN (4 Kolom): Status & Aksi -->
            <div class="lg:col-span-4 space-y-6">

                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Visibilitas</h3>
                            <p class="text-xs text-slate-500">Pengaturan status publikasi section.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800">Status Section</span>
                                <span id="status-badge"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tentukan apakah section ini langsung tampil atau
                                draft.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active_toggle" value="1" checked
                                onchange="toggleStatusBadge(this)" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600">
                            </div>
                        </label>
                    </div>

                    <div class="pt-3 border-t border-gray-100">
                        <div
                            class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl flex items-start gap-2.5 text-xs text-emerald-800">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <span class="font-bold block text-emerald-900">Kebijakan 1 Section Aktif</span>
                                <p class="text-[11px] text-emerald-700/90 mt-0.5">Sistem memastikan hanya 1 about section
                                    yang aktif. Saat section ini dipublikasikan, section lama yang sedang aktif otomatis
                                    dijadikan <strong>Draft</strong>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between items-start text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <div class="text-right">
                                <span class="text-slate-700 font-medium">{{ now()->translatedFormat('d M Y, H:i') }} WIB</span>
                                <span class="text-[11px] text-emerald-600 font-medium block">Saat disimpan (Baru)</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 pt-1">
                            <span>Status Publikasi:</span>
                            <a href="{{ url('/api/v1/about') }}" target="_blank"
                                title="Klik untuk melihat data JSON di tab baru"
                                class="inline-flex items-center gap-1 font-semibold text-slate-900 hover:text-emerald-600 hover:underline transition-colors">
                                <span>Tersedia via API Publik</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Tombol Aksi Khusus Layar Kecil (Mobile / Di Bawah Konten) -->
        <div class="sm:hidden mt-6 bg-white rounded-2xl border border-gray-200/80 shadow-xs p-4 space-y-3">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="submitWithAction('draft')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                        </path>
                    </svg>
                    <span>Simpan Draft</span>
                </button>
                <button type="button" onclick="submitWithAction('publish')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Publikasikan</span>
                </button>
            </div>
            <a href="{{ route('admin.about-sections.index') }}"
                class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Batalkan & Kembali
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial counter
            const titleInput = document.getElementById('title');
            if (titleInput) {
                document.getElementById('title-counter').innerText = titleInput.value.length + ' / 255 Karakter';
            }

            // Initialize lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function submitWithAction(action) {
            document.getElementById('form-action').value = action;
            const toggle = document.getElementById('is_active_toggle');
            const badge = document.getElementById('status-badge');
            if (action === 'draft') {
                if (toggle) toggle.checked = false;
                if (badge) {
                    badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700';
                    badge.innerText = 'Draft';
                }
            } else if (action === 'publish') {
                if (toggle) toggle.checked = true;
                if (badge) {
                    badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
                    badge.innerText = 'Aktif';
                }
            }

            const form = document.getElementById('about-section-form');
            if (form.reportValidity()) {
                form.submit();
            }
        }

        function toggleStatusBadge(elem) {
            const badge = document.getElementById('status-badge');
            const formAction = document.getElementById('form-action');
            if (elem.checked) {
                badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
                badge.innerText = 'Aktif';
                if (formAction) formAction.value = 'publish';
            } else {
                badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700';
                badge.innerText = 'Draft';
                if (formAction) formAction.value = 'draft';
            }
        }

        // ─── Cards Repeater Scripts ──────────────────────────────────────────
        let cardIndexCounter = 1;

        function updateCardBadgeCount() {
            const count = document.querySelectorAll('#cards-container .card-item').length;
            const el = document.getElementById('card-count-badge');
            if (el) el.innerText = count + (count === 1 ? ' Card' : ' Cards');
        }

        function reindexCards() {
            const items = document.querySelectorAll('#cards-container .card-item');
            items.forEach((item, idx) => {
                const badge = item.querySelector('.card-badge-num');
                if (badge) badge.innerText = idx + 1;

                const headerTitle = item.querySelector('.card-header-title');
                const titleInput = item.querySelector('.card-title-input');
                if (headerTitle) {
                    const val = titleInput && titleInput.value.trim() ? titleInput.value.trim() : 'Card ' + (idx + 1);
                    headerTitle.innerText = val;
                }
            });
            updateCardBadgeCount();
        }

        function updateCardHeaderTitle(input) {
            const item = input.closest('.card-item');
            const headerTitle = item.querySelector('.card-header-title');
            const idx = Array.from(document.querySelectorAll('#cards-container .card-item')).indexOf(item) + 1;
            if (headerTitle) {
                headerTitle.innerText = input.value.trim() ? input.value.trim() : 'Card ' + idx;
            }
        }

        function toggleCardAccordion(trigger) {
            const item = trigger.closest('.card-item');
            const body = item.querySelector('.card-body');
            const icon = item.querySelector('.card-accordion-icon');

            if (body.classList.contains('hidden')) {
                body.classList.remove('hidden');
                if (icon) icon.classList.remove('-rotate-90');
            } else {
                body.classList.add('hidden');
                if (icon) icon.classList.add('-rotate-90');
            }
        }

        function collapseAllCards() {
            document.querySelectorAll('#cards-container .card-item').forEach(item => {
                item.querySelector('.card-body').classList.add('hidden');
                const icon = item.querySelector('.card-accordion-icon');
                if (icon) icon.classList.add('-rotate-90');
            });
        }

        function expandAllCards() {
            document.querySelectorAll('#cards-container .card-item').forEach(item => {
                item.querySelector('.card-body').classList.remove('hidden');
                const icon = item.querySelector('.card-accordion-icon');
                if (icon) icon.classList.remove('-rotate-90');
            });
        }

        function addNewCardItem() {
            const container = document.getElementById('cards-container');
            const currentCount = container.querySelectorAll('.card-item').length;
            const newNum = currentCount + 1;
            const index = cardIndexCounter++;

            const cardHtml = `
            <div class="card-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs" data-index="${index}">
                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer" onclick="toggleCardAccordion(this)">
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center card-badge-num">${newNum}</span>
                        <span class="card-header-title text-xs font-bold text-slate-800">Card ${newNum}</span>
                    </div>
                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                        <button type="button" onclick="removeCardItem(this)" title="Hapus Card" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="toggleCardAccordion(this.parentElement)" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4 card-accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card-body p-4 space-y-4 bg-white">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Judul Card <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="cards[${index}][title]"
                               required
                               placeholder="Contoh: Pemberdayaan Masyarakat"
                               oninput="updateCardHeaderTitle(this)"
                               class="card-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                    </div>

                    <!-- Icon Selection -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Icon Card (Opsional)
                        </label>
                        <input type="hidden" name="cards[${index}][icon_name]" class="card-icon-name-input" value="">
                        <input type="hidden" name="cards[${index}][remove_icon_image]" value="0" class="card-remove-icon-flag">
                        <div class="flex items-start gap-3">
                            <!-- Lucide Picker Button -->
                            <div class="flex-1">
                                <button type="button" onclick="openIconPicker(this)"
                                    class="icon-picker-trigger w-full flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-600 hover:border-emerald-400 hover:bg-emerald-50/30 transition-all cursor-pointer">
                                    <span class="icon-picker-preview w-5 h-5 text-slate-400 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </span>
                                    <span class="icon-picker-label flex-1 text-left">Pilih Icon Lucide...</span>
                                    <span class="icon-picker-clear hidden text-rose-400 hover:text-rose-600 p-0.5" onclick="event.stopPropagation(); clearSelectedIcon(this)">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </span>
                                </button>
                            </div>
                            <!-- Upload Custom Icon -->
                            <div class="flex-1">
                                <div class="icon-upload-zone border border-dashed border-gray-200 hover:border-emerald-400 rounded-xl px-3.5 py-2.5 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                                     onclick="this.querySelector('.card-icon-image-input').click()">
                                    <input type="file" name="cards[${index}][icon_image]"
                                           accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                                           onchange="handleIconImagePreview(this)"
                                           class="card-icon-image-input hidden">
                                    <div class="icon-upload-preview hidden flex items-center gap-2">
                                        <img src="#" alt="Icon Preview" class="icon-upload-preview-img w-6 h-6 object-contain rounded">
                                        <span class="text-xs text-slate-700 font-medium truncate flex-1">Custom Icon</span>
                                        <button type="button" onclick="event.stopPropagation(); removeIconImage(this)" class="text-rose-400 hover:text-rose-600 p-0.5 shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="icon-upload-placeholder flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        <span class="text-xs text-slate-500">Upload Custom</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Pilih icon Lucide atau upload gambar custom (PNG, SVG, maks 512KB).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Gambar Card (Opsional)
                        </label>
                        <div class="card-image-dropzone border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl p-4 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                             onclick="this.querySelector('.card-image-input').click()">
                            <input type="file"
                                   name="cards[${index}][image]"
                                   accept="image/png,image/jpeg,image/jpg,image/webp"
                                   onchange="handleCardImagePreview(this)"
                                   class="card-image-input hidden">
                            <div class="card-preview-wrapper hidden mb-2">
                                <img src="#" alt="Preview" class="card-preview-img w-full max-h-48 object-cover rounded-lg border border-slate-200 shadow-2xs mb-2">
                                <button type="button" onclick="event.stopPropagation(); removeCardSelectedImage(this)" class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline">
                                    Hapus / Ganti Gambar
                                </button>
                            </div>
                            <div class="card-dropzone-content">
                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs font-medium text-slate-700">Klik atau seret gambar untuk card ini</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Format: PNG, JPG, WEBP • Maks 2MB</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Deskripsi Card <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="cards[${index}][description]"
                                  rows="3"
                                  required
                                  placeholder="Jelaskan secara ringkas kegiatan atau manfaat dari program pada card ini..."
                                  class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600"></textarea>
                    </div>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', cardHtml);
            reindexCards();

            // Scroll smoothly to newly added card
            const newCard = container.lastElementChild;
            newCard.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function removeCardItem(btn) {
            const container = document.getElementById('cards-container');
            const items = container.querySelectorAll('.card-item');
            if (items.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Minimal harus ada 1 card di dalam About Section.',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }

            const item = btn.closest('.card-item');
            item.style.opacity = '0';
            item.style.transform = 'scale(0.95)';
            setTimeout(() => {
                item.remove();
                reindexCards();
            }, 150);
        }

        // ─── Image Preview Handlers ──────────────────────────────────────────
        function handleCardImagePreview(input) {
            const file = input.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Maksimal ukuran gambar card adalah 2MB.',
                    confirmButtonColor: '#e11d48'
                });
                input.value = '';
                return;
            }

            const dropzone = input.closest('.card-image-dropzone');
            const previewWrapper = dropzone.querySelector('.card-preview-wrapper');
            const previewImg = dropzone.querySelector('.card-preview-img');
            const dropzoneContent = dropzone.querySelector('.card-dropzone-content');

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrapper.classList.remove('hidden');
                dropzoneContent.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        function removeCardSelectedImage(btn) {
            const dropzone = btn.closest('.card-image-dropzone');
            const input = dropzone.querySelector('.card-image-input');
            const previewWrapper = dropzone.querySelector('.card-preview-wrapper');
            const previewImg = dropzone.querySelector('.card-preview-img');
            const dropzoneContent = dropzone.querySelector('.card-dropzone-content');

            input.value = '';
            previewImg.src = '#';
            previewWrapper.classList.add('hidden');
            dropzoneContent.classList.remove('hidden');
        }
    </script>
@endpush
