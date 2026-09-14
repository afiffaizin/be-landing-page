@extends('layouts.admin')

@section('title', 'Edit About Section')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Landing Page</a>
    <span>/</span>
    <a href="{{ route('admin.about-sections.index') }}" class="text-slate-500 hover:text-slate-900">About Section</a>
    <span>/</span>
    <span class="text-slate-800">Edit Konten</span>
@endsection

@section('page_title', 'Kelola About Section (Tentang Program)')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.about-sections.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-slate-50 transition-colors shrink-0">
            Batalkan
        </a>
        <button type="button" onclick="submitWithAction('draft')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs hover:border-gray-300 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            <span>Simpan Draft</span>
        </button>
        <button type="button" onclick="submitWithAction('publish')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Publikasikan</span>
        </button>
    </div>
@endsection

@section('page_headline', 'Edit Konten About Section')
@section('page_subtitle', 'Kelola informasi pengantar, visi misi singkat, daftar poin keunggulan, serta tautan aksi dokumentasi.')
@section('status_badge')
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $aboutSection->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-700 border border-slate-200/60' }}">
        <span class="w-2 h-2 rounded-full {{ $aboutSection->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
        Status: {{ $aboutSection->is_active ? 'Aktif di Landing Page' : 'Draft (Nonaktif)' }}
    </span>
@endsection

@section('content')
<form id="about-section-form" action="{{ route('admin.about-sections.update', $aboutSection) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="action" id="form-action" value="{{ $aboutSection->is_active ? 'publish' : 'draft' }}">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- KOLOM KIRI (8 Kolom): Konten Utama & Poin-Poin Program -->
        <div class="lg:col-span-8 space-y-6">

            <!-- CARD 1: Konten Utama & Deskripsi -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Konten Utama & Deskripsi</h3>
                        <p class="text-xs text-slate-500">Kelola judul dan narasi deskripsi section tentang program.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <!-- Judul Field -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="title" class="block text-xs font-bold text-slate-700">
                                Judul <span class="text-rose-500">*</span>
                            </label>
                            <span id="title-counter" class="text-[11px] text-slate-400 font-mono">{{ strlen(old('title', $aboutSection->title)) }} / 255 Karakter</span>
                        </div>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title', $aboutSection->title) }}"
                               required
                               maxlength="255"
                               placeholder="Contoh: Tentang Program Pengabdian"
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
                        <div id="editor-container" class="bg-white">{!! old('description', $aboutSection->description) !!}</div>
                        <textarea id="description" name="description" class="hidden" required>{{ old('description', $aboutSection->description) }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            Tulis latar belakang dan tujuan program secara lengkap.
                        </p>
                    </div>
                </div>
            </div>

            <!-- CARD 2: Poin-Poin Program (Pilar Keunggulan) -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Poin-Poin Program (Pilar Keunggulan)</h3>
                            <p class="text-xs text-slate-500">Daftar poin kegiatan atau pilar kegiatan pengabdian yang ditampilkan di landing page.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-medium">
                        <button type="button" onclick="collapseAllPoints()" class="text-slate-500 hover:text-slate-900 underline">Collapse All</button>
                        <span class="text-slate-300">|</span>
                        <button type="button" onclick="expandAllPoints()" class="text-slate-500 hover:text-slate-900 underline">Expand All</button>
                    </div>
                </div>

                <!-- Points Container (Repeater) -->
                <div id="points-container" class="space-y-4">
                    @php
                        $points = old('points', $aboutSection->points ?? []);
                        if (empty($points)) {
                            $points = [
                                ['number' => 1, 'title' => 'Pemberdayaan Masyarakat', 'description' => 'Mendorong kemandirian masyarakat melalui pelatihan, pendampingan, dan pemanfaatan potensi lokal.']
                            ];
                        }
                    @endphp

                    @foreach($points as $idx => $point)
                        <div class="point-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all" data-index="{{ $idx }}">
                            <!-- Header -->
                            <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer" onclick="togglePointAccordion(this)">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-slate-400 font-mono text-xs cursor-grab">⋮⋮</span>
                                    <span class="point-header-title text-xs font-bold text-slate-800">
                                        {{ $point['number'] ?? ($idx + 1) }}. {{ $point['title'] ?? 'Poin Baru' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                    <button type="button" onclick="removePointItem(this)" title="Hapus Poin" class="p-1 text-slate-400 hover:text-rose-600 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    <button type="button" onclick="togglePointAccordion(this.parentElement)" class="p-1 text-slate-400 hover:text-slate-700">
                                        <svg class="w-4 h-4 accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="point-body p-4 space-y-3.5 bg-white">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nomor <span class="text-rose-500">*</span></label>
                                        <input type="number"
                                               name="points[{{ $idx }}][number]"
                                               value="{{ $point['number'] ?? ($idx + 1) }}"
                                               required
                                               class="point-number-input w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Judul Poin <span class="text-rose-500">*</span></label>
                                        <input type="text"
                                               name="points[{{ $idx }}][title]"
                                               value="{{ $point['title'] ?? '' }}"
                                               required
                                               placeholder="Contoh: Pemberdayaan Masyarakat"
                                               oninput="updatePointTitle(this)"
                                               class="point-title-input w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Poin <span class="text-rose-500">*</span></label>
                                    <textarea name="points[{{ $idx }}][description]"
                                              rows="3"
                                              required
                                              placeholder="Jelaskan kegiatan atau sasaran dari poin ini..."
                                              class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">{{ $point['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Add Button -->
                <button type="button"
                        onclick="addPointItem()"
                        class="mt-4 w-full py-3 border border-dashed border-emerald-200 hover:border-slate-400 hover:bg-slate-50 rounded-xl text-xs font-semibold text-slate-700 hover:text-slate-900 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Poin Baru</span>
                </button>
            </div>

        </div>

        <!-- KOLOM KANAN (4 Kolom): Media & Visibilitas -->
        <div class="lg:col-span-4 space-y-6">

            <!-- CARD 3: Media Dokumentasi -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Media Dokumentasi</h3>
                        <p class="text-xs text-slate-500">Unggah gambar dokumentasi kegiatan untuk section ini.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Gambar Utama</label>
                    <div id="dropzone"
                         onclick="document.getElementById('image-input').click()"
                         class="border-2 border-dashed border-emerald-200 hover:border-emerald-400 rounded-2xl p-6 text-center cursor-pointer transition-all bg-emerald-50/30 hover:bg-emerald-50/60">
                        <input type="file"
                               id="image-input"
                               name="image"
                               accept="image/png,image/jpeg,image/jpg,image/webp"
                               onchange="handleImagePreview(this)"
                               class="hidden">

                        <!-- Preview Container -->
                        <div id="image-preview-wrapper" class="{{ $aboutSection->image ? '' : 'hidden' }} mb-3">
                            <img id="image-preview"
                                 src="{{ $aboutSection->image ? Storage::disk('public')->url($aboutSection->image) : '#' }}"
                                 alt="Preview"
                                 class="w-full h-36 object-cover rounded-xl border border-slate-200 shadow-xs mb-2">
                            <div class="flex items-center justify-center gap-4 text-xs">
                                <span class="text-emerald-700 font-semibold underline">Ganti Gambar</span>
                                @if($aboutSection->image)
                                    <label onclick="event.stopPropagation()" class="flex items-center gap-1.5 text-rose-600 hover:text-rose-800 font-semibold cursor-pointer">
                                        <input type="checkbox" name="remove_image" value="1" class="rounded border-slate-300 text-rose-600">
                                        <span>Hapus Gambar</span>
                                    </label>
                                @endif
                            </div>
                        </div>

                        <!-- Dropzone Icon & Text -->
                        <div id="dropzone-content" class="{{ $aboutSection->image ? 'hidden' : '' }}">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-800">
                                Tarik & lepas file atau <span class="text-emerald-700 font-semibold underline">Jelajahi</span>
                            </p>
                            <p class="text-[11px] text-slate-400 mt-1">
                                Format: PNG, JPG, WEBP • Maksimal 2MB
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                Rekomendasi rasio: 4:3 atau 16:9
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 4: Visibilitas -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                <div class="flex items-center gap-3 pb-5 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
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
                            <span class="text-xs font-bold text-slate-800">Status Aktif</span>
                            <span id="status-badge" class="px-2 py-0.5 rounded text-[10px] font-bold {{ $aboutSection->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                {{ $aboutSection->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-0.5">Tentukan apakah section ini langsung tampil atau draft.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="is_active"
                               id="is_active_toggle"
                               value="1"
                               {{ old('is_active', $aboutSection->is_active) ? 'checked' : '' }}
                               onchange="toggleStatusBadge(this)"
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                <!-- Info Sistem: Hanya 1 section aktif -->
                <div class="pt-3 border-t border-gray-100">
                    <div class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl flex items-start gap-2.5 text-xs text-emerald-800">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-bold block text-emerald-900">Kebijakan 1 Section Aktif</span>
                            <p class="text-[11px] text-emerald-700/90 mt-0.5">Sistem memastikan hanya 1 about section yang aktif di landing page. Saat section ini dipublikasikan, section aktif lainnya otomatis menjadi <strong>Draft</strong>.</p>
                        </div>
                    </div>
                </div>

                <!-- Metadata info -->
                <div class="pt-4 border-t border-slate-100 space-y-2 text-xs">
                    <div class="flex justify-between text-slate-500">
                        <span>Terakhir Diperbarui:</span>
                        <span class="text-slate-600">{{ $aboutSection->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-500 pt-1">
                        <span>Status Publikasi:</span>
                        <a href="{{ url('/api/v1/about') }}" target="_blank" title="Klik untuk melihat data JSON di tab baru" class="inline-flex items-center gap-1 font-semibold text-slate-900 hover:text-emerald-600 hover:underline transition-colors">
                            <span>Tersedia via API Publik</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
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
            <button type="button" onclick="submitWithAction('draft')" class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs transition-all cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                <span>Simpan Draft</span>
            </button>
            <button type="button" onclick="submitWithAction('publish')" class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                <svg class="w-4 h-4 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Publikasikan</span>
            </button>
        </div>
        <a href="{{ route('admin.about-sections.index') }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
            Batalkan & Kembali
        </a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Tulis latar belakang dan tujuan program secara lengkap...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'header': 2 }, { 'header': 3 }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'clean']
            ]
        }
    });

    // Form submit handler dengan aksi draft atau publish
    function submitWithAction(action) {
        document.getElementById('form-action').value = action;
        const toggle = document.getElementById('is_active_toggle');
        if (action === 'draft') {
            if (toggle) toggle.checked = false;
            const badge = document.getElementById('status-badge');
            if (badge) {
                badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700';
                badge.innerText = 'Draft';
            }
        } else if (action === 'publish') {
            if (toggle) toggle.checked = true;
            const badge = document.getElementById('status-badge');
            if (badge) {
                badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
                badge.innerText = 'Aktif';
            }
        }

        const descriptionInput = document.getElementById('description');
        descriptionInput.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;

        const form = document.getElementById('about-section-form');
        if (form.reportValidity()) {
            form.submit();
        }
    }

    document.getElementById('about-section-form').onsubmit = function() {
        const descriptionInput = document.getElementById('description');
        descriptionInput.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
    };

    function toggleStatusBadge(elem) {
        const badge = document.getElementById('status-badge');
        const formAction = document.getElementById('form-action');
        if (elem.checked) {
            badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
            badge.innerText = 'Aktif';
            if (formAction) formAction.value = 'publish';
        } else {
            badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700';
            badge.innerText = 'Draft';
            if (formAction) formAction.value = 'draft';
        }
    }

    function handleImagePreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-wrapper').classList.remove('hidden');
                document.getElementById('dropzone-content').classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeSelectedImage() {
        const input = document.getElementById('image-input');
        input.value = '';
        document.getElementById('image-preview').src = '#';
        document.getElementById('image-preview-wrapper').classList.add('hidden');
        document.getElementById('dropzone-content').classList.remove('hidden');
    }

    let pointCount = {{ count($points) }};

    function addPointItem() {
        const container = document.getElementById('points-container');
        const nextIndex = pointCount++;
        const nextNum = container.children.length + 1;

        const html = `
            <div class="point-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all" data-index="${nextIndex}">
                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer" onclick="togglePointAccordion(this)">
                    <div class="flex items-center gap-2.5">
                        <span class="text-slate-400 font-mono text-xs cursor-grab">⋮⋮</span>
                        <span class="point-header-title text-xs font-bold text-slate-800">${nextNum}. Poin Baru</span>
                    </div>
                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                        <button type="button" onclick="removePointItem(this)" title="Hapus Poin" class="p-1 text-slate-400 hover:text-rose-600 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="togglePointAccordion(this.parentElement)" class="p-1 text-slate-400 hover:text-slate-700">
                            <svg class="w-4 h-4 accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="point-body p-4 space-y-3.5 bg-white">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nomor <span class="text-rose-500">*</span></label>
                            <input type="number"
                                   name="points[${nextIndex}][number]"
                                   value="${nextNum}"
                                   required
                                   class="point-number-input w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Judul Poin <span class="text-rose-500">*</span></label>
                            <input type="text"
                                   name="points[${nextIndex}][title]"
                                   required
                                   placeholder="Contoh: Penerapan IPTEK"
                                   oninput="updatePointTitle(this)"
                                   class="point-title-input w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Poin <span class="text-rose-500">*</span></label>
                        <textarea name="points[${nextIndex}][description]"
                                  rows="3"
                                  required
                                  placeholder="Jelaskan kegiatan atau sasaran dari poin ini..."
                                  class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600"></textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function removePointItem(btn) {
        const item = btn.closest('.point-item');
        item.remove();
        renumberPoints();
    }

    function updatePointTitle(input) {
        const item = input.closest('.point-item');
        const numInput = item.querySelector('.point-number-input');
        const headerTitle = item.querySelector('.point-header-title');
        const num = numInput.value || '';
        const title = input.value || 'Poin Baru';
        headerTitle.innerText = `${num ? num + '. ' : ''}${title}`;
    }

    function renumberPoints() {
        const container = document.getElementById('points-container');
        const items = container.querySelectorAll('.point-item');
        items.forEach((item, index) => {
            const num = index + 1;
            const numInput = item.querySelector('.point-number-input');
            const titleInput = item.querySelector('.point-title-input');
            const headerTitle = item.querySelector('.point-header-title');
            if (numInput) numInput.value = num;
            const title = titleInput ? titleInput.value || 'Poin Baru' : 'Poin Baru';
            if (headerTitle) headerTitle.innerText = `${num}. ${title}`;
        });
    }

    function togglePointAccordion(headerElem) {
        const item = headerElem.closest('.point-item');
        const body = item.querySelector('.point-body');
        const icon = item.querySelector('.accordion-icon');
        if (body.classList.contains('hidden')) {
            body.classList.remove('hidden');
            icon.classList.remove('-rotate-90');
        } else {
            body.classList.add('hidden');
            icon.classList.add('-rotate-90');
        }
    }

    function collapseAllPoints() {
        document.querySelectorAll('#points-container .point-body').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('#points-container .accordion-icon').forEach(el => el.classList.add('-rotate-90'));
    }

    function expandAllPoints() {
        document.querySelectorAll('#points-container .point-body').forEach(el => el.classList.remove('hidden'));
        document.querySelectorAll('#points-container .accordion-icon').forEach(el => el.classList.remove('-rotate-90'));
    }
</script>
@endpush
