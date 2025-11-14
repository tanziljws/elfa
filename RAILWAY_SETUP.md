# 🚀 Railway Database Setup - Quick Guide

## 📦 Setup Railway MySQL (5 Menit)

### 1. Buat MySQL Database di Railway
```
1. Login ke Railway.app
2. Pilih project Anda
3. Klik "New" → "Database" → "Add MySQL"
4. Railway auto-generate credentials
```

### 2. Setup Environment Variables di Railway

**Di Railway Dashboard → Service → Variables**, tambahkan:

```env
# Database (auto-inject dari MySQL service)
MYSQLHOST=<dari Railway MySQL>
MYSQLPORT=<dari Railway MySQL>
MYSQLDATABASE=railway
MYSQLUSER=root
MYSQLPASSWORD=<dari Railway MySQL>

# Laravel Config
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:WYZKYYNBg2Mjt9QYlgXQGl2ofKHE3fhzdDC1RAGKvlU=
APP_URL=https://your-app.up.railway.app

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

**PENTING:** Railway akan auto-inject MySQL variables jika Anda link MySQL service ke Laravel service!

---

## 🔄 Migrasi Database dari XAMPP

### Metode 1: Otomatis (Windows)
```bash
# Jalankan script batch
migrate-to-railway.bat
```

### Metode 2: Manual

**Step 1: Backup XAMPP**
```bash
mysqldump -u root -P 3307 -h 127.0.0.1 galeri-sekolah-elfa > backup.sql
```

**Step 2: Update .env untuk Railway**
```env
DB_CONNECTION=mysql
DB_HOST=<Railway Host>
DB_PORT=<Railway Port>
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=<Railway Password>
```

**Step 3: Import ke Railway**
```bash
# Clear config
php artisan config:clear

# Import database
mysql -u root -p'<password>' -h <host> -P <port> railway < backup.sql

# Atau gunakan Railway CLI
railway connect mysql
mysql> source backup.sql;
```

**Step 4: Verify**
```bash
php artisan tinker
>>> DB::select('SHOW TABLES');
>>> DB::table('users')->count();
```

---

## 🚢 Deploy ke Railway

### Setup Nixpacks (Recommended)

Buat file `nixpacks.toml`:
```toml
[phases.setup]
nixPkgs = ["php82", "php82Packages.composer", "nodejs"]

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader"]

[phases.build]
cmds = ["php artisan config:cache", "php artisan route:cache", "php artisan view:cache"]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"
```

### Atau Gunakan Procfile

Buat file `Procfile`:
```
web: php artisan serve --host=0.0.0.0 --port=$PORT
```

### Deploy
```bash
git add .
git commit -m "Setup Railway database"
git push origin main
```

Railway akan auto-deploy!

### Run Migrations di Railway
```bash
# Gunakan Railway CLI
railway run php artisan migrate --force

# Atau tambahkan di Railway Dashboard
# Settings → Deploy → Build Command:
composer install && php artisan migrate --force
```

---

## ✅ Checklist

- [ ] Buat MySQL service di Railway
- [ ] Setup Environment Variables
- [ ] Backup database XAMPP
- [ ] Import ke Railway database
- [ ] Test koneksi lokal ke Railway
- [ ] Buat nixpacks.toml atau Procfile
- [ ] Push ke Git
- [ ] Deploy ke Railway
- [ ] Run migrations di Railway
- [ ] Test aplikasi production

---

## 🔍 Quick Commands

```bash
# Backup XAMPP
mysqldump -u root -P 3307 -h 127.0.0.1 galeri-sekolah-elfa > backup.sql

# Test Railway connection
php artisan tinker
>>> DB::connection()->getPdo();

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Railway CLI
railway login
railway link
railway run php artisan migrate --force
railway connect mysql
```

---

## ⚠️ Troubleshooting

### "Connection refused"
- Cek Railway Variables sudah benar
- Pastikan MySQL service running
- Test dengan: `php artisan tinker`

### "Access denied"
- Cek password di Railway Variables
- Pastikan MYSQLPASSWORD match

### "Unknown database"
- Database name harus `railway`
- Atau buat manual: `CREATE DATABASE railway;`

### Migration timeout
- Import dalam batch kecil
- Gunakan Railway CLI: `railway connect mysql`

---

## 📞 Support

- Railway Docs: https://docs.railway.app
- Laravel Docs: https://laravel.com/docs
- MySQL Docs: https://dev.mysql.com/doc/

---

**Last updated: 2025-01-14**
