# 🎓 Pengabdian Dosen — Landing Page CMS & API Backend

> Sistem backend **Content Management System (CMS)** dan **RESTful API** untuk landing page, dibangun sebagai bagian dari proyek **Pengabdian Dosen**. Aplikasi ini menyediakan Admin Panel berbasis web untuk mengelola konten landing page secara dinamis, serta API publik yang dapat dikonsumsi oleh frontend (mobile/web).

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Prasyarat](#-prasyarat)
- [Instalasi & Setup](#-instalasi--setup)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Struktur Proyek](#-struktur-proyek)
- [API Endpoints](#-api-endpoints)
- [Admin Panel](#-admin-panel)
- [Database Schema](#-database-schema)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 🛠️ Admin Panel (Web)
- **Dashboard** — Ringkasan statistik konten (total section, section aktif, dll.)
- **Home Section** — Kelola hero/banner landing page (judul, deskripsi, gambar, tombol CTA)
- **About Section** — Kelola halaman tentang beserta poin-poin dan kartu informasi
- **Product Section** — Kelola katalog produk dengan gambar, harga, dan integrasi WhatsApp
- **How to Order** — Kelola langkah-langkah cara pemesanan
- **Testimonial** — Kelola testimoni pelanggan beserta statistik
- **Toggle Status** — Aktifkan/nonaktifkan section tanpa menghapus data
- **Rich Text Editor** — Editor teks kaya untuk deskripsi konten
- **Image Upload** — Upload dan manajemen gambar untuk setiap section
- **Authentication** — Sistem login/logout untuk admin

### 🔌 RESTful API (v1)
- Endpoint publik (tanpa autentikasi) untuk dikonsumsi frontend
- Response dalam format JSON dengan API Resource
- Hanya menampilkan section yang aktif (`is_active = true`)
- Versioned API (`/api/v1/...`)

---

## 🧰 Tech Stack

### Backend
| Teknologi | Versi | Kegunaan |
|-----------|-------|----------|
| **PHP** | ^8.3 | Bahasa pemrograman utama |
| **Laravel** | ^13.17 | Framework backend utama |
| **Laravel Sanctum** | ^4.0 | API token authentication |
| **Laravel Tinker** | ^3.0 | REPL interaktif untuk debugging |
| **PostgreSQL** | - | Database relasional utama |

### Frontend (Admin Panel)
| Teknologi | Versi | Kegunaan |
|-----------|-------|----------|
| **Blade Templates** | - | Template engine Laravel untuk UI admin |
| **Tailwind CSS** | ^4.0 | Utility-first CSS framework |
| **Vite** | ^8.0 | Build tool & dev server untuk asset |
| **Instrument Sans** | - | Font utama via Bunny Fonts |

### Development Tools
| Teknologi | Versi | Kegunaan |
|-----------|-------|----------|
| **Composer** | - | PHP dependency manager |
| **NPM** | - | Node.js package manager |
| **Laravel Pint** | ^1.27 | PHP code style fixer (PSR-12) |
| **Laravel Pail** | ^1.2.5 | Real-time log viewer |
| **PHPUnit** | ^12.5 | Testing framework |
| **Faker** | ^1.23 | Dummy data generator untuk testing/seeder |
| **Mockery** | ^1.6 | Mocking framework untuk unit test |

---

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────┐
│              Frontend (Mobile/Web)               │
│         (Mengkonsumsi RESTful API)               │
└──────────────────────┬──────────────────────────┘
                       │ HTTP GET (JSON)
                       ▼
┌─────────────────────────────────────────────────┐
│              RESTful API (v1)                    │
│   /api/v1/home, /api/v1/about, /api/v1/products │
│   /api/v1/how-to-orders, /api/v1/testimonials   │
│              (Publik, Read-Only)                 │
└──────────────────────┬──────────────────────────┘
                       │
┌──────────────────────┴──────────────────────────┐
│              Laravel Application                 │
│  ┌─────────┐  ┌──────────┐  ┌────────────────┐  │
│  │ Models  │  │ Resources│  │  Controllers   │  │
│  │ (ORM)   │  │ (JSON)   │  │ (Admin + API)  │  │
│  └────┬────┘  └──────────┘  └────────────────┘  │
│       │                                          │
│  ┌────▼──────────────────────────────────────┐   │
│  │        Admin Panel (Blade + Tailwind)     │   │
│  │    /admin/dashboard, /admin/home-sections │   │
│  │    CRUD + Toggle Status + Image Upload    │   │
│  └───────────────────────────────────────────┘   │
└──────────────────────┬──────────────────────────┘
                       │
              ┌────────▼────────┐
              │   PostgreSQL    │
              │   Database      │
              └─────────────────┘
```

---

## 📌 Prasyarat

Pastikan software berikut sudah terinstall di sistem Anda:

| Software | Versi Minimum | Link Download |
|----------|---------------|---------------|
| **PHP** | 8.3+ | [php.net](https://www.php.net/downloads) |
| **Composer** | 2.x | [getcomposer.org](https://getcomposer.org/download/) |
| **Node.js** | 18+ | [nodejs.org](https://nodejs.org/) |
| **NPM** | 9+ | (termasuk dalam Node.js) |
| **PostgreSQL** | 14+ | [postgresql.org](https://www.postgresql.org/download/) |
| **Git** | 2.x | [git-scm.com](https://git-scm.com/downloads) |

### Ekstensi PHP yang Diperlukan

```
php-pgsql, php-mbstring, php-xml, php-curl, php-zip, php-gd, php-bcmath
```



## 🚀 Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/afiffaizin/be-landing-page.git
cd be-landing-page
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Node.js

```bash
npm install
```

### 4. Konfigurasi Environment

```bash
# Salin file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=pengabdian_dosen
DB_USERNAME=postgres
DB_PASSWORD=your_password_here
```

> **📝 Catatan:** Pastikan database `pengabdian_dosen` sudah dibuat di PostgreSQL sebelum menjalankan migrasi.

```sql
-- Buat database di psql
CREATE DATABASE pengabdian_dosen;
```

### 6. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 7. Jalankan Seeder (Data Awal)

```bash
php artisan db:seed
```

Seeder akan membuat:
- **Admin user** — `admin@admin.com` / `password`
- **Home Section** — Data contoh untuk hero section
- **About Section** — Data contoh untuk halaman tentang

### 8. Buat Symbolic Link untuk Storage

```bash
php artisan storage:link
```

> Ini diperlukan agar file yang diupload (gambar, dll.) dapat diakses secara publik melalui URL.

### 9. Build Asset Frontend

```bash
# Untuk production
npm run build

# ATAU untuk development (dengan hot-reload)
npm run dev
```

---

## ▶️ Menjalankan Aplikasi

### Development Mode

Jalankan kedua perintah ini di terminal terpisah:

```bash
# Terminal 1 — Laravel development server
php artisan serve

# Terminal 2 — Vite dev server (hot-reload untuk CSS/JS)
npm run dev
```

Atau gunakan **composer script** bawaan:

```bash
composer dev
```

Aplikasi akan berjalan di:
- **Admin Panel**: [http://localhost:8000/admin](http://localhost:8000/admin)
- **API Base URL**: [http://localhost:8000/api/v1](http://localhost:8000/api/v1)

### Login Admin

| Field | Value |
|-------|-------|
| **Email** | `admin@admin.com` |
| **Password** | `password` |

---


## 🔌 API Endpoints

Semua endpoint API bersifat **publik** (tidak memerlukan autentikasi) dan **read-only** (GET).

**Base URL:** `http://localhost:8000/api/v1`

### Home Section

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/v1/home` | Daftar semua home section aktif |
| `GET` | `/v1/home/{id}` | Detail satu home section |

### About Section

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/v1/about` | Daftar semua about section aktif (termasuk kartu) |
| `GET` | `/v1/about/{id}` | Detail satu about section |

### Product Section

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/v1/products` | Daftar semua product section aktif beserta produknya |
| `GET` | `/v1/products/{id}` | Detail satu product section |

### How to Order

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/v1/how-to-orders` | Daftar cara pemesanan beserta langkah-langkahnya |

### Testimonial

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/v1/testimonials` | Daftar testimonial beserta statistik |

### Contoh Response

```json
// GET /api/v1/home
{
  "data": [
    {
      "id": 1,
      "title": "Judul Hero Section",
      "description": "Deskripsi landing page...",
      "image_url": "http://localhost:8000/storage/home-sections/image.jpg",
      "button_one_text": "Pesan Sekarang",
      "button_one_link": "https://wa.me/628xxx",
      "button_two_text": "Pelajari Lebih Lanjut",
      "button_two_link": "#about",
      "is_active": true
    }
  ]
}
```

---

## 🖥️ Admin Panel

Admin panel dapat diakses melalui `/admin` setelah login. Fitur-fitur yang tersedia:

| Menu | Route | Deskripsi |
|------|-------|-----------|
| **Dashboard** | `/admin/dashboard` | Ringkasan statistik konten |
| **Home Sections** | `/admin/home-sections` | CRUD hero/banner landing page |
| **About Sections** | `/admin/about-sections` | CRUD halaman tentang + kartu |
| **Product Sections** | `/admin/product-sections` | CRUD produk + integrasi WhatsApp |
| **How to Order** | `/admin/how-to-orders` | CRUD langkah cara pemesanan |
| **Testimonials** | `/admin/testimonial-sections` | CRUD testimoni + statistik |

### Fitur CRUD
Setiap section mendukung operasi:
- ➕ **Create** — Tambah section baru dengan form lengkap
- 📝 **Edit** — Ubah konten dan gambar section
- 🗑️ **Delete** — Hapus section beserta relasi
- 🔄 **Toggle Status** — Aktifkan/nonaktifkan section via PATCH request

---

## 🧪 Testing

### Menjalankan Test

```bash
# Semua test
php artisan test

# Atau menggunakan PHPUnit langsung
./vendor/bin/phpunit

# Test dengan coverage
php artisan test --coverage

# Test suite tertentu
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

### Konfigurasi Testing

Testing menggunakan konfigurasi terpisah yang didefinisikan di [`phpunit.xml`](phpunit.xml):
- Environment: `testing`
- Cache: `array` (in-memory)
- Session: `array`
- Mail: `array`
- Queue: `sync`

---

## 🚢 Deployment

### Production Build

```bash
# Install dependencies (tanpa dev)
composer install --no-dev --optimize-autoloader

# Build frontend assets
npm run build

# Cache konfigurasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi
php artisan migrate --force
```

### Environment Production

Pastikan mengubah variabel berikut di `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-secure-password
```

---

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).

---

<p align="center">
  Dibangun dengan ❤️ menggunakan <a href="https://laravel.com">Laravel</a> untuk proyek <strong>Pengabdian Dosen</strong>
</p>
