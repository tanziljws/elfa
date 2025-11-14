# 🚂 Railway Database Setup - Complete Guide

## 📦 File yang Tersedia

| File | Deskripsi |
|------|-----------|
| `.env.local` | Konfigurasi XAMPP lokal (development) |
| `.env.railway.production` | Template untuk Railway production |
| `RAILWAY_VARIABLES.txt` | Copy-paste ke Railway Dashboard |
| `RAILWAY_SETUP.md` | Dokumentasi lengkap |
| `migrate-to-railway.bat` | Script otomatis migrasi |
| `nixpacks.toml` | Railway build config |
| `Procfile` | Alternative build config |

---

## 🎯 Quick Start (3 Langkah)

### 1️⃣ Setup Railway MySQL

```
1. Login ke Railway.app
2. Buat project baru atau pilih existing
3. Klik "New" → "Database" → "Add MySQL"
4. Railway auto-generate credentials
```

**Railway akan memberikan variables:**
```
MYSQL_DATABASE=railway
MYSQL_ROOT_PASSWORD=mtFuxLheGuzbLeWjWJWsreBpfxQmaAkp
MYSQLHOST=${RAILWAY_PRIVATE_DOMAIN}
MYSQLPORT=3306
MYSQLUSER=root
```

### 2️⃣ Setup Environment Variables

**Di Railway Dashboard → Service Laravel → Variables:**

1. **Link MySQL Service** (Recommended)
   - Klik "Add Variable" → "Add Reference"
   - Pilih MySQL service
   - Railway akan auto-inject semua MySQL variables

2. **Tambahkan Variables Manual**
   - Copy dari file `RAILWAY_VARIABLES.txt`
   - Paste ke Railway Variables
   - Atau tambahkan satu per satu:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:WYZKYYNBg2Mjt9QYlgXQGl2ofKHE3fhzdDC1RAGKvlU=
APP_URL=https://your-app.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### 3️⃣ Migrasi Database

**Opsi A: Script Otomatis (Windows)**
```bash
migrate-to-railway.bat
```

**Opsi B: Manual**
```bash
# 1. Backup XAMPP
mysqldump -u root -P 3307 -h 127.0.0.1 galeri-sekolah-elfa > backup.sql

# 2. Update .env dengan Railway credentials
# Copy dari .env.railway.production ke .env

# 3. Test koneksi
php artisan config:clear
php artisan tinker
>>> DB::connection()->getPdo();

# 4. Import ke Railway
# Dapatkan Railway host dari Dashboard
mysql -u root -p'mtFuxLheGuzbLeWjWJWsreBpfxQmaAkp' \
  -h viaduct.proxy.rlwy.net \
  -P XXXX \
  railway < backup.sql
```

**Opsi C: Railway CLI**
```bash
# Install Railway CLI
npm i -g @railway/cli

# Login dan link project
railway login
railway link

# Connect ke MySQL
railway connect mysql

# Import database
mysql> source backup.sql;
```

---

## 🚀 Deploy ke Railway

### Setup Repository

```bash
git add .
git commit -m "Setup Railway database"
git push origin main
```

### Railway Auto-Deploy

Railway akan otomatis:
1. Detect PHP project
2. Install dependencies (`composer install`)
3. Build dengan nixpacks.toml atau Procfile
4. Deploy aplikasi

### Run Migrations

**Setelah deploy pertama:**

```bash
# Menggunakan Railway CLI
railway run php artisan migrate --force

# Atau tambahkan di Railway Dashboard
# Settings → Deploy → Deploy Command:
php artisan migrate --force
```

---

## 🔧 Railway Variables Lengkap

### Cara 1: Link MySQL Service (Recommended)

Di Railway Dashboard:
1. Service Laravel → Variables
2. Klik "New Variable" → "Add Reference"
3. Pilih MySQL service
4. Variables otomatis tersedia:
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`
   - `RAILWAY_PRIVATE_DOMAIN`

### Cara 2: Manual Input

Copy dari `RAILWAY_VARIABLES.txt` atau input manual:

```env
# Laravel
APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:WYZKYYNBg2Mjt9QYlgXQGl2ofKHE3fhzdDC1RAGKvlU=
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

# Database (gunakan ${VARIABLE} untuk reference)
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

---

## 🧪 Testing

### Test Koneksi Lokal ke Railway

```bash
# 1. Backup .env lokal
copy .env .env.backup

# 2. Copy Railway config
copy .env.railway.production .env

# 3. Update dengan Railway credentials
# Edit .env, ganti ${VARIABLE} dengan nilai sebenarnya

# 4. Clear cache
php artisan config:clear
php artisan cache:clear

# 5. Test koneksi
php artisan tinker
>>> DB::connection()->getPdo();
>>> DB::select('SELECT DATABASE()');
>>> DB::table('users')->count();

# 6. Restore .env lokal
copy .env.backup .env
```

### Test di Railway

```bash
# Menggunakan Railway CLI
railway run php artisan tinker
>>> DB::connection()->getPdo();
>>> DB::table('users')->count();
```

---

## 📊 Database Info

**Current Railway MySQL:**
```
Database: railway
Host: ${RAILWAY_PRIVATE_DOMAIN}
Port: 3306
Username: root
Password: mtFuxLheGuzbLeWjWJWsreBpfxQmaAkp
```

**Connection URLs:**
- **Internal (recommended):** `mysql://root:mtFuxLheGuzbLeWjWJWsreBpfxQmaAkp@${RAILWAY_PRIVATE_DOMAIN}:3306/railway`
- **External:** `mysql://root:mtFuxLheGuzbLeWjWJWsreBpfxQmaAkp@${RAILWAY_TCP_PROXY_DOMAIN}:${RAILWAY_TCP_PROXY_PORT}/railway`

**Gunakan RAILWAY_PRIVATE_DOMAIN untuk:**
- Koneksi dari service Railway lain
- Lebih cepat (internal network)
- Lebih aman (tidak exposed ke internet)

**Gunakan RAILWAY_TCP_PROXY untuk:**
- Koneksi dari lokal development
- Tools eksternal (MySQL Workbench, etc)

---

## ⚠️ Troubleshooting

### Connection Refused
```
✗ Error: SQLSTATE[HY000] [2002] Connection refused
```
**Solusi:**
- Cek Railway Variables sudah benar
- Pastikan MySQL service running
- Cek `DB_HOST` menggunakan `${MYSQLHOST}` atau `${RAILWAY_PRIVATE_DOMAIN}`

### Access Denied
```
✗ Error: SQLSTATE[HY000] [1045] Access denied for user 'root'
```
**Solusi:**
- Cek `DB_PASSWORD` match dengan Railway
- Pastikan `MYSQLPASSWORD` variable tersedia
- Reset password di Railway Dashboard

### Unknown Database
```
✗ Error: SQLSTATE[HY000] [1049] Unknown database 'railway'
```
**Solusi:**
- Database name harus `railway`
- Atau buat manual: `CREATE DATABASE railway;`
- Cek `DB_DATABASE` variable

### Migration Timeout
```
✗ Error: Maximum execution time exceeded
```
**Solusi:**
- Import data dalam batch kecil
- Gunakan Railway CLI: `railway connect mysql`
- Tingkatkan timeout di Railway Settings

---

## 📝 Checklist Deployment

- [ ] Buat MySQL service di Railway
- [ ] Link MySQL service ke Laravel service
- [ ] Setup Environment Variables
- [ ] Backup database XAMPP
- [ ] Test koneksi lokal ke Railway
- [ ] Import database ke Railway
- [ ] Verify data di Railway
- [ ] Push code ke Git
- [ ] Deploy ke Railway
- [ ] Run migrations di Railway
- [ ] Test aplikasi production
- [ ] Setup monitoring & logging
- [ ] Setup automated backups

---

## 🔐 Security Notes

1. **Jangan commit file `.env` ke Git!**
2. **Gunakan Railway Variables untuk sensitive data**
3. **Set `APP_DEBUG=false` di production**
4. **Ganti reCAPTCHA keys dengan production keys**
5. **Setup SSL/HTTPS di Railway (auto-enabled)**
6. **Gunakan `RAILWAY_PRIVATE_DOMAIN` untuk internal connections**

---

## 📞 Support & Resources

- **Railway Docs:** https://docs.railway.app
- **Laravel Docs:** https://laravel.com/docs
- **MySQL Docs:** https://dev.mysql.com/doc/
- **Railway Community:** https://discord.gg/railway

---

## 🎉 Summary

**Files Created:**
- ✅ `.env.local` - Local XAMPP config
- ✅ `.env.railway.production` - Railway template
- ✅ `RAILWAY_VARIABLES.txt` - Copy-paste variables
- ✅ `migrate-to-railway.bat` - Auto migration script
- ✅ `nixpacks.toml` - Build configuration
- ✅ `Procfile` - Alternative build config

**Next Steps:**
1. Setup MySQL di Railway
2. Copy variables dari `RAILWAY_VARIABLES.txt`
3. Run `migrate-to-railway.bat`
4. Deploy ke Railway
5. Test aplikasi

**Railway Database:**
- Database: `railway`
- User: `root`
- Password: `mtFuxLheGuzbLeWjWJWsreBpfxQmaAkp`
- Port: `3306`

---

*Last updated: 2025-01-14*
*Ready for production deployment! 🚀*
