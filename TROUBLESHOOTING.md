# Troubleshooting - Galeri Sekolah Nafisa

## 🔧 Masalah Database Connection Error

### ❌ Error yang Terjadi:
```
SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it (Connection: mysql, SQL: select * from `sessions` where `id` = ... limit 1)
```

### ✅ Solusi yang Diterapkan:

#### 1. **Setup File Environment (.env)**
```bash
# Generate application key
php artisan key:generate

# Pastikan konfigurasi database di .env:
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

#### 2. **Buat File Database SQLite**
```bash
# Buat file database.sqlite
New-Item -Path "database\database.sqlite" -ItemType File
```

#### 3. **Jalankan Migration dan Seeder**
```bash
# Fresh migration dengan seeder
php artisan migrate:fresh --seed
```

#### 4. **Restart Server**
```bash
# Restart Laravel server
php artisan serve
```

### 🎯 Hasil:
- ✅ Database connection berhasil
- ✅ Tabel galleries terbuat
- ✅ Data sample terisi
- ✅ Dashboard admin dapat diakses

## 📋 Checklist Troubleshooting:

### Database Issues:
- [ ] File .env ada dan terkonfigurasi
- [ ] APP_KEY sudah di-generate
- [ ] File database.sqlite ada
- [ ] Migration sudah dijalankan
- [ ] Seeder sudah dijalankan

### Server Issues:
- [ ] Laravel server berjalan
- [ ] Port 8000 tidak digunakan aplikasi lain
- [ ] XAMPP/WAMP tidak conflict dengan port

### File Permissions:
- [ ] Folder storage writable
- [ ] Folder database writable
- [ ] File .env readable

## 🚀 Akses Aplikasi:

### Public Gallery:
- URL: `http://localhost:8000`
- Fitur: Lihat galeri, filter, pencarian, upload

### Admin Dashboard:
- URL: `http://localhost:8000/admin`
- Fitur: Dashboard, manajemen galeri, CRUD operations

### API Endpoints:
- URL: `http://localhost:8000/api/galleries`
- Fitur: RESTful API untuk galeri

## 🔍 Debug Commands:

```bash
# Cek status aplikasi
php artisan about

# Cek konfigurasi
php artisan config:show

# Cek routes
php artisan route:list

# Cek database
php artisan tinker
>>> App\Models\Gallery::count()

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📞 Support:

Jika masih ada masalah, periksa:
1. Log error di `storage/logs/laravel.log`
2. Konfigurasi database di `config/database.php`
3. Environment variables di `.env`
4. File permissions di folder `storage` dan `database`

---

**Status**: ✅ **RESOLVED** - Database connection error telah diperbaiki
