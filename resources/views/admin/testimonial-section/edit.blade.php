@extends('layouts.admin')

@section('title', 'Edit Section Testimonial')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Landing Page</a>
    <span>/</span>
    <a href="{{ route('admin.testimonial-sections.index') }}" class="text-slate-500 hover:text-slate-900">Testimonial</a>
    <span>/</span>
    <span class="text-slate-800">Edit Konten</span>
@endsection

@section('page_title', 'Edit Section Testimonial')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.testimonial-sections.index') }}"
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
@section('page_headline', 'Edit Testimonial Section')
@section('page_subtitle', 'Ubah judul utama, statistik dampak, dan daftar ulasan pelanggan.')
@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $testimonialSection->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-700 border border-slate-200/60' }}">
        <span class="w-2 h-2 rounded-full {{ $testimonialSection->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
        Status: {{ $testimonialSection->is_active ? 'Aktif di Landing Page' : 'Draft (Nonaktif)' }}
    </span>
@endsection

@section('content')
    <form action="{{ route('admin.testimonial-sections.update', $testimonialSection) }}" method="POST" id="testimonialForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="action" id="formAction" value="{{ $testimonialSection->is_active ? 'publish' : 'draft' }}">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <div class="lg:col-span-8 space-y-6">
                <!-- Data Utama Section -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Konten Utama Section</h3>
                            <p class="text-xs text-slate-500">Kelola judul section.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Judul Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="title" class="block text-xs font-bold text-slate-700">
                                    Judul <span class="text-rose-500">*</span>
                                </label>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title', $testimonialSection->title) }}" required
                                maxlength="255" placeholder="Contoh: Mereka Sudah Merasakannya."
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Repeater Statistics -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden p-6">
                    <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">Statistik Dampak</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Tiga kartu di bagian atas testimoni.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <button type="button" onclick="collapseAll('.stat-item')"
                                class="text-slate-500 hover:text-slate-900 underline">Collapse All</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="expandAll('.stat-item')"
                                class="text-slate-500 hover:text-slate-900 underline">Expand All</button>
                        </div>
                    </div>

                    <div id="stats-container" class="space-y-4">
                        @php 
                            // Try to get from old input, else fallback to database
                            $oldStats = old('statistics');
                            if($oldStats === null) {
                                $oldStats = $testimonialSection->statistics->toArray();
                            }
                        @endphp
                        @if (count($oldStats) > 0)
                            @foreach ($oldStats as $idx => $stat)
                                <div class="stat-item p-4 rounded-xl border border-slate-200 bg-slate-50/40 relative">
                                    <input type="hidden" name="statistics[{{ $idx }}][id]" value="{{ $stat['id'] ?? '' }}">
                                    <div class="flex items-center justify-between mb-4 border-b border-slate-200/50 pb-2 cursor-pointer" onclick="toggleAccordion(this)">
                                        <div class="font-bold text-xs text-slate-700 stat-header-title">{{ $stat['value'] ?? 'Item Statistik' }}</div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" onclick="event.stopPropagation(); this.closest('.stat-item').remove()" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <button type="button" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors accordion-icon-container">
                                                <svg class="w-4 h-4 accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="space-y-4 accordion-body bg-white p-3 rounded-lg border border-slate-100">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai (Angka/Teks Singkat) <span class="text-rose-500">*</span></label>
                                            <input type="text" name="statistics[{{ $idx }}][value]" value="{{ $stat['value'] ?? '' }}" required class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: 350+ kg" oninput="this.closest('.stat-item').querySelector('.stat-header-title').textContent = this.value || 'Item Statistik'">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi <span class="text-rose-500">*</span></label>
                                            <textarea name="statistics[{{ $idx }}][description]" rows="2" required class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: Limbah kulit buah dapur berhasil diolah">{{ $stat['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <button type="button" id="add-stat-btn"
                        class="mt-5 w-full py-3 border-2 border-dashed border-emerald-300 hover:border-emerald-500 bg-emerald-50/30 hover:bg-emerald-50/80 rounded-xl text-xs font-bold text-emerald-800 hover:text-emerald-900 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        <span>Tambah Statistik</span>
                    </button>
                </div>

                <!-- Repeater Testimonials -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden p-6">
                    <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">Daftar Testimoni</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Ulasan dan cerita pelanggan.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <button type="button" onclick="collapseAll('.testimonial-item')"
                                class="text-slate-500 hover:text-slate-900 underline">Collapse All</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="expandAll('.testimonial-item')"
                                class="text-slate-500 hover:text-slate-900 underline">Expand All</button>
                        </div>
                    </div>

                    <div id="testimonials-container" class="space-y-4">
                        @php 
                            $oldTestimonials = old('testimonials');
                            if($oldTestimonials === null) {
                                $oldTestimonials = $testimonialSection->testimonials->toArray();
                            }
                        @endphp
                        @if (count($oldTestimonials) > 0)
                            @foreach ($oldTestimonials as $idx => $item)
                                <div class="testimonial-item p-4 rounded-xl border border-slate-200 bg-slate-50/40 relative">
                                    <input type="hidden" name="testimonials[{{ $idx }}][id]" value="{{ $item['id'] ?? '' }}">
                                    <div class="flex items-center justify-between mb-4 border-b border-slate-200/50 pb-2 cursor-pointer" onclick="toggleAccordion(this)">
                                        <div class="font-bold text-xs text-slate-700 testimonial-header-title">{{ $item['name'] ?? 'Item Testimoni' }}</div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" onclick="event.stopPropagation(); this.closest('.testimonial-item').remove()" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <button type="button" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors accordion-icon-container">
                                                <svg class="w-4 h-4 accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="space-y-4 accordion-body bg-white p-3 rounded-lg border border-slate-100">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kutipan / Ulasan <span class="text-rose-500">*</span></label>
                                            <textarea name="testimonials[{{ $idx }}][quote]" rows="3" required class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: Aroma lantainya segar alami tanpa bikin pusing...">{{ $item['quote'] ?? '' }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama <span class="text-rose-500">*</span></label>
                                                <input type="text" name="testimonials[{{ $idx }}][name]" value="{{ $item['name'] ?? '' }}" required class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: Ibu Endang Rahayu" oninput="this.closest('.testimonial-item').querySelector('.testimonial-header-title').textContent = this.value || 'Item Testimoni'">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Sub-judul / Lokasi (Opsional)</label>
                                                <input type="text" name="testimonials[{{ $idx }}][subtitle]" value="{{ $item['subtitle'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: Cilacap">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <button type="button" id="add-testimonial-btn"
                        class="mt-5 w-full py-3 border-2 border-dashed border-blue-300 hover:border-blue-500 bg-blue-50/30 hover:bg-blue-50/80 rounded-xl text-xs font-bold text-blue-800 hover:text-blue-900 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        <span>Tambah Testimoni</span>
                    </button>
                </div>
            </div>

            <!-- Kolom Kanan: Status & Aksi -->
            <div class="lg:col-span-4 space-y-6">
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
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $testimonialSection->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-slate-700' }}">
                                    {{ $testimonialSection->is_active ? 'Aktif' : 'Draft' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tentukan apakah section ini langsung tampil atau
                                draft.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active_toggle" value="1" {{ old('is_active', $testimonialSection->is_active) ? 'checked' : '' }}
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
                                <p class="text-[11px] text-emerald-700/90 mt-0.5">Sistem memastikan hanya 1 section Testimonial yang aktif secara bersamaan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <span class="text-slate-600">{{ $testimonialSection->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 pt-1">
                            <span>Status Publikasi:</span>
                            <a href="{{ url('/api/v1/testimonials') }}" target="_blank"
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

        <!-- Tombol Aksi Khusus Layar Kecil (Mobile) -->
        <div class="sm:hidden mt-6 bg-white rounded-2xl border border-gray-200/80 shadow-xs p-4 space-y-3">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="submitWithAction('draft')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs transition-all cursor-pointer">
                    <span>Simpan Draft</span>
                </button>
                <button type="button" onclick="submitWithAction('publish')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                    <span>Publikasikan</span>
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function submitWithAction(action) {
            document.getElementById('formAction').value = action;
            
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
            
            document.getElementById('testimonialForm').submit();
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

        // ─── ACCORDION LOGIC ─────────────────────────────────────────────
        function toggleAccordion(headerElem) {
            const item = headerElem.closest('.stat-item') || headerElem.closest('.testimonial-item');
            const body = item.querySelector('.accordion-body');
            const icon = item.querySelector('.accordion-icon');
            
            if (body.style.display === 'none') {
                body.style.display = 'block';
                icon.style.transform = 'rotate(0deg)';
            } else {
                body.style.display = 'none';
                icon.style.transform = 'rotate(180deg)';
            }
        }

        function collapseAll(selector) {
            document.querySelectorAll(selector).forEach(item => {
                const body = item.querySelector('.accordion-body');
                const icon = item.querySelector('.accordion-icon');
                if (body && icon) {
                    body.style.display = 'none';
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        }

        function expandAll(selector) {
            document.querySelectorAll(selector).forEach(item => {
                const body = item.querySelector('.accordion-body');
                const icon = item.querySelector('.accordion-icon');
                if (body && icon) {
                    body.style.display = 'block';
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        }

        // ─── REPEATER STATS ──────────────────────────────────────────────
        let statIndex = {{ count($oldStats) > 0 ? max(array_keys($oldStats)) + 1 : 0 }};
        const statsContainer = document.getElementById('stats-container');
        const addStatBtn = document.getElementById('add-stat-btn');

        addStatBtn.addEventListener('click', () => {
            const template = `
                <div class="stat-item p-4 rounded-xl border border-slate-200 bg-slate-50/40 relative">
                    <div class="flex items-center justify-between mb-4 border-b border-slate-200/50 pb-2 cursor-pointer" onclick="toggleAccordion(this)">
                        <div class="font-bold text-xs text-slate-700 stat-header-title">Statistik Baru</div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="event.stopPropagation(); this.closest('.stat-item').remove()" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            <button type="button" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors accordion-icon-container">
                                <svg class="w-4 h-4 accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-4 accordion-body bg-white p-3 rounded-lg border border-slate-100">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai (Angka/Teks Singkat) <span class="text-rose-500">*</span></label>
                            <input type="text" name="statistics[${statIndex}][value]" required class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: 350+ kg" oninput="this.closest('.stat-item').querySelector('.stat-header-title').textContent = this.value || 'Statistik Baru'">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi <span class="text-rose-500">*</span></label>
                            <textarea name="statistics[${statIndex}][description]" rows="2" required class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: Limbah kulit buah dapur berhasil diolah"></textarea>
                        </div>
                    </div>
                </div>
            `;
            statsContainer.insertAdjacentHTML('beforeend', template);
            statIndex++;
        });

        // ─── REPEATER TESTIMONIALS ───────────────────────────────────────
        let testimonialIndex = {{ count($oldTestimonials) > 0 ? max(array_keys($oldTestimonials)) + 1 : 0 }};
        const testimonialsContainer = document.getElementById('testimonials-container');
        const addTestimonialBtn = document.getElementById('add-testimonial-btn');

        addTestimonialBtn.addEventListener('click', () => {
            const template = `
                <div class="testimonial-item p-4 rounded-xl border border-slate-200 bg-slate-50/40 relative">
                    <div class="flex items-center justify-between mb-4 border-b border-slate-200/50 pb-2 cursor-pointer" onclick="toggleAccordion(this)">
                        <div class="font-bold text-xs text-slate-700 testimonial-header-title">Testimoni Baru</div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="event.stopPropagation(); this.closest('.testimonial-item').remove()" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            <button type="button" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors accordion-icon-container">
                                <svg class="w-4 h-4 accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-4 accordion-body bg-white p-3 rounded-lg border border-slate-100">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kutipan / Ulasan <span class="text-rose-500">*</span></label>
                            <textarea name="testimonials[${testimonialIndex}][quote]" rows="3" required class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: Aroma lantainya segar alami tanpa bikin pusing..."></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama <span class="text-rose-500">*</span></label>
                                <input type="text" name="testimonials[${testimonialIndex}][name]" required class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: Ibu Endang Rahayu" oninput="this.closest('.testimonial-item').querySelector('.testimonial-header-title').textContent = this.value || 'Testimoni Baru'">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Sub-judul / Lokasi (Opsional)</label>
                                <input type="text" name="testimonials[${testimonialIndex}][subtitle]" class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" placeholder="Cth: Cilacap">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            testimonialsContainer.insertAdjacentHTML('beforeend', template);
            testimonialIndex++;
        });

    </script>
@endpush
