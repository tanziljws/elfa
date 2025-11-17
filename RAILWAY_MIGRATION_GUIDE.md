# 🚀 Panduan Migrasi Database ke Railway

## 📋 Daftar Isi
1. [Persiapan](#persiapan)
2. [Setup Railway Database](#setup-railway-database)
3. [Migrasi Data dari XAMPP ke Railway](#migrasi-data)
4. [Konfigurasi Environment](#konfigurasi-environment)
5. [Testing Koneksi](#testing-koneksi)
6. [Deployment ke Railway](#deployment)
7. [Troubleshooting](#troubleshooting)

---

## 🔧 Persiapan

### 1. Install Dependencies
Pastikan Anda sudah menginstall:
- PHP 8.x
- Composer
- MySQL Client (mysqldump)
- Railway CLI (opsional)

### 2. Backup Database XAMPP
Sebelum migrasi, **WAJIB** backup database XAMPP Anda:

```bash
# Backup database dari XAMPP
php backup-database.php

# Atau manual dengan mysqldump
mysqldump -u root -P 3307 -h 127.0.0.1 galeri-sekolah-elfa > backup_xampp.sql
```

File backup akan tersimpan di folder `database/backups/`

---

## 🗄️ Setup Railway Database

### 1. Buat MySQL Database di Railway
1. Login ke [Railway.app](https://railway.app)
2. Pilih project Anda
3. Klik **"New"** → **"Database"** → **"Add MySQL"**
4. Railway akan otomatis generate credentials

### 2. Dapatkan Database Credentials
Railway akan memberikan environment variables:
```
MYSQL_DATABASE=railway
MYSQL_ROOT_PASSWORD=mtFuxLheGuzbLeWjWJWsreBpfxQmaAkp
MYSQLUSER=root
MYSQLHOST=viaduct.proxy.rlwy.net (atau domain lain)
MYSQLPORT=12345 (port akan berbeda)
MYSQL_PUBLIC_URL=mysql://root:password@host:port/railway
```

### 3. Copy Credentials ke Railway Service
Di Railway Dashboard:
1. Pilih service Laravel Anda
2. Buka tab **"Variables"**
3. Tambahkan variables berikut (Railway akan auto-inject dari MySQL service):
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

---

## 📦 Migrasi Data dari XAMPP ke Railway

### Metode 1: Menggunakan Script PHP (Recommended)

```bash
# 1. Backup database XAMPP
php backup-database.php

# 2. Update .env untuk koneksi Railway
# Edit file .env dan uncomment konfigurasi Railway

# 3. Restore ke Railway
php restore-database.php backup_xampp.sql
```

### Metode 2: Manual dengan MySQL Client

```bash
# 1. Export dari XAMPP
mysqldump -u root -P 3307 -h 127.0.0.1 galeri-sekolah-elfa > backup.sql

# 2. Import ke Railway
# Ganti dengan credentials Railway Anda
mysql -u root -p'mtFuxLheGuzbLeWjWJWsreBpfxQmaAkp' \
  -h viaduct.proxy.rlwy.net \
  -P 12345 \
  railway < backup.sql
```

### Metode 3: Menggunakan Railway CLI

```bash
# 1. Install Railway CLI
npm i -g @railway/cli

# 2. Login
railway login

# 3. Link project
railway link

# 4. Connect ke database
railway connect mysql

# 5. Import database
mysql> source backup.sql;
```

---

## ⚙️ Konfigurasi Environment

### Untuk Development (Local XAMPP)
File: `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=galeri-sekolah-elfa
DB_USERNAME=root
DB_PASSWORD=
```

### Untuk Production (Railway)
File: `.env.railway` atau Railway Variables
```env
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

**PENTING:** Di Railway, gunakan **Variables** bukan file `.env`!

### Setup Railway Variables
1. Buka Railway Dashboard → Service → Variables
2. Tambahkan semua environment variables dari `.env.railway`
3. Railway akan otomatis inject MySQL credentials

---

## 🧪 Testing Koneksi

### Test Koneksi ke Railway Database

```bash
# Pastikan .env sudah diupdate dengan Railway credentials
php artisan config:clear
php artisan cache:clear

# Test koneksi database
php artisan tinker
>>> DB::connection()->getPdo();
>>> DB::select('SELECT DATABASE()');
```

### Test dengan Script

```bash
php test-railway-connection.php
```

Output yang diharapkan:
```
✓ Koneksi ke Railway MySQL berhasil!
✓ Database: railway
✓ Host: viaduct.proxy.rlwy.net
✓ Tables: [list of tables]
```

---

## 🚢 Deployment ke Railway

### 1. Persiapan File

Pastikan file-file ini ada di repository:
- ✅ `.env.railway` (template)
- ✅ `composer.json` & `composer.lock`
- ✅ `package.json` (jika ada)
- ✅ `Procfile` atau `nixpacks.toml`

### 2. Buat Procfile (jika belum ada)

```bash
# File: Procfile
web: php artisan serve --host=0.0.0.0 --port=$PORT
```

Atau gunakan `nixpacks.toml`:
```toml
[phases.setup]
nixPkgs = ["php82", "php82Packages.composer"]

[phases.build]
cmds = ["composer install --no-dev --optimize-autoloader"]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"
```

### 3. Push ke Railway

```bash
# Jika menggunakan GitHub
git add .
git commit -m "Setup Railway database"
git push origin main

# Railway akan otomatis deploy
```

### 4. Run Migrations di Railway

Setelah deploy:
```bash
# Menggunakan Railway CLI
railway run php artisan migrate --force

# Atau dari Railway Dashboard
# Service → Settings → Deploy → Add Command
# Command: php artisan migrate --force
```

### 5. Seed Data (Opsional)

```bash
railway run php artisan db:seed --force
```

---

## 🔍 Troubleshooting

### Error: "SQLSTATE[HY000] [2002] Connection refused"

**Solusi:**
1. Cek Railway Variables sudah benar
2. Pastikan MySQL service sudah running
3. Cek firewall/network Railway

```bash
# Test koneksi manual
php artisan config:clear
php artisan tinker
>>> DB::connection()->getPdo();
```

### Error: "Access denied for user"

**Solusi:**
1. Cek password di Railway Variables
2. Pastikan `MYSQLPASSWORD` match dengan Railway MySQL
3. Reset password di Railway Dashboard

### Error: "Unknown database 'railway'"

**Solusi:**
1. Pastikan database name benar (`railway`)
2. Buat database manual jika perlu:
```bash
railway connect mysql
mysql> CREATE DATABASE railway;
```

### Error: "Too many connections"

**Solusi:**
1. Tambahkan connection pooling di `config/database.php`:
```php
'mysql' => [
    // ...
    'options' => [
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_TIMEOUT => 5,
    ],
],
```

### Migration Timeout

**Solusi:**
1. Import data dalam batch kecil
2. Tingkatkan timeout di Railway Settings
3. Gunakan queue untuk large migrations

---

## 📝 Checklist Migrasi

- [ ] Backup database XAMPP
- [ ] Setup MySQL di Railway
- [ ] Copy credentials ke Railway Variables
- [ ] Test koneksi ke Railway database
- [ ] Export data dari XAMPP
- [ ] Import data ke Railway
- [ ] Update environment variables
- [ ] Run migrations di Railway
- [ ] Test aplikasi di Railway
- [ ] Setup monitoring & logging

---

## 🆘 Butuh Bantuan?

- Railway Docs: https://docs.railway.app
- Laravel Docs: https://laravel.com/docs
- MySQL Docs: https://dev.mysql.com/doc/

---

## 📌 Catatan Penting

1. **Jangan commit file `.env` ke Git!**
2. **Selalu backup sebelum migrasi**
3. **Test di staging sebelum production**
4. **Monitor database performance di Railway**
5. **Setup automated backups di Railway**

---

*Last updated: 2025-01-14*
