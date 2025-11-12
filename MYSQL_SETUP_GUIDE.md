# Panduan Setup MySQL untuk Galeri Sekolah Nafisa

## 🚀 Langkah-langkah Setup MySQL

### 1. **Aktifkan MySQL di XAMPP**

1. **Buka XAMPP Control Panel**
   - Jalankan XAMPP Control Panel sebagai Administrator
   - Klik tombol "Start" pada MySQL
   - Pastikan status MySQL berubah menjadi "Running" (hijau)

2. **Verifikasi MySQL Berjalan**
   - Buka browser dan akses: `http://localhost/phpmyadmin`
   - Atau buka Command Prompt dan jalankan:
   ```cmd
   C:\xampp\mysql\bin\mysql.exe -u root
   ```

### 2. **Buat Database MySQL**

#### Opsi A: Menggunakan phpMyAdmin (Recommended)
1. Buka `http://localhost/phpmyadmin`
2. Klik tab "Databases"
3. Masukkan nama database: `galeri_sekolah_nafisa`
4. Pilih Collation: `utf8mb4_unicode_ci`
5. Klik "Create"

#### Opsi B: Menggunakan Command Line
```cmd
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE galeri_sekolah_nafisa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. **Update Konfigurasi .env**

Ganti konfigurasi database di file `.env`:

```env
# MySQL Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=galeri_sekolah_nafisa
DB_USERNAME=root
DB_PASSWORD=
```

### 4. **Jalankan Migration**

```bash
# Clear cache konfigurasi
php artisan config:clear

# Jalankan migration dengan seeder
php artisan migrate:fresh --seed
```

### 5. **Test Koneksi**

```bash
# Test koneksi database
php artisan tinker
>>> DB::connection()->getPdo();
>>> App\Models\Gallery::count();
```

## 🔧 Troubleshooting

### Error: "Can't connect to MySQL server"
**Solusi:**
1. Pastikan XAMPP MySQL service berjalan
2. Cek port 3306 tidak digunakan aplikasi lain
3. Restart XAMPP Control Panel sebagai Administrator

### Error: "Access denied for user 'root'"
**Solusi:**
1. Cek username dan password di `.env`
2. Default XAMPP: username=`root`, password=kosong
3. Jika ada password, update di `.env`:
   ```env
   DB_PASSWORD=your_password_here
   ```

### Error: "Database doesn't exist"
**Solusi:**
1. Buat database `galeri_sekolah_nafisa` di phpMyAdmin
2. Pastikan nama database sama persis di `.env`

## 📋 Checklist Setup MySQL

- [ ] XAMPP MySQL service berjalan
- [ ] Database `galeri_sekolah_nafisa` dibuat
- [ ] File `.env` dikonfigurasi untuk MySQL
- [ ] Migration berhasil dijalankan
- [ ] Seeder berhasil dijalankan
- [ ] Test koneksi database berhasil

## 🎯 Konfigurasi .env Lengkap untuk MySQL

```env
APP_NAME="Galeri Sekolah Nafisa"
APP_ENV=local
APP_KEY=base64:clp4FnW++y8UZj70jr7RcRTnbOOpcCFk2BHxmg/PG14=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# MySQL Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=galeri_sekolah_nafisa
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## 🚀 Setelah Setup Selesai

1. **Jalankan Server:**
   ```bash
   php artisan serve
   ```

2. **Akses Aplikasi:**
   - **Public Gallery**: `http://localhost:8000`
   - **Admin Dashboard**: `http://localhost:8000/admin`
   - **phpMyAdmin**: `http://localhost/phpmyadmin`

3. **Verifikasi Database:**
   - Buka phpMyAdmin
   - Pilih database `galeri_sekolah_nafisa`
   - Cek tabel `galleries` dan data sample

---

**Status**: ⏳ **PENDING** - Menunggu MySQL service diaktifkan di XAMPP
