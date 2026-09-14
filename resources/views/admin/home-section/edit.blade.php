@extends('layouts.admin')

@section('title', 'Edit Banner - Home Section')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Landing Page</a>
    <span>/</span>
    <a href="{{ route('admin.home-sections.index') }}" class="text-slate-500 hover:text-slate-900">Home Section</a>
    <span>/</span>
    <span class="text-slate-800">Edit</span>
@endsection

@section('page_title', 'Edit Banner (Home Section)')

@section('header_actions')
    <a href="{{ route('admin.home-sections.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
        Batalkan
    </a>
    <button type="submit" form="home-section-form" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>Simpan Perubahan</span>
    </button>
@endsection

@section('page_headline', 'Edit Home Section')
@section('page_subtitle', 'Perbarui konten teks, tombol aksi, gambar banner, serta status publikasi banner.')
@section('status_badge')
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-slate-700 border border-gray-200/60">
        <span class="w-2 h-2 rounded-full bg-slate-500"></span>
        Status Section: Mode Edit Aktif
    </span>
@endsection

@section('content')
<form id="home-section-form" action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- KOLOM KIRI (8 Kolom): Konten Utama & Tombol Aksi -->
        <div class="lg:col-span-8 space-y-6">

            <!-- CARD 1: Konten Utama -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Konten Utama</h3>
                        <p class="text-xs text-slate-500">Kelola judul dan deskripsi utama untuk bagian banner beranda.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <!-- Judul Field -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="title" class="block text-xs font-bold text-slate-700">
                                Judul <span class="text-rose-500">*</span>
                            </label>
                            <span id="title-counter" class="text-[11px] text-slate-400 font-mono">{{ strlen(old('title', $homeSection->title)) }} / 255 Karakter</span>
                        </div>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title', $homeSection->title) }}"
                               required
                               maxlength="255"
                               placeholder="Contoh: Pengabdian Kepada Masyarakat"
                               oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            Gunakan kalimat pemikat yang ringkas dan merepresentasikan fokus utama program.
                        </p>
                    </div>

                    <!-- Deskripsi Rich Editor -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">
                            Deskripsi <span class="text-rose-500">*</span>
                        </label>
                        <div id="editor-container" class="bg-white">{!! old('description', $homeSection->description) !!}</div>
                        <textarea id="description" name="description" class="hidden" required>{{ old('description', $homeSection->description) }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            Tulis narasi pengantar yang informatif dan menarik untuk pengunjung landing page.
                        </p>
                    </div>
                </div>
            </div>

            <!-- CARD 2: Tombol Aksi (Call to Action) -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Tombol Aksi (Call to Action)</h3>
                        <p class="text-xs text-slate-500">Atur tombol aksi (CTA) yang muncul di bawah deskripsi banner.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Tombol Utama (Button 1) -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/60">
                            <span class="text-xs font-bold text-slate-800">Tombol Utama (Button 1)</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-600 text-white">PRIMER</span>
                        </div>
                        <div>
                            <label for="button_one_text" class="block text-[11px] font-semibold text-slate-600 mb-1">Teks Tombol</label>
                            <input type="text"
                                   id="button_one_text"
                                   name="button_one_text"
                                   value="{{ old('button_one_text', $homeSection->button_one_text) }}"
                                   placeholder="Contoh: Lihat Program"
                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                        <div>
                            <label for="button_one_link" class="block text-[11px] font-semibold text-slate-600 mb-1">Tautan / URL</label>
                            <input type="text"
                                   id="button_one_link"
                                   name="button_one_link"
                                   value="{{ old('button_one_link', $homeSection->button_one_link) }}"
                                   placeholder="Contoh: #programs atau https://..."
                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[10px] text-slate-400 mt-1">Bisa berupa anchor (#section) atau URL web eksternal.</p>
                        </div>
                    </div>

                    <!-- Tombol Sekunder (Button 2) -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/60">
                            <span class="text-xs font-bold text-slate-800">Tombol Sekunder (Button 2)</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700">SEKUNDER</span>
                        </div>
                        <div>
                            <label for="button_two_text" class="block text-[11px] font-semibold text-slate-600 mb-1">Teks Tombol</label>
                            <input type="text"
                                   id="button_two_text"
                                   name="button_two_text"
                                   value="{{ old('button_two_text', $homeSection->button_two_text) }}"
                                   placeholder="Contoh: Hubungi Kami"
                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                        <div>
                            <label for="button_two_link" class="block text-[11px] font-semibold text-slate-600 mb-1">Tautan / URL</label>
                            <input type="text"
                                   id="button_two_link"
                                   name="button_two_link"
                                   value="{{ old('button_two_link', $homeSection->button_two_link) }}"
                                   placeholder="Contoh: #contact atau https://wa.me/..."
                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[10px] text-slate-400 mt-1">Bisa berupa anchor (#section) atau URL web eksternal.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN (4 Kolom): Media & Visibilitas -->
        <div class="lg:col-span-4 space-y-6">

            <!-- CARD 3: Media Banner -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Media Banner</h3>
                        <p class="text-xs text-slate-500">Unggah gambar ilustrasi utama banner beranda.</p>
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
                        <div id="image-preview-wrapper" class="{{ $homeSection->image ? '' : 'hidden' }} mb-3">
                            <img id="image-preview"
                                 src="{{ $homeSection->image ? Storage::disk('public')->url($homeSection->image) : '#' }}"
                                 alt="Preview"
                                 class="w-full h-36 object-cover rounded-xl border border-gray-200 shadow-xs mb-2">
                            <div class="flex items-center justify-center gap-4 text-xs">
                                <span class="text-emerald-700 font-semibold underline">Ganti Gambar</span>
                                @if($homeSection->image)
                                    <label onclick="event.stopPropagation()" class="flex items-center gap-1.5 text-rose-600 hover:text-rose-800 font-semibold cursor-pointer">
                                        <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-rose-600">
                                        <span>Hapus Gambar</span>
                                    </label>
                                @endif
                            </div>
                        </div>

                        <!-- Dropzone Icon & Text -->
                        <div id="dropzone-content" class="{{ $homeSection->image ? 'hidden' : '' }}">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-3">
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
                                Rekomendasi rasio: 16:9 (1200x675 px)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 4: Visibilitas -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100">
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
                            <span id="status-badge" class="px-2 py-0.5 rounded text-[10px] font-bold {{ $homeSection->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-slate-700' }}">
                                {{ $homeSection->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-0.5">Tampilkan section ini di landing page publik.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }}
                               onchange="toggleStatusBadge(this)"
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                <!-- Metadata info -->
                <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                    <div class="flex justify-between text-slate-500">
                        <span>Terakhir Diperbarui:</span>
                        <span class="text-slate-600">{{ $homeSection->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-500 pt-1">
                        <span>Status Publikasi:</span>
                        <a href="{{ url('/api/v1/home') }}" target="_blank" title="Klik untuk melihat data JSON di tab baru" class="inline-flex items-center gap-1 font-semibold text-slate-900 hover:text-emerald-600 hover:underline transition-colors">
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
</form>
@endsection

@push('scripts')
<script>
    const quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Tulis deskripsi pengantar yang informatif dan menarik...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'header': 2 }, { 'header': 3 }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'clean']
            ]
        }
    });

    document.getElementById('home-section-form').onsubmit = function() {
        const descriptionInput = document.getElementById('description');
        descriptionInput.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
    };

    function toggleStatusBadge(elem) {
        const badge = document.getElementById('status-badge');
        if (elem.checked) {
            badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
            badge.innerText = 'Aktif';
        } else {
            badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700';
            badge.innerText = 'Draft';
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
</script>
@endpush
