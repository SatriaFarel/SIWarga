# 🏘️ SIWarga  
### Sistem Informasi Warga RT Berbasis Web

SIWarga adalah aplikasi web yang dirancang untuk membantu pengelolaan administrasi RT secara digital.  
Sistem ini memusatkan data warga, iuran, dan informasi RT dalam satu platform agar lebih rapi, transparan, dan mudah diakses oleh admin maupun warga.

---

## ✨ Gambaran Umum
- Administrasi RT masih banyak dilakukan secara manual
- Data warga tersebar dan sulit diperbarui
- Transparansi iuran belum optimal
- Informasi RT tidak selalu tersampaikan ke seluruh warga

SIWarga hadir sebagai **platform terintegrasi** yang digunakan oleh admin RT dan warga dengan hak akses berbeda.

---

## 👥 Peran Pengguna

### Admin RT
Admin RT berperan sebagai pengelola sistem dan data RT, termasuk data warga, iuran, dan informasi.

### Warga
Warga berperan sebagai pengguna layanan RT untuk mengakses informasi dan memantau iuran.

Setiap peran memiliki hak akses dan tampilan dashboard yang berbeda.

---

## 🔐 Login Sistem

SIWarga memiliki dua halaman login yang terpisah sesuai peran pengguna:

- **Admin RT**  
  Login melalui halaman:  
  `/admin/login`  
  Setelah login, admin diarahkan ke dashboard admin.

- **Warga**  
  Login melalui halaman:  
  `/warga/login`  
  Setelah login, warga diarahkan ke dashboard warga.

Pemisahan halaman login bertujuan untuk menjaga keamanan dan membedakan hak akses sistem.

---

## 🧩 Fitur Utama

### Fitur Admin RT
- Login admin
- Mengelola data warga (CRUD)
- Mengelola dan memverifikasi iuran
- Mengelola artikel, agenda, dan informasi RT
- Mengelola laporan dan pesan dari warga

### Fitur Warga
- Login warga
- Melihat tagihan dan status iuran
- Melakukan pembayaran iuran
- Mengakses informasi dan agenda RT
- Mengirim laporan atau saran

---

## 🛠️ Teknologi yang Digunakan
- **Backend:** Laravel  
- **Frontend:** Blade Template dan Tailwind CSS  
- **Database:** MySQL  
- **Autentikasi:** Session-based authentication  

---

## 📂 Struktur Folder (Ringkas)

- `app/` → Logic aplikasi dan controller  
- `routes/` → Pengaturan alur aplikasi  
- `resources/views/` → Tampilan admin dan warga  
- `database/` → Migration dan seeder  
- `public/` → Asset publik  

Struktur mengikuti standar Laravel agar mudah dipahami dan dikembangkan.

---

## 🚀 Cara Menjalankan Proyek

### Kebutuhan Sistem
- PHP ≥ 8.1
- Composer
- MySQL / MariaDB
- Web server (Apache / Nginx)

### Langkah Instalasi

1. Clone repository proyek dan masuk ke folder proyek  
   `git clone https://github.com/username/siwarga.git`  
   `cd siwarga`

2. Install seluruh dependency Laravel  
   `composer install`

3. Salin file environment dan generate application key  
   `cp .env.example .env`  
   `php artisan key:generate`

4. Buat database baru (misalnya **siwarga**) lalu sesuaikan konfigurasi database di file `.env`

5. Jalankan migrasi database  
   `php artisan migrate`

6. (Opsional) Jalankan seeder database  
   `php artisan db:seed`

7. Jalankan server aplikasi  
   `php artisan serve`

Aplikasi dapat diakses melalui browser pada alamat:  
http://localhost:8000

---

## 👨‍💻 Pengembang
**Satria Farel**  
SMKN 71

---

## 📌 Catatan
SIWarga dikembangkan sebagai aplikasi administrasi RT yang sederhana, terstruktur, dan siap dikembangkan lebih lanjut sesuai kebutuhan lingkungan RT.
