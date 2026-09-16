@extends('layouts.admin')

@section('title', 'Buat Section Cara Pesan')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Landing Page</a>
    <span>/</span>
    <a href="{{ route('admin.how-to-orders.index') }}" class="text-slate-500 hover:text-slate-900">Cara Pesan</a>
    <span>/</span>
    <span class="text-slate-800">Buat Baru</span>
@endsection

@section('page_title', 'Buat Section Cara Pesan')

@section('page_headline', 'Create How To Order Section')
@section('page_subtitle', 'Kelola informasi judul, deskripsi, CTA, serta langkah-langkah pemesanan.')
@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
        Status Section: Mode Edit Baru
    </span>
@endsection

@section('content')
    <form action="{{ route('admin.how-to-orders.store') }}" method="POST" id="howToOrderForm">
        @csrf
        <input type="hidden" name="action" id="formAction" value="publish">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
            <!-- Kolom Kiri: Form Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Utama Section -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
                    <div class="border-b border-gray-100 bg-gray-50/50 px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h7">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm">Konten Utama Section</h3>
                        </div>
                    </div>

                    <div class="p-5 space-y-5">
                        <!-- Judul Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="title" class="block text-xs font-bold text-slate-700">
                                    Judul <span class="text-rose-500">*</span>
                                </label>
                                <span id="title-counter" class="text-[11px] text-slate-400 font-mono">0 / 255 Karakter</span>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                maxlength="255" placeholder="Contoh: Cara Mudah Pemesanan"
                                oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Gunakan judul yang singkat, padat, dan jelas.
                            </p>
                        </div>

                        <!-- Deskripsi Rich Editor -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">
                                Deskripsi (Opsional)
                            </label>
                            <div class="rounded-xl overflow-hidden border border-gray-200 bg-white">
                                <div id="description-editor" class="h-32 text-sm"></div>
                            </div>
                            <input type="hidden" name="description" id="description" value="{{ old('description') }}">
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Berikan pengantar singkat mengenai cara pemesanan (opsional).
                            </p>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Tombol CTA -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="button_text" class="block text-xs font-bold text-slate-700 mb-2">
                                    Teks Tombol (CTA)
                                </label>
                                <input type="text" id="button_text" name="button_text" value="{{ old('button_text') }}"
                                    placeholder="Contoh: Pesan Sekarang" maxlength="255"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                <p class="text-[11px] text-slate-400 mt-1.5">
                                    Biarkan kosong jika tidak ingin menampilkan tombol.
                                </p>
                            </div>
                            <div>
                                <label for="button_link" class="block text-xs font-bold text-slate-700 mb-2">
                                    Tautan Tombol (Link)
                                </label>
                                <input type="text" id="button_link" name="button_link" value="{{ old('button_link') }}"
                                    placeholder="Contoh: https://wa.me/6281234567890" maxlength="255"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repeater Langkah (Steps) -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
                    <div class="border-b border-gray-100 bg-gray-50/50 px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">Daftar Langkah (Steps)</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Urutan ditentukan dari atas ke bawah</p>
                            </div>
                        </div>
                        <button type="button" id="add-step-btn"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-emerald-200 text-emerald-600 hover:bg-emerald-50 text-[11px] font-bold rounded-lg shadow-sm transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Tambah Langkah
                        </button>
                    </div>

                    <div class="p-5">
                        <div id="steps-container" class="space-y-4">
                            @php
                                $oldSteps = old('steps', []);
                            @endphp

                            @if (count($oldSteps) > 0)
                                @foreach ($oldSteps as $idx => $step)
                                    <!-- Step Item -->
                                    <div class="step-item group relative bg-gray-50/50 border border-gray-200 rounded-xl p-4 transition-all hover:border-emerald-300 hover:shadow-xs"
                                        data-index="{{ $idx }}">
                                        <!-- Drag handle & Remove -->
                                        <div class="absolute -left-2.5 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity cursor-move bg-white border border-gray-200 text-gray-400 p-1 rounded shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                            </svg>
                                        </div>

                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center gap-2">
                                                <span class="step-number w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold">
                                                    {{ $idx + 1 }}
                                                </span>
                                                <h4 class="text-xs font-bold text-slate-700">Langkah Pemesanan</h4>
                                            </div>
                                            <button type="button" onclick="removeStep(this)"
                                                class="text-rose-400 hover:text-rose-600 hover:bg-rose-50 p-1 rounded-md transition-colors"
                                                title="Hapus Langkah">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="space-y-4">
                                            <!-- Judul Step -->
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                    Judul Langkah <span class="text-rose-500">*</span>
                                                </label>
                                                <input type="text" name="steps[{{ $idx }}][title]"
                                                    value="{{ $step['title'] ?? '' }}" required maxlength="255"
                                                    placeholder="Contoh: Hubungi Admin"
                                                    class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                            </div>

                                            <!-- Deskripsi Step -->
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                    Deskripsi Langkah <span class="text-rose-500">*</span>
                                                </label>
                                                <textarea name="steps[{{ $idx }}][description]" rows="2" required
                                                    placeholder="Jelaskan detail yang perlu dilakukan pada langkah ini..."
                                                    class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">{{ $step['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Placeholder jika kosong -->
                        <div id="empty-steps"
                            class="{{ count($oldSteps) > 0 ? 'hidden' : 'flex' }} flex-col items-center justify-center py-10 px-4 text-center border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-700">Belum Ada Langkah</h4>
                            <p class="text-[11px] text-slate-500 mt-1 max-w-xs mx-auto">Klik tombol "Tambah Langkah" di atas
                                untuk mulai menambahkan panduan pemesanan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Status & Aksi -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4 sticky top-24">
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
                                <p class="text-[11px] text-emerald-700/90 mt-0.5">Sistem memastikan hanya 1 section Cara Pesan
                                    yang aktif. Saat section ini dipublikasikan, section lama yang sedang aktif otomatis
                                    dijadikan <strong>Draft</strong>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <span class="text-slate-600">Belum ada histori</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 pt-1">
                            <span>Status Publikasi:</span>
                            <a href="{{ url('/api/v1/how-to-orders') }}" target="_blank"
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

                    <div class="pt-5 border-t border-gray-100 space-y-3">
                        <button type="button" onclick="submitWithAction('publish')"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan & Publikasikan
                        </button>
                        <button type="button" onclick="submitWithAction('draft')"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Simpan sebagai Draft
                        </button>
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
            <a href="{{ route('admin.how-to-orders.index') }}"
                class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Batalkan & Kembali
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // ─── QUILL EDITOR INIT ──────────────────────────────────────────
        const quill = new Quill('#description-editor', {
            theme: 'snow',
            placeholder: 'Tuliskan deskripsi singkat di sini...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        // Set old value to quill
        const oldDesc = document.getElementById('description').value;
        if (oldDesc) {
            quill.clipboard.dangerouslyPasteHTML(oldDesc);
        }

        // ─── FORM SUBMIT ────────────────────────────────────────────────
        function submitWithAction(action) {
            document.getElementById('formAction').value = action;
            document.getElementById('description').value = quill.root.innerHTML;
            
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
            
            document.getElementById('howToOrderForm').submit();
        }

        function toggleStatusBadge(elem) {
            const badge = document.getElementById('status-badge');
            const formAction = document.getElementById('formAction');
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

        // ─── REPEATER STEPS ──────────────────────────────────────────────
        let stepIndex = {{ count($oldSteps) > 0 ? max(array_keys($oldSteps)) + 1 : 0 }};
        const stepsContainer = document.getElementById('steps-container');
        const emptySteps = document.getElementById('empty-steps');
        const addStepBtn = document.getElementById('add-step-btn');

        function updateStepNumbers() {
            const items = stepsContainer.querySelectorAll('.step-item');
            items.forEach((item, index) => {
                const numberEl = item.querySelector('.step-number');
                if(numberEl) numberEl.textContent = index + 1;
            });
            if(items.length > 0) {
                emptySteps.classList.add('hidden');
                emptySteps.classList.remove('flex');
            } else {
                emptySteps.classList.remove('hidden');
                emptySteps.classList.add('flex');
            }
        }

        function removeStep(button) {
            const item = button.closest('.step-item');
            item.style.opacity = '0';
            item.style.transform = 'scale(0.95)';
            setTimeout(() => {
                item.remove();
                updateStepNumbers();
            }, 200);
        }

        addStepBtn.addEventListener('click', () => {
            const template = `
                <div class="step-item group relative bg-gray-50/50 border border-gray-200 rounded-xl p-4 transition-all hover:border-emerald-300 hover:shadow-xs" data-index="${stepIndex}" style="opacity:0; transform:translateY(10px);">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="step-number w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold">
                                #
                            </span>
                            <h4 class="text-xs font-bold text-slate-700">Langkah Pemesanan</h4>
                        </div>
                        <button type="button" onclick="removeStep(this)" class="text-rose-400 hover:text-rose-600 hover:bg-rose-50 p-1 rounded-md transition-colors" title="Hapus Langkah">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Langkah <span class="text-rose-500">*</span></label>
                            <input type="text" name="steps[${stepIndex}][title]" required maxlength="255" placeholder="Contoh: Hubungi Admin" class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Langkah <span class="text-rose-500">*</span></label>
                            <textarea name="steps[${stepIndex}][description]" rows="2" required placeholder="Jelaskan detail yang perlu dilakukan pada langkah ini..." class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600"></textarea>
                        </div>
                    </div>
                </div>
            `;

            stepsContainer.insertAdjacentHTML('beforeend', template);
            const newItem = stepsContainer.lastElementChild;
            
            // Trigger reflow for animation
            void newItem.offsetWidth;
            newItem.style.opacity = '1';
            newItem.style.transform = 'translateY(0)';
            
            stepIndex++;
            updateStepNumbers();
        });
    </script>
@endpush
