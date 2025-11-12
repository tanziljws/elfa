# 🔐 Setup Google reCAPTCHA untuk Registrasi User

## ✅ Yang Sudah Dikerjakan:

1. ✅ Install package `anhskohbo/no-captcha`
2. ✅ Publish config captcha
3. ✅ Buat RegisterController dengan validasi captcha
4. ✅ Update routes untuk menggunakan controller
5. ✅ Tambahkan reCAPTCHA widget ke form registrasi

## 📋 Langkah Setup (PENTING!):

### Step 1: Dapatkan API Keys dari Google

1. Buka: https://www.google.com/recaptcha/admin/create
2. Login dengan akun Google Anda
3. Isi form:
   - **Label**: Galeri Sekolah SMKN 4 Bogor
   - **reCAPTCHA type**: Pilih **reCAPTCHA v2** → "I'm not a robot" Checkbox
   - **Domains**: 
     - Untuk localhost: `127.0.0.1` dan `localhost`
     - Untuk production: domain website Anda (misal: `smkn4bogor.sch.id`)
   - Centang "Accept the reCAPTCHA Terms of Service"
4. Klik **Submit**
5. Copy **Site Key** dan **Secret Key** yang diberikan

### Step 2: Tambahkan Keys ke File .env

Buka file `.env` di root project dan tambahkan baris berikut:

```env
# Google reCAPTCHA v2
NOCAPTCHA_SITEKEY=paste_site_key_disini
NOCAPTCHA_SECRET=paste_secret_key_disini
```

**UNTUK TESTING DI LOCALHOST**, Anda bisa gunakan test keys dari Google:

```env
# Test Keys (hanya untuk development/testing)
NOCAPTCHA_SITEKEY=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
NOCAPTCHA_SECRET=6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe
```

⚠️ **PENTING**: Test keys akan selalu berhasil validasi. Untuk production, HARUS gunakan keys asli!

### Step 3: Clear Cache

Jalankan command berikut di terminal:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Step 4: Test Registrasi

1. Buka browser: `http://127.0.0.1:8000/user/register`
2. Isi semua field form
3. Centang checkbox "I'm not a robot"
4. Klik tombol "Daftar"
5. Jika berhasil, akan redirect ke halaman login

## 🎯 Fitur yang Sudah Ditambahkan:

### RegisterController (`app/Http/Controllers/Auth/RegisterController.php`)
- ✅ Validasi captcha dengan rule `'g-recaptcha-response' => 'required|captcha'`
- ✅ Validasi username unique
- ✅ Validasi email unique
- ✅ Password minimal 8 karakter
- ✅ Password confirmation
- ✅ Hash password dengan bcrypt
- ✅ Error messages dalam Bahasa Indonesia

### Form Registrasi (`resources/views/auth/user-register.blade.php`)
- ✅ reCAPTCHA widget otomatis render
- ✅ Error message untuk captcha
- ✅ Responsive design
- ✅ User-friendly interface

## 🔒 Keamanan:

- ✅ Mencegah bot spam registrasi
- ✅ Validasi server-side (tidak bisa di-bypass dari client)
- ✅ Password di-hash dengan bcrypt
- ✅ CSRF protection
- ✅ Validasi unique untuk username dan email

## 🐛 Troubleshooting:

### Error: "Silakan verifikasi bahwa Anda bukan robot"
- Pastikan sudah centang checkbox reCAPTCHA
- Pastikan API keys sudah benar di file `.env`
- Clear cache dengan `php artisan config:clear`

### Captcha tidak muncul
- Pastikan koneksi internet aktif
- Cek console browser untuk error JavaScript
- Pastikan Site Key sudah benar

### Error: "The g-recaptcha-response field is required"
- Centang checkbox "I'm not a robot" sebelum submit
- Jika sudah centang tapi masih error, refresh halaman

### Error: "Verifikasi captcha gagal"
- Secret Key salah atau tidak sesuai dengan Site Key
- Periksa kembali keys di file `.env`
- Pastikan domain sudah terdaftar di Google reCAPTCHA console

## 📝 Catatan:

- reCAPTCHA v2 memerlukan user untuk klik checkbox
- Untuk production, WAJIB gunakan keys asli (bukan test keys)
- Keys harus sesuai dengan domain yang didaftarkan
- Jangan commit file `.env` ke Git (sudah ada di `.gitignore`)

## 🎉 Selesai!

Fitur captcha sudah aktif dan siap digunakan untuk mencegah spam registrasi!
