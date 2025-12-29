# Identifikasi Modul dan Fitur - Sistem Ticketing & Monev GSS

Sistem ini terdiri dari **5 modul utama** yang mendukung operasional dari pendaftaran pelanggan hingga evaluasi layanan. Berikut adalah breakdown fiturnya dengan konsep CRUD (tanpa kode):

## 1. Modul Manajemen Data Master (MDM)

Modul ini berfungsi sebagai fondasi data sistem.

### Registrasi Customer Otomatis

-   **Create**: Data otomatis terbuat saat pelanggan mengirim pesan dengan format tertentu via WhatsApp.
-   **Read**: Data dapat dilihat di list pelanggan oleh CS.

### Registrasi Customer Manual (CRUD)

-   **Create**: CS menambah pelanggan baru melalui form web jika pelanggan tidak lewat WA.
-   **Read**: Menampilkan daftar pelanggan beserta status (Aktif/Non-aktif).
-   **Update**: Mengubah detail kontak atau alamat pelanggan.
-   **Delete**: Menggunakan sistem **Soft Delete** (mengubah status menjadi Non-aktif) agar histori transaksi tetap terjaga.

### Manajemen Pengguna (TS/CS)

-   **Create**: Admin/CS mendaftarkan akun untuk Teknisi (TS) atau CS baru.
-   **Read**: Melihat profil dan hak akses (role) pengguna.
-   **Update**: Mengganti password (reset) atau mengubah role.

---

## 2. Modul Penjadwalan Visiting (PJV)

Modul untuk mengatur distribusi pekerjaan.

### Pembuatan Tiket & Validasi (CRUD)

-   **Create**: CS membuat tiket kunjungan dengan menentukan kuota teknisi yang dibutuhkan.
-   **Read**: Monitoring status tiket (_Open, Assigned, In Progress_).
-   **Update**: Membatalkan tiket atau mengubah detail jadwal sebelum diambil teknisi.

### Open Pool & Assignment (FCFS)

-   **Read**: Teknisi melihat daftar pekerjaan yang tersedia di "pool".
-   **Update**: Mekanisme **"Claim Job"** (FCFS - _First Come First Served_). Sistem mengunci (_lock_) data agar tidak diambil dua orang sekaligus jika kuota penuh.

---

## 3. Modul Eksekusi & Penanganan Darurat (EKD)

Modul untuk kontrol aktivitas teknisi di lapangan.

### Absensi & Status Harian

-   **Create**: Teknisi melakukan **Check-in** (mulai kerja) dan **Check-out** (selesai kerja).
-   **Read**: CS memantau waktu nyata (_real-time_) kehadiran teknisi.

### Emergency Pool & Perpanjangan

-   **Update**: Jika teknisi absen, CS dapat mengubah status tiket kembali ke **Open Pool** (Cari Pengganti).
-   **Create/Update**: Teknisi mengajukan **"Tambah Hari"** jika pekerjaan belum selesai, yang kemudian disetujui oleh CS.

---

## 4. Modul Invoicing (FIN)

Modul administrasi keuangan pasca-visitasi.

### Manajemen Invoice (CRUD)

-   **Create**: CS membuat draft invoice setelah status tiket "Done".
-   **Read**: Preview dokumen invoice dan status pembayaran.
-   **Update**: Sales menyetujui harga (**Approval**), dan CS memperbarui status menjadi **"Paid"** setelah bukti bayar diterima.

---

## 5. Modul Feedback & Rating (FDB)

Modul evaluasi kualitas layanan.

### Pengumpulan Rating

-   **Create**: Pelanggan mengisi form rating (skala 1-5) melalui link WA yang dikirim otomatis.
-   **Read**: Dashboard manajemen untuk melihat KPI teknisi dan CS berdasarkan rata-rata nilai pelanggan.
