## 🎵 **SoundTix: Amankan Tiketmu, Nikmati Konsermu..**

SoundTix adalah solusi all-in-one untuk manajemen event dan tiket musik elektronik. Platform ini memberdayakan Event Organizer untuk menjangkau lebih banyak Pengunjung secara instan, sambil memberikan pengalaman pemesanan yang modern dan terorganisir di bawah kendali sistem Administrator yang handal.

Bagi para penggemar, SoundTix menawarkan kemudahan pencarian konser berdasarkan artis atau kota, serta jaminan tiket digital yang aman dan mudah diunduh.
---

## ✨ Mengapa SoundTix Berbeda?

### 🎧 Untuk Pengunjung (Guest & Fans)
Rasakan kemudahan mencari hiburan tanpa batas.
* **Immersive Experience:** Disambut dengan antarmuka bertema neon-dark yang membangkitkan *hype* konser sejak klik pertama.
* **Smart Discovery:** Temukan konser impianmu dengan mudah berdasarkan Nama Artis, Genre (Pop, Rock, Jazz), atau Kota.
* **Transparent Pricing:** Harga tiket termurah langsung ditampilkan di depan, tanpa biaya tersembunyi.

### 🎫 Untuk Pembeli (Registered User)
Lebih dari sekadar membeli, ini tentang mengamankan momen.
* **Multi-Tier Booking:** Pesan tiket Regular untuk teman-temanmu dan VIP untuk dirimu sendiri dalam satu transaksi.
* **Real-Time Status:** Pantau status pesananmu dari `Pending` (Menunggu Persetujuan) hingga `Lunas`.
* **Flexible Cancellation:** Berubah pikiran? Batalkan pesananmu sendiri dengan mudah, dan kuota tiket akan otomatis dikembalikan ke sistem.
* **E-Ticket Eksklusif:** Unduh tiket digital berformat PDF dengan desain premium dan QR Code unik yang siap di-scan di pintu masuk.

### 🎹 Untuk Event Organizer (Promotor)
Kendali penuh di tangan Anda.
* **Organizer Studio:** Dashboard eksklusif untuk mengelola seluruh rangkaian acara Anda.
* **Total Control:** Buat, edit, dan atur event Anda sendiri—mulai dari poster, deskripsi, hingga lokasi.
* **Custom Ticketing:** Buat variasi tiket tanpa batas (Presale, Early Bird, VVIP) dengan stok dan harga yang berbeda.
* **Manual Approval:** Fitur keamanan di mana Anda memegang kendali untuk **Menerima** atau **Menolak** setiap pesanan yang masuk.

### 🛡️ Untuk Administrator (Super User)
Penjaga kualitas ekosistem.
* **Quality Control:** Memverifikasi setiap akun Organizer baru sebelum mereka diizinkan membuat acara.
* **Global Management:** Memiliki akses penuh untuk mengedit atau menghapus event apapun demi menjaga standar platform.
* **Business Insight:** Memantau total pendapatan tiket dari seluruh event yang terdaftar.

---

## 🛠️ Teknologi di Balik Layar

Aplikasi ini dibangun menggunakan stack teknologi yang handal dan scalable:
* **Core Framework:** Laravel 10 / 11 (PHP)
* **Frontend Engine:** Blade Templates dengan Tailwind CSS (Vite)
* **Database:** MySQL (Relational Data Management)
* **Key Libraries:** `dompdf` / `html2pdf.js` untuk pencetakan tiket digital presisi.

---

## ⚙️ Panduan Instalasi (Localhost)

Siap untuk menjalankan SoundTix di mesin Anda? Ikuti langkah mudah ini:

### 1. Clone Repository
Pastikan PHP, Composer, dan MySQL sudah terinstall. Lalu clone repositori ini:
```bash
git clone [https://github.com/Pareddd/FINALWEB.git](https://github.com/Pareddd/FINALWEB.git)
cd eticket
```
### 2. Install Dependencies
```bash
composer install
npm install
```
### 3. Setup Environment Salin file .env.example menjadi .env dan sesuaikan konfigurasi database Anda.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=#database_anda
DB_USERNAME=root
DB_PASSWORD=
```
### 4. Database Migration & Seeding Jalankan migrasi dan isi data dummy (User, Event, Tiket).
Jalankan perintah ini untuk generate key, migrasi tabel, dan mengisi data awal (seeder):
```bash
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
```
### 5. Jalankan Aplikasi Buka dua terminal terpisah untuk menjalankan server Laravel dan Vite (untuk asset).
Terminal 1
```bash
php artisan serve
```
Terminal 2
```bash
npm run dev
```

