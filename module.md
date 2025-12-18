

Fokus: Menyiapkan akses pengguna (Admin, TS, Sales) dan data pelanggan.
Durasi: 2 Minggu

1. Role: Admin (Customer Service)

Fitur untuk pengelolaan data pusat.

[ ] (MDM-003) Manajemen User Internal:

Membuat akun untuk Teknisi (TS) dan Sales.

Mengatur Role dan Password awal.

Input ID Telegram untuk keperluan notifikasi sistem.

[ ] (MDM-002) Manajemen Data Customer (CRUD):

Input manual data pelanggan (Nama, Alamat, No HP) jika pelanggan tidak daftar via WA.

Edit dan Hapus data pelanggan.

Melihat riwayat tiket per pelanggan.

2. Role: System (Backend/Automation)

Fitur otomatisasi tanpa interaksi admin.

[ ] (MDM-001) Registrasi Pelanggan via WhatsApp:

Menerima pesan WA dari pelanggan baru.

Validasi format dan simpan otomatis ke database.

Auto-reply notifikasi sukses ke WA pelanggan.

[ ] Autentikasi & Security:

Login sistem dengan Token (RBAC).

SPRINT 2: Operasional Tiket & Eksekusi Lapangan (The "Core")

Fokus: Alur "War Tiket" Teknisi, Visitasi, dan Monitoring Admin.
Durasi: 2 Minggu

1. Role: Admin (Customer Service)

Fitur untuk mengatur penugasan dan memantau lapangan.

[ ] (PJV-001) Pembuatan Tiket & Cek Kuota:

Form input tiket baru (Masalah, Lokasi).

Sistem validasi ketersediaan kuota Teknisi secara real-time.

[ ] (PJV-003) Upload Dokumen Surat:

Upload file Surat Tugas & Surat Jalan ke dalam tiket yang sudah di-assign.

[ ] (EKD-002) Dashboard Monitoring & Emergency:

Monitoring status tiket: Open, Assigned, In-Progress, Done.

Fitur Emergency: Menerima alert jika TS tidak Check-in dan tombol untuk memutuskan (Lanjut/Ganti TS).

2. Role: Teknisi (TS)

Fitur mobile-web untuk operasional lapangan.

[ ] (PJV-002) Bidding / Job Assignment (FCFS):

Terima Notifikasi Telegram: Info ada job baru di Open Pool.

Fitur "Ambil Job": Tombol rebutan (First Come First Served) dengan sistem penguncian data (Locking).

[ ] (EKD-001) Absensi Visitasi (Check-in/Out):

Check-in: Tombol rekam waktu mulai & lokasi (GPS) saat tiba.

Check-out: Tombol rekam waktu selesai.

[ ] (PJV-003) Pelaporan Dokumen (BAST):

Download/Lihat Surat Tugas dari Admin.

Upload BAST: Unggah foto dokumen BAST yang sudah ditandatangani.

Upload Bukti: Unggah foto hasil pekerjaan.

SPRINT 3: Keuangan (Sales) & Evaluasi (Closing)

Fokus: Validasi harga, penagihan, dan rating kepuasan.
Durasi: 2 Minggu

1. Role: Sales

Fitur kontrol harga.

[ ] (FIN-001) Approval Invoice:

Terima Notifikasi Telegram: Saat Admin membuat draft invoice.

Dashboard Approval: Melihat rincian tiket dan harga dasar.

Aksi: Tombol Approve (Setuju) atau Reject (Tolak/Revisi) diskon dan harga akhir.

2. Role: Admin (Customer Service)

Fitur penagihan dan penyelesaian.

[ ] (FIN-001) Invoicing:

Generate Draft Invoice setelah status tiket Completed.

Mengirim Link Invoice final ke WhatsApp Pelanggan (setelah diapprove Sales).

Update status pembayaran (Paid).

[ ] Reporting:

Melihat rekap hasil Rating dari pelanggan.

3. Role: Customer (via WhatsApp)

[ ] (FDB-001) Feedback Rating:

Menerima link rating otomatis setelah tiket ditutup.

Input Bintang 1-5 untuk pelayanan TS dan CS.