# Galeri Sekolah Elfa

Aplikasi galeri foto sekolah yang dibangun dengan Laravel dan API. Aplikasi ini memungkinkan pengelolaan foto-foto kegiatan sekolah dengan berbagai kategori seperti akademik, ekstrakurikuler, acara, dan umum.

## Fitur

- 📸 **Manajemen Galeri**: Upload, edit, dan hapus foto galeri
- 🏷️ **Kategori**: Organisasi foto berdasarkan kategori (Akademik, Ekstrakurikuler, Acara, Umum)
- 🔍 **Pencarian**: Fitur pencarian foto berdasarkan judul
- 📱 **Responsive Design**: Interface yang responsif untuk desktop dan mobile
- 🎨 **Modern UI**: Desain modern dengan Bootstrap 5 dan Font Awesome
- 📄 **Pagination**: Navigasi halaman untuk galeri yang besar
- 🖼️ **Modal Preview**: Preview foto dalam modal yang elegan

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Database**: SQLite
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **UI Framework**: Bootstrap 5
- **Icons**: Font Awesome 6
- **API**: RESTful API

## Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd galeri-sekolah-Elfa
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Setup storage link**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan server**
   ```bash
   php artisan serve
   ```

## API Endpoints

### Gallery API

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/galleries` | Mendapatkan daftar galeri dengan pagination |
| GET | `/api/galleries/{id}` | Mendapatkan detail galeri |
| POST | `/api/galleries` | Menambah galeri baru |
| PUT | `/api/galleries/{id}` | Update galeri |
| DELETE | `/api/galleries/{id}` | Hapus galeri |
| GET | `/api/galleries/categories` | Mendapatkan daftar kategori |

### Query Parameters untuk GET /api/galleries

- `page`: Nomor halaman (default: 1)
- `category`: Filter berdasarkan kategori (academic, extracurricular, event, general, all)
- `search`: Pencarian berdasarkan judul

### Contoh Request

**GET /api/galleries?page=1&category=academic&search=upacara**

**POST /api/galleries** (multipart/form-data)
```
title: "Judul Foto"
description: "Deskripsi foto"
category: "academic"
image: [file]
```

## Struktur Database

### Table: galleries

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| title | varchar(255) | Judul foto |
| description | text | Deskripsi foto (nullable) |
| image_path | varchar(255) | Path atau URL gambar |
| category | varchar(255) | Kategori foto |
| is_active | boolean | Status aktif foto |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

## Kategori Foto

- **academic**: Kegiatan akademik (upacara, pembelajaran, dll)
- **extracurricular**: Ekstrakurikuler (pramuka, basket, dll)
- **event**: Acara khusus (pentas seni, perayaan, dll)
- **general**: Umum (fasilitas sekolah, dll)

## Penggunaan

1. **Akses Aplikasi**: Buka `http://localhost:8000` di browser
2. **Lihat Galeri**: Foto akan ditampilkan dalam grid layout
3. **Filter**: Gunakan dropdown kategori untuk memfilter foto
4. **Pencarian**: Ketik kata kunci di search box
5. **Tambah Foto**: Klik tombol "+" untuk menambah foto baru
6. **Preview**: Klik foto untuk melihat detail dalam modal

## File Upload

- Format yang didukung: JPEG, PNG, JPG, GIF
- Ukuran maksimal: 2MB
- File disimpan di `storage/app/public/gallery/`
- URL akses: `storage/gallery/filename.jpg`

## Development

### Menambah Kategori Baru

1. Update array kategori di `GalleryController@categories()`
2. Update validation rules di controller
3. Update frontend JavaScript untuk menampilkan kategori baru

### Customization

- **Styling**: Edit file `resources/views/gallery/index.blade.php`
- **API Response**: Modifikasi `GalleryController`
- **Database**: Tambah migration untuk field baru

## License

MIT License - bebas digunakan untuk keperluan pendidikan dan komersial.

## Kontribusi

Silakan buat issue atau pull request untuk perbaikan dan fitur baru.

---

**Dibuat dengan ❤️ untuk Sekolah Elfa**