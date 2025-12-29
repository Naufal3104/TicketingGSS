# Struktur Controller & Fungsi

Dokumen ini memetakan kebutuhan controller berdasarkan modul yang didefinisikan di [modul.md](modul.md).

## 1. Modul Manajemen Data Master (MDM)

### Customer (Pelanggan)

**Controller**: `App\Http\Controllers\Master\CustomerController`

-   `index()`: Menampilkan daftar pelanggan (Read).
-   `store()`: Registrasi manual oleh CS (Create).
-   `update()`: Update data pelanggan (Update).
-   `destroy()`: Soft delete pelanggan (Delete).
-   _> Note: Registrasi otomatis via WA ditangani oleh `Api\WebhookController`._

### Pengguna (Admin/CS/TS)

**Controller**: `App\Http\Controllers\Admin\UserController`

-   `index()`: List pengguna dan role.
-   `store()`: Registrasi akun baru.
-   `update()`: Reset password / ganti role.

---

## 2. Modul Penjadwalan Visiting (PJV)

### Tiket Kunjungan

**Controller**: `App\Http\Controllers\Operational\TicketController`

-   `index()`: Monitoring status tiket (Open, Assigned, In Progress).
-   `create()` / `store()`: CS membuat tiket baru dengan validasi kuota TS.
-   `update()`: CS mengubah detail tiket atau membatalkan.

### Assignment (Open Pool)

**Controller**: `App\Http\Controllers\Operational\AssignmentController`

-   `index()`: Teknisi melihat daftar "Open Pool".
-   `store()`: Mekanisme **Claim Job** (FCFS - _First Come First Served_) dengan locking.

---

## 3. Modul Eksekusi & Penanganan Darurat (EKD)

### Absensi

**Controller**: `App\Http\Controllers\Operational\AttendanceController`

-   `store()` / `checkIn()`: Teknisi melakukan Check-in (mulai kerja) dengan koordinat GPS.
-   `update()` / `checkOut()`: Teknisi melakukan Check-out (selesai kerja).
-   `index()`: CS memantau kehadiran teknisi secara real-time.

### Dokumentasi Lapangan

**Controller**: `App\Http\Controllers\Operational\DocumentController`

-   `upload()`: Upload **BAST** (Berita Acara Serah Terima) dan foto bukti.
-   `download()`: Mengunduh **Surat Tugas** otomatis.

### Monitoring & Emergency

**Controller**: `App\Http\Controllers\Operational\MonitoringController`

-   `update()`: Logic untuk mengembalikan tiket ke **Open Pool** (Cari Pengganti) jika TS absen.
-   `extensionRequest()`: Teknisi mengajukan "Tambah Hari".

---

## 4. Modul Invoicing (FIN)

### Invoice & Pembayaran

**Controller**: `App\Http\Controllers\Finance\InvoiceController`

-   `store()`: Generate draft invoice otomatis setelah tiket berstatus "Done".
-   `show()`: Preview detail invoice.
-   `approve()`: **Sales** melakukan approval harga/diskon.
-   `updatePayment()`: **CS** memperbarui status menjadi "Paid".

---

## 5. Modul Feedback & Rating (FDB)

### Feedback Loop

**Controller**: `App\Http\Controllers\Api\FeedbackController`

-   `store()`: Endpoint publik untuk menyimpan rating pelanggan (dari link WA).

### KPI Dashboard

**Controller**: `App\Http\Controllers\Admin\ReportController`

-   `index()`: Menampilkan performa Teknisi/CS berdasarkan rata-rata rating.

---

## API & Integrasi (WhatsApp)

**Controller**: `App\Http\Controllers\Api\WebhookController`

-   `handle()`: Menerima webhook dari provider WA untuk pendaftaran otomatis atau update status chat.
