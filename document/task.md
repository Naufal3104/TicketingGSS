### A. Target Refactoring

1.  **Modul Keuangan (`InvoiceController`)**: Fitur invoice, create, dan detail.
2.  **Modul Operasional (`TicketController` & `AssignmentController`)**: Fitur tiket, form baru, dan surat tugas.

### B. Tahapan "Strangling" (Mencekik Kode Lama)

#### Tahap 1: Isolasi & Validasi (FormRequest)

Jangan sentuh logic utama dulu. Fokus keluarkan validasi.

-   [ ] Buat `StoreTicketRequest` & `UpdateTicketRequest`.
-   [ ] Buat `StoreInvoiceRequest`.
-   [ ] **Action**: Ganti `$request->validate(...)` di controller dengan injeksi FormRequest.
-   _Goal_: Controller terlihat lebih rapih sedikit.

#### Tahap 2: Service Layer Injection (Parallel Run)

Kita mulai "mengalihkan" logic sedikit demi sedikit.

-   [ ] Buat file `App\Services\TicketService.php` dan `App\Services\InvoiceService.php`.
-   [ ] **Pindahkan Satu Method**: Ambil logic terberat (misal: `store` di TicketController).
    -   Copy logic ke `TicketService->createTicket()`.
    -   Ganti isi `TicketController@store` menjadi pemanggilan Service.
    -   Pastikan fitur Surat Tugas (yang sudah ada) tetap jalan dengan memanggil logic yang sama.
-   [ ] **Ulangi untuk Update/Approve**: Pindahkan logic approval invoice ke `InvoiceService->approve()`.

#### Tahap 3: Cleanup & Optimization (Scoping)

Setelah logic pindah, bersihkan sisa-sisa query manual.

-   [ ] Ganti query raw (`where('status', 'OPEN')`) dengan **Model Scope** (`VisitTicket::open()->get()`).
-   [ ] Pastikan `AssignmentController` juga menggunakan `TicketService` jika ada logic yang beririsan (misal: update status tiket saat assign).

### Priority Check-list

1.  **Refactor `TicketController@store`** (Paling kritikal karena init workflow).
2.  **Refactor `InvoiceController@store`** (Logic generate invoice biasanya kompleks).
3.  **Refactor `AssignmentController@store`** (Logic Locking/FCFS perlu dipastikan aman di Service).

---

### Inventory Controller Saat Ini (Existing)

Berikut adalah daftar controller yang ditemukan di `app/Http/Controllers`:

**Admin**

-   `Admin\ReportController`
-   `Admin\UserController`

**Finance**

-   `Finance\InvoiceController`

**Master**

-   `Master\CustomerController`

**Operational**

-   `Operational\AssignmentController`
-   `Operational\AttendanceController`
-   `Operational\DocumentController`
-   `Operational\MonitoringController`
-   `Operational\TicketController`

**Api**

-   `Api\FeedbackController`
-   `Api\WebhookController`

**General / Root**

-   `CalendarController`
-   `DashboardController`
-   `ProfileController`
-   `Controller` (Base)

**Auth (Breeze/Default)**

-   `Auth\AuthenticatedSessionController`
-   `Auth\RegisteredUserController`
-   `Auth\PasswordController`
-   _dan controller auth lainnya..._

### C. Plan Implementasi Controller & Fitur (Rough Draft)

Berikut adalah rencana pengembangan controller yang perlu disesuaikan atau dibuat (refactoring/new implementation) beserta fitur utamanya:

#### 1. Modul Penjadwalan Visiting (PJV)

-   **`TicketController`** (Priority: High)
    -   [x] **Create Ticket**: Form input data pelanggan, jenis keluhan, upload foto awal.
    -   [x] **Check Quota**: Logic validasi ketersediaan TS saat assign (sekarang manual, future: auto check).
    -   [x] **Cancel Ticket**: Soft delete tiket jika cancel order.
-   **`AssignmentController`**
    -   [x] **List Open Pool**: Menampilkan tiket yang belum diambil.
    -   [x] **Claim Job**: Logic "first come first serve" dengan DB Transaction/Locking.

#### 2. Modul Keuangan (FIN)

-   **`InvoiceController`** (Priority: Medium-High)
    -   [x] **Generate Draft**: Auto-create invoice saat tiket status 'Done'.
    -   [x] **Sales Approval**: UI untuk sales menyetujui/mengedit harga final.
    -   [x] **Mark Paid**: Update status pembayaran & kirim notif ke customer.

#### 3. Modul Eksekusi (EKD)

-   **`AttendanceController`**
    -   [x] **Check-in**: Simpan timestamp & koordinat (GPS) teknisi saat tiba.
    -   [x] **Check-out**: Simpan timestamp selesai & validasi durasi kerja.
-   **`DocumentController`**
    -   [x] **Upload BAST**: Upload bukti serah terima (foto/dokumen).
    -   [x] **Generate Surat Tugas**: Download PDF surat tugas berdasarkan data tiket.
-   **`MonitoringController`**
    -   [x] **Emergency Re-pool**: Kembalikan tiket ke pool jika teknisi tidak hadir dalam X menit.
    -   [x] **Extend Visit**: Request tambah hari jika pekerjaan belum selesai.

#### 4. Modul Data Master (MDM)

-   **`CustomerController`**
    -   [x] **CRUD Manual**: Form tambah pelanggan untuk yang tidak via WA.
    -   [x] **History**: Lihat riwayat tiket pelanggan tersebut.
-   **`UserController`** (Admin)
    -   [x] **Role Management**: Assign role (CS, TS, Sales) ke user baru.

#### 5. Modul Feedback (FDB)

-   **`FeedbackController`**
    -   [x] **Public Form**: Endpoint untuk menerima rating dari link tanpa login (guest mode).
-   **`ReportController`**
    -   [x] **KPI Dashboard**: Hitung rata-rata rating per teknisi/CS.
