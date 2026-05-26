# Setup MVC Mahasiswa - CodeIgniter

## File yang Telah Dibuat:
1. **Model**: `application/models/Mahasiswa_model.php`
2. **Controller**: `application/controllers/Mahasiswa.php`
3. **View**: `application/views/mahasiswa_view.php`
4. **Database Config**: `application/config/database.php` (sudah dikonfigurasi)
5. **SQL Script**: `setup_database.sql`

## Langkah-Langkah Setup:

### 1. Buat Database dan Tabel
- Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
- Pilih tab **SQL**
- Copy isi file `setup_database.sql` dan paste ke tab SQL
- Klik tombol **Execute** atau tekan `Ctrl + Enter`

### 2. Atau Manual via CLI:
Buka Command Prompt/Terminal dan jalankan:
```bash
cd c:\xampp\htdocs\akademik
mysql -u root < setup_database.sql
```

### 3. Akses Aplikasi
Buka browser dan akses:
```
http://localhost/akademik/index.php/mahasiswa
```

## Struktur MVC:

### Model (Mahasiswa_model.php)
- Function `getAllMahasiswa()` mengambil semua data dari tabel `mahasiswa`
- Menggunakan Query Builder CodeIgniter

### Controller (Mahasiswa.php)
- Load model `Mahasiswa_model`
- Function `index()` mengambil data dan mengirimnya ke view

### View (mahasiswa_view.php)
- Menampilkan data dalam tabel HTML
- Kolom: No, NIM, Nama, Jurusan
- Menggunakan `foreach` untuk looping data
- Styling responsive dan modern

## Database Config
Konfigurasi di `application/config/database.php`:
- **hostname**: localhost
- **username**: root
- **password**: (kosong)
- **database**: akademik
- **driver**: mysqli

Sesuaikan jika setup XAMPP Anda berbeda!

## Troubleshooting

### Jika Error Database Connection:
1. Pastikan MySQL server berjalan di XAMPP
2. Check username dan password di `database.php`
3. Pastikan database `akademik` sudah ada

### Jika Tabel Tidak Ditemukan:
1. Jalankan file `setup_database.sql` melalui phpMyAdmin
2. Verify tabel `mahasiswa` sudah ada dengan data

---
Setup selesai! 🎉
