# Modul Lanjutan: CRUD Makanan Khas Daerah

## Target Siswa
- Siswa SMA yang sudah belajar `GET API` dan routing dasar Laravel.

## Tujuan Belajar
- Siswa memahami perbedaan data dari API eksternal vs data lokal database.
- Siswa mampu membuat fitur CRUD sederhana dengan relasi logis ke provinsi.
- Siswa memahami validasi input dan alur request form (`GET`, `POST`, `PUT`, `DELETE`).

## Konteks Proyek
- Data provinsi: dari API wilayah Indonesia.
- Data makanan khas: disimpan di database lokal aplikasi.
- Koneksi konsep: setiap makanan khas harus terkait ke `province_id`.

## Alur Materi (2 Pertemuan)

### Pertemuan 1 (90 menit): Desain Data + Create + Read
1. Review singkat materi sebelumnya (API provinsi).
2. Jelaskan desain tabel `makanan_khas`:
   - `province_id`
   - `province_name`
   - `nama_makanan`
   - `deskripsi`
3. Jalankan migration.
4. Buat halaman list makanan khas.
5. Buat form tambah makanan khas.
6. Praktik validasi input wajib.

Latihan:
- Tambahkan 3 makanan khas dari provinsi yang berbeda.
- Coba filter list berdasarkan provinsi.

### Pertemuan 2 (90 menit): Update + Delete + Refleksi
1. Buat form edit data makanan khas.
2. Buat fitur hapus dengan konfirmasi.
3. Uji error handling:
   - `province_id` kosong
   - `nama_makanan` terlalu panjang
4. Diskusi keamanan dasar:
   - Kenapa tetap validasi di server walaupun form sudah ada `required`.
5. Refactor ringan:
   - rapikan nama method/variabel
   - hindari duplikasi berlebihan

Latihan:
- Siswa menambah fitur pencarian nama makanan.
- Siswa menampilkan total makanan khas per provinsi.

## Poin Konsep yang Ditekankan
- API eksternal tidak selalu untuk semua data aplikasi.
- CRUD adalah pondasi mayoritas aplikasi bisnis.
- Validasi input adalah default, bukan tambahan.
- Kode sederhana dan terbaca lebih penting dari kode "keren".

## Rubrik Penilaian Mini
- Berhasil Create/Read/Update/Delete: 40%
- Validasi input berjalan: 25%
- Kerapian kode (nama variabel, struktur method): 20%
- Kemampuan menjelaskan alur kerja sendiri: 15%

## Challenge Opsional (Untuk siswa cepat)
- Tambahkan kolom `asal_kota`.
- Tambahkan pencarian real-time di halaman index.
- Tambahkan pagination Laravel.
