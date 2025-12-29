### A. Target Refactoring

1.  **Modul Keuangan (`InvoiceController`)**: Fitur invoice, create, dan detail.
2.  **Modul Operasional (`TicketController` & `AssignmentController`)**: Fitur tiket, form baru, dan surat tugas.

### B. Tahapan "Strangling" (Mencekik Kode Lama)

#### Tahap 1: Isolasi & Validasi (FormRequest)

Jangan sentuh logic utama dulu. Fokus keluarkan validasi.

-   [x] Buat `StoreTicketRequest` & `UpdateTicketRequest`.
-   [x] Buat `StoreInvoiceRequest`.
-   [x] **Action**: Ganti `$request->validate(...)` di controller dengan injeksi FormRequest.
-   _Goal_: Controller terlihat lebih rapih sedikit.

#### Tahap 2: Service Layer Injection (Parallel Run)

Kita mulai "mengalihkan" logic sedikit demi sedikit.

-   [x] Buat file `App\Services\TicketService.php` dan `App\Services\InvoiceService.php`.
-   [x] **Pindahkan Satu Method**: Ambil logic terberat (misal: `store` di TicketController).
    -   Copy logic ke `TicketService->createTicket()`.
    -   Ganti isi `TicketController@store` menjadi pemanggilan Service.
    -   Pastikan fitur Surat Tugas (yang sudah ada) tetap jalan dengan memanggil logic yang sama.
-   [x] **Ulangi untuk Update/Approve**: Pindahkan logic approval invoice ke `InvoiceService->approve()`.

#### Tahap 3: Cleanup & Optimization (Scoping)

Setelah logic pindah, bersihkan sisa-sisa query manual.

-   [x] Ganti query raw (`where('status', 'OPEN')`) dengan **Model Scope** (`VisitTicket::open()->get()`).
-   [x] Pastikan `AssignmentController` juga menggunakan `TicketService` jika ada logic yang beririsan (misal: update status tiket saat assign).

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

### C. Plan Implementasi Controller & Fitur (Breakdown Lengkap via modul.md)

Berikut adalah status implementasi fitur berdasarkan `document/modul.md`:

#### 1. Modul Manajemen Data Master (MDM)

-   **`CustomerController`**
    -   [x] **Registrasi Manual (CRUD)**: Create/Update/Delete customer via Web.
    -   [x] **History**: Melihat riwayat tiket per customer.
-   **`Api\WebhookController`**
    -   [x] **Registrasi Otomatis (WA)**: Endpoint menerima data user baru dari WhatsApp (N8N).
-   **`Admin\UserController`**
    -   [x] **Create User**: Pendaftaran akun TS/CS/Sales.
    -   [x] **Role Management**: Assign role & permissions.
    -   [x] **Reset Password**: Update password user existing.

#### 2. Modul Penjadwalan Visiting (PJV)

-   **`Operational\TicketController`**
    -   [x] **Create Ticket**: Form input, jenis keluhan, upload foto, validasi kuota.
    -   [x] **Monitoring (Read)**: List tiket status Open/Assigned/Progress.
    -   [x] **Update/Cancel**: Edit info tiket atau soft-delete jika cancel.
-   **`Operational\AssignmentController`**
    -   [x] **List Open Pool**: View tiket tersedia untuk teknisi.
    -   [x] **Claim Job (FCFS)**: Mekanisme taking job dengan locking system (via `TicketService`).

#### 3. Modul Eksekusi & Penanganan Darurat (EKD)

-   **`Operational\AttendanceController`**
    -   [x] **Check-in/Check-out**: Timestamp & Geo-tagging kehadiran teknisi.
-   **`Operational\DocumentController`**
    -   [x] **Upload BAST**: Upload bukti pekerjaan selesai.
    -   [x] **Generate Surat Tugas**: Cetak PDF untuk akses lokasi.
-   **`Operational\MonitoringController`**
    -   [x] **Emergency Re-pool**: Force update status tiket kembali ke 'OPEN' (CS Override).
    -   [x] **Extend Visit**: Request tambah hari kunjungan.

#### 4. Modul Invoicing (FIN)

-   **`Finance\InvoiceController`**
    -   [x] **Generate Draft**: Auto-create saat tiket DONE (via `InvoiceService`).
    -   [x] **Read/Preview**: Invoice detail view.
    -   [x] **Sales Approval**: Edit amount discount/base sebelum final.
    -   [x] **Mark Paid**: Update status lunas.

#### 5. Modul Feedback & Rating (FDB)

-   **`Api\FeedbackController`**
    -   [x] **Public Form**: Endpoint gueest mode untuk rating.
-   **`Admin\ReportController`**
    -   [x] **KPI Dashboard**: Statistik performa teknisi/CS.

### D. Inventory Controller & Status (Audit Results)

Berikut adalah status terkini dari seluruh controller di `app/Http/Controllers` (New Rule: PascalCase Role-Based):

| Controller                            | Status      | Kegunaan Utama                                                            |
| :------------------------------------ | :---------- | :------------------------------------------------------------------------ |
| **TechnicalSupport** (ex-Operational) |             |                                                                           |
| `AssignmnentController`               | Implemented | List jobs & Taking job mechanism (FCFS) via `TicketService`.              |
| `AttendanceController`                | Implemented | Check-in, Check-out, dan Request Extension teknisi.                       |
| `DocumentController`                  | Implemented | Upload dokumen (BAST, dll) dan Generate Surat Tugas.                      |
| `MonitoringController`                | Implemented | Dashboard monitoring harian & Emergency Repool logic.                     |
| `TicketController`                    | Implemented | CRUD Ticket, Validation via FormRequest, Logic via `TicketService`.       |
| **Sales** (ex-Finance)                |             |                                                                           |
| `InvoiceController`                   | Implemented | Draft generation, Approval, & Update Status Invoice via `InvoiceService`. |
| **Master**                            |             |                                                                           |
| `CustomerController`                  | Implemented | CRUD Customer manual & Custom ID Generation mechanism.                    |
| **CustomerService** (ex-Admin)        |             |                                                                           |
| `ReportController`                    | Implemented | KPI Dashboard (Avg Rating per Teknisi).                                   |
| `UserController`                      | Implemented | User Management (CRUD) & Role Assignment.                                 |
| **Api**                               |             |                                                                           |
| `FeedbackController`                  | Implemented | Endpoint public untuk submit feedback/rating.                             |
| `WebhookController`                   | Implemented | Handle incoming webhook (e.g., WA Auto-register).                         |
| **General**                           |             |                                                                           |
| `CalendarController`                  | Implemented | Integrasi create event ke Google Calendar.                                |
| `DashboardController`                 | **EMPTY**   | **Kosong**. Belum ada logic dashboard utama (Home).                       |
| `ProfileController`                   | Implemented | Standard User Profile update (Breeze).                                    |

-   [x] **Sectioning Navigasi (Redirects)**: Admin/CS -> Dashboard, TS -> Assignments, Sales -> Invoices. Implementasi di `AuthenticatedSessionController`.
-   [x] **Strict RBAC Middleware**: Enforce access control on routes via `web.php` groups.
-   [x] **Sidebar Visibility**: Menu items disesuaikan dengan role user (Admin/CS, TS, Sales).

upload dokumen yang diperlukan di list ticket
sidebar untuk rating