# 🚀 Panduan Mengaktifkan MySQL di XAMPP

## ❌ Error yang Terjadi:
```
SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it
```

**Penyebab**: MySQL service di XAMPP belum aktif.

## ✅ Solusi Lengkap:

### 1. **Aktifkan MySQL di XAMPP Control Panel**

1. **Buka XAMPP Control Panel**
   - Cari "XAMPP Control Panel" di Start Menu
   - **Jalankan sebagai Administrator** (klik kanan → Run as Administrator)

2. **Start MySQL Service**
   - Di XAMPP Control Panel, cari baris "MySQL"
   - Klik tombol **"Start"** di sebelah MySQL
   - Tunggu hingga status berubah menjadi **"Running"** (hijau)
   - Port MySQL: 3306

3. **Verifikasi MySQL Berjalan**
   - Status MySQL harus menunjukkan "Running"
   - Port 3306 harus aktif
   - Jika ada error, cek port 3306 tidak digunakan aplikasi lain

### 2. **Buat Database MySQL**

#### Opsi A: Menggunakan phpMyAdmin (Recommended)
1. Buka browser: `http://localhost/phpmyadmin`
2. Klik tab **"Databases"**
3. Masukkan nama database: `galeri_sekolah_nafisa`
4. Pilih Collation: `utf8mb4_unicode_ci`
5. Klik **"Create"**

#### Opsi B: Menggunakan Command Line
```cmd
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE galeri_sekolah_nafisa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. **Test Koneksi Database**

Setelah MySQL aktif, jalankan test:

```bash
# Test koneksi
php test_db.php

# Atau test manual
php artisan tinker
>>> DB::connection()->getPdo();
```

### 4. **Jalankan Migration**

```bash
# Clear cache
php artisan config:clear

# Jalankan migration
php artisan migrate:fresh --seed
```

## 🔧 Troubleshooting MySQL

### Error: "Port 3306 already in use"
**Solusi:**
1. Cek aplikasi lain yang menggunakan port 3306
2. Stop service MySQL di Windows Services
3. Restart XAMPP Control Panel

### Error: "Access denied for user 'root'"
**Solusi:**
1. Default XAMPP: username=`root`, password=kosong
2. Jika ada password, update di `.env`:
   ```env
   DB_PASSWORD=your_password_here
   ```

### Error: "MySQL service won't start"
**Solusi:**
1. Jalankan XAMPP sebagai Administrator
2. Cek port 3306 tidak digunakan
3. Restart komputer jika perlu

## 📋 Checklist Setup MySQL

- [ ] XAMPP Control Panel dibuka sebagai Administrator
- [ ] MySQL service status "Running" (hijau)
- [ ] Port 3306 aktif
- [ ] Database `galeri_sekolah_nafisa` dibuat
- [ ] File `.env` dikonfigurasi untuk MySQL
- [ ] Test koneksi database berhasil
- [ ] Migration berhasil dijalankan

## 🎯 Langkah Selanjutnya

Setelah MySQL aktif:

1. **Test Koneksi:**
   ```bash
   php test_db.php
   ```

2. **Jalankan Migration:**
   ```bash
   php artisan migrate:fresh --seed
   ```

3. **Start Server:**
   ```bash
   php artisan serve
   ```

4. **Akses Aplikasi:**
   - **Public Gallery**: `http://localhost:8000`
   - **Admin Dashboard**: `http://localhost:8000/admin`
   - **phpMyAdmin**: `http://localhost/phpmyadmin`

## 🚨 Penting!

**MySQL service HARUS aktif** sebelum aplikasi Laravel bisa berjalan dengan database MySQL. 

Jika MySQL tidak aktif, aplikasi akan selalu menampilkan error "connection refused".

---

**Status**: ⏳ **MENUNGGU** - MySQL service perlu diaktifkan di XAMPP Control Panel
