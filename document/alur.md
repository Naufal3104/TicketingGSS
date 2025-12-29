# Alur Kerja dan Peran Pengguna - Sistem GSS

Proses bisnis dalam sistem ini melibatkan kolaborasi antara **empat peran utama** melalui platform Web Dashboard, WhatsApp, dan Telegram.

## 1. Alur Master (End-to-End)

Secara garis besar, siklus hidup layanan adalah sebagai berikut:

1. **Pendaftaran**: Pelanggan terdaftar (via WA/Manual).
2. **Permintaan**: Pelanggan lapor masalah -> CS buat Tiket.
3. **Distribusi**: Sistem broadcast ke Telegram TS -> TS "rebutan" (FCFS) di web.
4. **Eksekusi**: TS datang (Check-in) -> Kerja -> Selesai (Upload BAST).
5. **Administrasi**: CS buat Invoice -> Sales Approve Harga -> Invoice dikirim ke WA Pelanggan.
6. **Penutupan**: Pelanggan bayar -> Pelanggan isi Rating -> Tiket Close.

---

## 2. Keterlibatan Peran (Siapa Melakukan Apa)

### A. Customer Service (CS) - Koordinator Utama

CS adalah pusat informasi dalam sistem ini.

-   **Input & Validasi**: Menanggapi chat WA pelanggan dan memastikan data tersimpan benar.
-   **Ticketing**: Membuat tiket kunjungan dan menentukan berapa teknisi yang dibutuhkan.
-   **Monitoring**: Memantau apakah teknisi sudah check-in tepat waktu. Jika tidak, CS mengambil keputusan darurat (cari pengganti).
-   **Invoicing**: Menyiapkan tagihan dan menagih pembayaran ke pelanggan.

### B. Technical Support (TS) - Eksekutor Lapangan

TS fokus pada penyelesaian masalah teknis dan dokumentasi fisik.

-   **Bidding/Claiming**: Memilih pekerjaan yang tersedia di **Open Pool** secara cepat (siapa cepat dia dapat).
-   **Reporting**: Melakukan absensi berbasis lokasi (**Check-in/out**) sebagai bukti kehadiran.
-   **Dokumentasi**: Mengunduh Surat Tugas dan mengunggah **BAST** (Berita Acara Serah Terima) serta foto bukti pekerjaan.

### C. Sales - Konsultan Harga

Sales terlibat di tahap akhir untuk memastikan aspek komersial.

-   **Pricing Approval**: Menerima notifikasi di Telegram untuk meninjau harga atau diskon yang diberikan CS pada invoice.
-   **Finalisasi**: Memberikan lampu hijau (approve) agar invoice bisa dikirim ke pelanggan.

### D. Customer - Pelapor & Penilai

Pihak eksternal yang menerima manfaat layanan.

-   **Trigger**: Memulai alur dengan melaporkan masalah via WhatsApp.
-   **Evaluasi**: Memberikan rating kepuasan (Monev) setelah pekerjaan teknisi dinyatakan selesai.

---

## 3. Alur Spesifik Per Role

### Alur Kerja Teknisi (TS)

1. Menerima notifikasi job baru di **Telegram**.
2. Buka web, pilih job, dan klik **"Ambil Job"**.
3. Unduh **Surat Tugas/Jalan** dari sistem.
4. Sampai di lokasi, klik **"Check-in"**.
5. Setelah selesai, upload foto **BAST** dan klik **"Selesai"**.

### Alur Kerja Sales

1. Menerima notifikasi **"Draft Invoice Menunggu Approval"** di Telegram.
2. Melihat rincian harga yang diinput oleh CS.
3. Klik tombol **"Approve"** (atau meminta revisi jika harga tidak sesuai).

### Alur Kerja Customer Service (CS)

1. Membuat tiket berdasarkan keluhan pelanggan.
2. Jika TS tidak hadir di jam yang ditentukan, klik **"Cari Pengganti"** (Alur Emergency).
3. Setelah BAST diupload TS, CS membuat **Draft Invoice**.
4. Setelah Sales Approve, kirim **link Invoice & Rating** ke WA Pelanggan.
5. Menerima bukti bayar dan menutup tiket (**Closed**).
