# SIAKAD Akademik

Project ini adalah aplikasi akademik berbasis CodeIgniter 3 untuk kebutuhan dashboard multi-role, manajemen mahasiswa, dosen, mata kuliah, jadwal, KRS, dan nilai.

## Fitur Utama

- Dashboard berbeda untuk beberapa role kampus
- Manajemen data mahasiswa, jurusan, dan fakultas
- Modul dosen, mata kuliah, jadwal kuliah, KRS, dan nilai
- Role dan navigasi yang menyesuaikan hak akses pengguna
- Seed database untuk data awal dashboard dan portal

## Stack

- PHP
- CodeIgniter 3
- MySQL / MariaDB
- XAMPP

## Struktur Penting

- `application/` kode utama aplikasi
- `system/` core CodeIgniter 3
- `siakad_seed.sql` seed data aplikasi

## Setup Lokal

1. Buat database bernama `akademik`.
2. Import struktur/data yang dibutuhkan.
3. Pastikan `application/config/database.php` sesuai dengan MySQL lokal.
4. Jalankan aplikasi dari XAMPP di `http://localhost/akademik/index.php/dashboard`.

Contoh import:

```bash
mysql -u root akademik < siakad_seed.sql
```

Jika Anda juga punya dump struktur/data utama lain, sesuaikan dengan file SQL yang ingin dipakai.

## Akun dan Data

Project ini memakai data user di tabel `users`. Sebelum upload ke GitHub publik, review kembali isi database dump dan pastikan tidak ada data sensitif yang ikut dipublikasikan.

## Upload ke GitHub

Repo lokal sudah bisa disiapkan dengan langkah berikut:

```bash
git init
git branch -M main
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/USERNAME/REPOSITORY.git
git push -u origin main
```

Jika remote sudah ada, cukup pakai:

```bash
git push -u origin main
```

## Catatan

- File cache, logs, session, test lokal, dan dump database lokal sudah diatur di `.gitignore`.
- `readme.rst` bawaan CodeIgniter tetap disimpan sebagai referensi framework.
