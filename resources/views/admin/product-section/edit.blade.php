@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Landing Page</a>
    <span>/</span>
    <a href="{{ route('admin.product-sections.index') }}" class="text-slate-500 hover:text-slate-900">Produk</a>
    <span>/</span>
    <span class="text-slate-800">Edit Konten</span>
@endsection

@section('page_title', 'Kelola Produk')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.product-sections.index') }}"
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

@section('page_headline', 'Edit Konten Produk')
@section('page_subtitle', 'Kelola informasi judul, deskripsi utama, kontak WhatsApp, serta daftar katalog produk.')
@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $productSection->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-700 border border-slate-200/60' }}">
        <span class="w-2 h-2 rounded-full {{ $productSection->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
        Status: {{ $productSection->is_active ? 'Aktif di Landing Page' : 'Draft (Nonaktif)' }}
    </span>
@endsection

@section('content')
    <form id="product-section-form" action="{{ route('admin.product-sections.update', $productSection) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="action" id="form-action"
            value="{{ $productSection->is_active ? 'publish' : 'draft' }}">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI (8 Kolom): Konten Utama & Daftar products -->
            <div class="lg:col-span-8 space-y-6">

                <!-- product 1: Konten Utama & Deskripsi -->
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
                                <span id="title-counter"
                                    class="text-[11px] text-slate-400 font-mono">{{ strlen(old('title', $productSection->title)) }}
                                    / 255 Karakter</span>
                            </div>
                            <input type="text" id="title" name="title"
                                value="{{ old('title', $productSection->title) }}" required maxlength="255"
                                placeholder="Contoh: Tentang Program Pengabdian"
                                oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Gunakan judul yang jelas dan mencerminkan esensi program.
                            </p>
                        </div>

                        <!-- Nomor WhatsApp Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="whatsapp_number" class="block text-xs font-bold text-slate-700">
                                    Nomor WhatsApp
                                </label>
                            </div>
                            <input type="text" id="whatsapp_number" name="whatsapp_number"
                                value="{{ old('whatsapp_number', $productSection->whatsapp_number) }}"
                                placeholder="Contoh: 6281234567890"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Masukkan nomor WhatsApp lengkap dengan kode negara (contoh: 628...). Berlaku untuk semua
                                produk di section ini.
                            </p>
                        </div>

                        <!-- Deskripsi Rich Editor -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">
                                Deskripsi <span class="text-rose-500">*</span>
                            </label>
                            <x-form.rich-editor name="description" :value="old('description', $productSection->description)"
                                placeholder="Tulis latar belakang, visi, atau penjelasan rinci tentang program..." />
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Tulis latar belakang dan tujuan program secara lengkap.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- product 2: Daftar Products / Fitur (Multiple) -->
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
                                    <h3 class="text-base font-bold text-slate-900">Daftar Produk / Katalog</h3>
                                </div>
                                <p class="text-xs text-slate-500">Setiap produk berisi judul, harga, benefit keunggulan, deskripsi, detail spesifikasi, dan gambar produk.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <button type="button" onclick="collapseAllproducts()"
                                class="text-slate-500 hover:text-slate-900 underline">Collapse All</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="expandAllproducts()"
                                class="text-slate-500 hover:text-slate-900 underline">Expand All</button>
                        </div>
                    </div>

                    <!-- products Container (Repeater) -->
                    <div id="products-container" class="space-y-4">
                        @forelse($productSection->products as $idx => $product)
                            <div class="product-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                                data-index="{{ $idx }}">
                                <input type="hidden" name="products[{{ $idx }}][id]"
                                    value="{{ $product->id }}">
                                <input type="hidden" name="products[{{ $idx }}][remove_image]" value="0"
                                    class="product-remove-image-flag">

                                <!-- product Item Header -->
                                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                                    onclick="toggleproductAccordion(this)">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center product-badge-num">{{ $idx + 1 }}</span>
                                        <span
                                            class="product-header-title text-xs font-bold text-slate-800">{{ $product->name ?: 'Produk ' . ($idx + 1) }}</span>
                                        <span
                                            class="product-header-price text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100/80 {{ $product->price ? '' : 'hidden' }}">{{ $product->price }}</span>
                                    </div>
                                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                        <button type="button" onclick="removeproductItem(this)" title="Hapus Produk"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        <button type="button" onclick="toggleproductAccordion(this.parentElement)"
                                            class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 product-accordion-icon transform transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- product Item Body -->
                                <div class="product-body p-4 sm:p-5 space-y-4 bg-white">
                                    <!-- Grid Judul & Harga Produk -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <!-- Judul product -->
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                                Nama / Judul Produk <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="products[{{ $idx }}][name]"
                                                value="{{ old("products.{$idx}.name", $product->name) }}" required
                                                placeholder="Contoh: Sabun Batang Eco-Enzyme"
                                                oninput="updateproductHeaderTitle(this)"
                                                class="product-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>

                                        <!-- Harga product -->
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                                Harga Produk <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="products[{{ $idx }}][price]"
                                                value="{{ old("products.{$idx}.price", $product->price) }}" required
                                                placeholder="Contoh: Rp 15.000 / batang"
                                                oninput="updateproductHeaderPrice(this)"
                                                class="product-price-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                    </div>

                                    <!-- Benefit / Keunggulan Utama Produk -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Benefit / Keunggulan Utama <span
                                                class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                        </label>
                                        <input type="text" name="products[{{ $idx }}][benefit]"
                                            value="{{ old("products.{$idx}.benefit", $product->benefit) }}"
                                            placeholder="Contoh: Aman untuk kulit sensitif anak-anak & 100% alami"
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        <p class="text-[11px] text-slate-400 mt-1">
                                            Pernyataan manfaat/keunggulan utama produk yang langsung dirasakan oleh
                                            pelanggan.
                                        </p>
                                    </div>

                                    <!-- Deskripsi Singkat Produk -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Deskripsi Singkat Produk <span class="text-rose-500">*</span>
                                        </label>
                                        <textarea name="products[{{ $idx }}][description]" rows="2" required
                                            placeholder="Jelaskan secara ringkas karakteristik, bahan, atau kegunaan produk untuk kartu katalog..."
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old("products.{$idx}.description", $product->description) }}</textarea>
                                        <p class="text-[11px] text-slate-400 mt-1">
                                            Ringkasan singkat yang ditampilkan pada kartu katalog produk di landing page.
                                        </p>
                                    </div>

                                    <!-- Detail Produk -->
                                    <div>
                                        <div class="flex items-center justify-between mb-1.5">
                                            <label class="block text-xs font-semibold text-slate-700">
                                                Detail Produk (Spesifikasi & Rincian) <span
                                                    class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                            </label>
                                            <span class="text-[11px] text-slate-400">Rincian Lengkap Produk</span>
                                        </div>
                                        <textarea name="products[{{ $idx }}][detail]" rows="4"
                                            placeholder="Masukan detail produk anda"
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old("products.{$idx}.detail", $product->detail) }}</textarea>
                                        <p class="text-[11px] text-slate-400 mt-1">
                                            Cantumkan informasi detail seperti spesifikasi teknis, komposisi/bahan, netto, izin edar, aturan pakai, atau petunjuk penyimpanan.
                                        </p>
                                    </div>

                                    <!-- Gambar product Upload -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Gambar Produk <span
                                                class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                        </label>
                                        <div class="product-image-dropzone border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl p-4 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                                            onclick="this.querySelector('.product-image-input').click()">
                                            <input type="file" name="products[{{ $idx }}][image]"
                                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                                onchange="handleproductImagePreview(this)"
                                                class="product-image-input hidden">

                                            <!-- Preview Image -->
                                            <div
                                                class="product-preview-wrapper {{ $product->image ? '' : 'hidden' }} mb-2">
                                                <img src="{{ $product->image ? Storage::disk('public')->url($product->image) : '#' }}"
                                                    alt="Preview"
                                                    class="product-preview-img w-full max-h-48 object-cover rounded-lg border border-slate-200 shadow-2xs mb-2">
                                                <button type="button"
                                                    onclick="event.stopPropagation(); removeproductselectedImage(this)"
                                                    class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline">
                                                    Hapus / Ganti Gambar
                                                </button>
                                            </div>

                                            <!-- Dropzone Placeholder Content -->
                                            <div class="product-dropzone-content {{ $product->image ? 'hidden' : '' }}">
                                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-1.5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-xs font-medium text-slate-700">
                                                    Klik atau seret gambar untuk mengganti/menambah
                                                </p>
                                                <p class="text-[10px] text-slate-400 mt-0.5">
                                                    Format: PNG, JPG, WEBP • Maks 2MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="product-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                                data-index="0">
                                <input type="hidden" name="products[0][remove_image]" value="0"
                                    class="product-remove-image-flag">
                                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                                    onclick="toggleproductAccordion(this)">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center product-badge-num">1</span>
                                        <span class="product-header-title text-xs font-bold text-slate-800">Produk 1</span>
                                        <span class="product-header-price text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100/80 hidden"></span>
                                    </div>
                                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                        <button type="button" onclick="removeproductItem(this)" title="Hapus Produk"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        <button type="button" onclick="toggleproductAccordion(this.parentElement)"
                                            class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 product-accordion-icon transform transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-body p-4 sm:p-5 space-y-4 bg-white">
                                    <!-- Grid Judul & Harga Produk -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                                Nama / Judul Produk <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="products[0][name]" required
                                                placeholder="Contoh: Sabun Batang Eco-Enzyme"
                                                oninput="updateproductHeaderTitle(this)"
                                                class="product-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                                Harga Produk <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="products[0][price]" required
                                                placeholder="Contoh: Rp 15.000 / batang"
                                                oninput="updateproductHeaderPrice(this)"
                                                class="product-price-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                    </div>

                                    <!-- Benefit / Keunggulan Utama Produk -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Benefit / Keunggulan Utama <span
                                                class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                        </label>
                                        <input type="text" name="products[0][benefit]"
                                            placeholder="Contoh: Aman untuk kulit sensitif anak-anak & 100% alami"
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        <p class="text-[11px] text-slate-400 mt-1">
                                            Pernyataan manfaat/keunggulan utama produk yang langsung dirasakan oleh
                                            pelanggan.
                                        </p>
                                    </div>

                                    <!-- Deskripsi Singkat Produk -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Deskripsi Singkat Produk <span class="text-rose-500">*</span>
                                        </label>
                                        <textarea name="products[0][description]" rows="2" required
                                            placeholder="Jelaskan secara ringkas karakteristik, bahan, atau kegunaan produk untuk kartu katalog..."
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed"></textarea>
                                        <p class="text-[11px] text-slate-400 mt-1">
                                            Ringkasan singkat yang ditampilkan pada kartu katalog produk di landing page.
                                        </p>
                                    </div>

                                    <!-- Detail Produk -->
                                    <div>
                                        <div class="flex items-center justify-between mb-1.5">
                                            <label class="block text-xs font-semibold text-slate-700">
                                                Detail Produk (Spesifikasi & Rincian) <span
                                                    class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                            </label>
                                            <span class="text-[11px] text-slate-400">Rincian Lengkap Produk</span>
                                        </div>
                                        <textarea name="products[0][detail]" rows="4"
                                            placeholder="Masukan detail produk anda"
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old('products.0.detail') }}</textarea>
                                        <p class="text-[11px] text-slate-400 mt-1">
                                            Cantumkan informasi detail seperti spesifikasi teknis, komposisi/bahan, netto, izin edar, aturan pakai, atau petunjuk penyimpanan.
                                        </p>
                                    </div>

                                    <!-- Gambar product Upload -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Gambar Produk <span
                                                class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                        </label>
                                        <div class="product-image-dropzone border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl p-4 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                                            onclick="this.querySelector('.product-image-input').click()">
                                            <input type="file" name="products[0][image]"
                                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                                onchange="handleproductImagePreview(this)"
                                                class="product-image-input hidden">
                                            <div class="product-preview-wrapper hidden mb-2">
                                                <img src="#" alt="Preview"
                                                    class="product-preview-img w-full max-h-48 object-cover rounded-lg border border-slate-200 shadow-2xs mb-2">
                                                <button type="button"
                                                    onclick="event.stopPropagation(); removeproductselectedImage(this)"
                                                    class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline">Hapus
                                                    / Ganti Gambar</button>
                                            </div>
                                            <div class="product-dropzone-content">
                                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-1.5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-xs font-medium text-slate-700">Klik atau seret gambar untuk
                                                    produk ini</p>
                                                <p class="text-[10px] text-slate-400 mt-0.5">Format: PNG, JPG, WEBP • Maks
                                                    2MB</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Add Button -->
                    <button type="button" onclick="addNewproductItem()"
                        class="mt-5 w-full py-3 border-2 border-dashed border-emerald-300 hover:border-emerald-500 bg-emerald-50/30 hover:bg-emerald-50/80 rounded-xl text-xs font-bold text-emerald-800 hover:text-emerald-900 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Tambah Produk Baru</span>
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
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $productSection->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-slate-700' }}">
                                    {{ $productSection->is_active ? 'Aktif' : 'Draft' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tentukan apakah section ini langsung tampil atau
                                draft.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active_toggle" value="1"
                                {{ old('is_active', $productSection->is_active) ? 'checked' : '' }}
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
                                <p class="text-[11px] text-emerald-700/90 mt-0.5">Sistem memastikan hanya 1 product section
                                    yang aktif. Jika section ini diaktifkan, section lain otomatis dijadikan
                                    <strong>Draft</strong>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between items-start text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <div class="text-right">
                                <span class="text-slate-700 font-medium">{{ $productSection->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                <span class="text-[11px] text-slate-400 block">({{ $productSection->updated_at->diffForHumans() }})</span>
                            </div>
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
            <a href="{{ route('admin.product-sections.index') }}"
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

            const form = document.getElementById('product-section-form');
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

        // ─── products Repeater Scripts ──────────────────────────────────────────
        let productIndexCounter = {{ count($productSection->products) > 0 ? count($productSection->products) + 1 : 2 }};

        function updateproductBadgeCount() {
            const count = document.querySelectorAll('#products-container .product-item').length;
            const badge = document.getElementById('product-count-badge');
            if (badge) {
                badge.innerText = count + ' Produk';
            }
        }

        function reindexproducts() {
            const items = document.querySelectorAll('#products-container .product-item');
            items.forEach((item, idx) => {
                const badge = item.querySelector('.product-badge-num');
                if (badge) badge.innerText = idx + 1;

                const headerTitle = item.querySelector('.product-header-title');
                const titleInput = item.querySelector('.product-title-input');
                if (headerTitle) {
                    const val = titleInput && titleInput.value.trim() ? titleInput.value.trim() : 'Produk ' + (idx +
                        1);
                    headerTitle.innerText = val;
                }

                const headerPrice = item.querySelector('.product-header-price');
                const priceInput = item.querySelector('.product-price-input');
                if (headerPrice) {
                    if (priceInput && priceInput.value.trim()) {
                        headerPrice.innerText = priceInput.value.trim();
                        headerPrice.classList.remove('hidden');
                    } else {
                        headerPrice.innerText = '';
                        headerPrice.classList.add('hidden');
                    }
                }
            });
            updateproductBadgeCount();
        }

        function updateproductHeaderTitle(input) {
            const item = input.closest('.product-item');
            const headerTitle = item.querySelector('.product-header-title');
            const idx = Array.from(document.querySelectorAll('#products-container .product-item')).indexOf(item) + 1;
            if (headerTitle) {
                headerTitle.innerText = input.value.trim() ? input.value.trim() : 'Produk ' + idx;
            }
        }

        function updateproductHeaderPrice(input) {
            const item = input.closest('.product-item');
            const headerPrice = item.querySelector('.product-header-price');
            if (headerPrice) {
                if (input.value.trim()) {
                    headerPrice.innerText = input.value.trim();
                    headerPrice.classList.remove('hidden');
                } else {
                    headerPrice.innerText = '';
                    headerPrice.classList.add('hidden');
                }
            }
        }

        function toggleproductAccordion(trigger) {
            const item = trigger.closest('.product-item');
            const body = item.querySelector('.product-body');
            const icon = item.querySelector('.product-accordion-icon');

            if (body.classList.contains('hidden')) {
                body.classList.remove('hidden');
                if (icon) icon.classList.remove('-rotate-90');
            } else {
                body.classList.add('hidden');
                if (icon) icon.classList.add('-rotate-90');
            }
        }

        function collapseAllproducts() {
            document.querySelectorAll('#products-container .product-item').forEach(item => {
                item.querySelector('.product-body').classList.add('hidden');
                const icon = item.querySelector('.product-accordion-icon');
                if (icon) icon.classList.add('-rotate-90');
            });
        }

        function expandAllproducts() {
            document.querySelectorAll('#products-container .product-item').forEach(item => {
                item.querySelector('.product-body').classList.remove('hidden');
                const icon = item.querySelector('.product-accordion-icon');
                if (icon) icon.classList.remove('-rotate-90');
            });
        }

        function addNewproductItem() {
            const container = document.getElementById('products-container');
            const currentCount = container.querySelectorAll('.product-item').length;
            const newNum = currentCount + 1;
            const index = productIndexCounter++;

            const productHtml = `
            <div class="product-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs" data-index="${index}">
                <input type="hidden" name="products[${index}][remove_image]" value="0" class="product-remove-image-flag">
                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer" onclick="toggleproductAccordion(this)">
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center product-badge-num">${newNum}</span>
                        <span class="product-header-title text-xs font-bold text-slate-800">Produk ${newNum}</span>
                        <span class="product-header-price text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100/80 hidden"></span>
                    </div>
                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                        <button type="button" onclick="removeproductItem(this)" title="Hapus Produk" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="toggleproductAccordion(this.parentElement)" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4 product-accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="product-body p-4 sm:p-5 space-y-4 bg-white">
                    <!-- Grid Judul & Harga Produk -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Nama / Judul Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="products[${index}][name]"
                                   required
                                   placeholder="Contoh: Sabun Batang Eco-Enzyme"
                                   oninput="updateproductHeaderTitle(this)"
                                   class="product-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Harga Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="products[${index}][price]"
                                   required
                                   placeholder="Contoh: Rp 15.000 / batang"
                                   oninput="updateproductHeaderPrice(this)"
                                   class="product-price-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                    </div>

                    <!-- Benefit / Keunggulan Utama Produk -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Benefit / Keunggulan Utama <span class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                        </label>
                        <input type="text"
                               name="products[${index}][benefit]"
                               placeholder="Contoh: Aman untuk kulit sensitif anak-anak & 100% alami"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        <p class="text-[11px] text-slate-400 mt-1">
                            Pernyataan manfaat/keunggulan utama produk yang langsung dirasakan oleh pelanggan.
                        </p>
                    </div>

                    <!-- Deskripsi Singkat Produk -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Deskripsi Singkat Produk <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="products[${index}][description]"
                                  rows="2"
                                  required
                                  placeholder="Jelaskan secara ringkas karakteristik, bahan, atau kegunaan produk untuk kartu katalog..."
                                  class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed"></textarea>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Ringkasan singkat yang ditampilkan pada kartu katalog produk di landing page.
                        </p>
                    </div>

                    <!-- Detail Produk -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-semibold text-slate-700">
                                Detail Produk (Spesifikasi & Rincian) <span class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                            </label>
                            <span class="text-[11px] text-slate-400">Rincian Lengkap Produk</span>
                        </div>
                        <textarea name="products[${index}][detail]"
                                  rows="4"
                                  placeholder="Masukan detail produk anda"
                                  class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed"></textarea>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Cantumkan informasi detail seperti spesifikasi teknis, komposisi/bahan, netto, izin edar, aturan pakai, atau petunjuk penyimpanan.
                        </p>
                    </div>

                    <!-- Gambar Produk Upload -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Gambar Produk <span class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                        </label>
                        <div class="product-image-dropzone border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl p-4 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                             onclick="this.querySelector('.product-image-input').click()">
                            <input type="file"
                                   name="products[${index}][image]"
                                   accept="image/png,image/jpeg,image/jpg,image/webp"
                                   onchange="handleproductImagePreview(this)"
                                   class="product-image-input hidden">
                            <div class="product-preview-wrapper hidden mb-2">
                                <img src="#" alt="Preview" class="product-preview-img w-full max-h-48 object-cover rounded-lg border border-slate-200 shadow-2xs mb-2">
                                <button type="button" onclick="event.stopPropagation(); removeproductselectedImage(this)" class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline">
                                    Hapus / Ganti Gambar
                                </button>
                            </div>
                            <div class="product-dropzone-content">
                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs font-medium text-slate-700">Klik atau seret gambar untuk produk ini</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Format: PNG, JPG, WEBP • Maks 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', productHtml);
            reindexproducts();

            // Scroll smoothly to newly added product
            const newproduct = container.lastElementChild;
            newproduct.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function removeproductItem(btn) {
            const container = document.getElementById('products-container');
            const items = container.querySelectorAll('.product-item');
            if (items.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Minimal harus ada 1 produk di dalam Product Section.',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }

            const item = btn.closest('.product-item');
            item.style.opacity = '0';
            item.style.transform = 'scale(0.95)';
            setTimeout(() => {
                item.remove();
                reindexproducts();
            }, 150);
        }

        // ─── Image Preview Handlers ──────────────────────────────────────────
        function handleproductImagePreview(input) {
            const file = input.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Maksimal ukuran gambar product adalah 2MB.',
                    confirmButtonColor: '#e11d48'
                });
                input.value = '';
                return;
            }

            const dropzone = input.closest('.product-image-dropzone');
            const previewWrapper = dropzone.querySelector('.product-preview-wrapper');
            const previewImg = dropzone.querySelector('.product-preview-img');
            const dropzoneContent = dropzone.querySelector('.product-dropzone-content');
            const removeFlag = dropzone.closest('.product-item').querySelector('.product-remove-image-flag');

            if (removeFlag) removeFlag.value = '0';

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrapper.classList.remove('hidden');
                dropzoneContent.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        function removeproductselectedImage(btn) {
            const dropzone = btn.closest('.product-image-dropzone');
            const input = dropzone.querySelector('.product-image-input');
            const previewWrapper = dropzone.querySelector('.product-preview-wrapper');
            const previewImg = dropzone.querySelector('.product-preview-img');
            const dropzoneContent = dropzone.querySelector('.product-dropzone-content');
            const removeFlag = dropzone.closest('.product-item').querySelector('.product-remove-image-flag');

            if (removeFlag) removeFlag.value = '1';
            input.value = '';
            previewImg.src = '#';
            previewWrapper.classList.add('hidden');
            dropzoneContent.classList.remove('hidden');
        }
    </script>
@endpush
