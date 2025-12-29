# Git History (Backend Branch)

**Range:** `f9d6a8c` to `HEAD` (Backend Tip)

## 📜 Commit Log

| Hash      | Author                    | Date                                                                                           | Message                                                                                                                      |
| :-------- | :------------------------ | :--------------------------------------------------------------------------------------------- | :--------------------------------------------------------------------------------------------------------------------------- |
| `b0292d4` | ilhmstxr                  | 2025-12-29                                                                                     | merge backend punya nopal rebase                                                                                             |
| `421edbd` | ilhmstxr                  | 2025-12-29                                                                                     | nambahin ignore public cleopatra                                                                                             |
| `a4292d0` | ilhmstxr                  | 2025-12-29                                                                                     | nambahin gitignore cleopatra                                                                                                 |
| `557127d` | Naufal3104                | 2025-12-24                                                                                     | tambah fungsi edit ticket, ubah tampilan data semua data ticketing, revisi migration(assignment & attendance), model, seeder |
| `794e7b1` | Naufal3104                | 2025-12-18                                                                                     | buat/ubah tampilan setiap fitur                                                                                              |
| `b6853c8` | Achmad Naufal Ferdiansyah | 2025-12-18                                                                                     | Merge pull request #2 from Naufal3104/backend-api-gss                                                                        |
| `838f361` | ilhmstxr                  | 2025-12-18                                                                                     | cleopatra                                                                                                                    |
| `ffd1631` | ilhmstxr                  | 2025-12-18                                                                                     | feat: Implement invoice management, operational document uploads, and Surat Tugas generation.                                |
| `b15e7af` | ilhmstxr                  | 2025-12-12                                                                                     | nambahin cleopatra & fixing error dikit                                                                                      |
| `5edbcff` | ilhmstxr                  | 2025-12-12 : fixing cleopatra                                                                  |
| `5df15f4` | ilhmstxr                  | 2025-12-12 : feat: add initial database seeders for users, roles, customers, and visit tickets |

## 📂 Changed Files by Component

### 🧠 Controllers & Models

| Type           | Status | File                                                        |
| :------------- | :----- | :---------------------------------------------------------- |
| **Controller** | M      | `app/Http/Controllers/Admin/ReportController.php`           |
| **Controller** | M      | `app/Http/Controllers/Finance/InvoiceController.php`        |
| **Controller** | M      | `app/Http/Controllers/Operational/AssignmentController.php` |
| **Controller** | M      | `app/Http/Controllers/Operational/DocumentController.php`   |
| **Controller** | M      | `app/Http/Controllers/Operational/TicketController.php`     |
| **Model**      | M      | `app/Models/VisitAssignment.php`                            |
| **Model**      | M      | `app/Models/VisitAttendance.php`                            |
| **Model**      | M      | `app/Models/VisitTicket.php`                                |

### 🎨 Views (Frontend & Templates)

| Section         | Status | File                                                                                          |
| :-------------- | :----- | :-------------------------------------------------------------------------------------------- |
| **Layouts**     | M      | `resources/views/app.blade.php`, `navbar.blade.php`, `sidebar.blade.php`, `welcome.blade.php` |
| **Finance**     | M/A    | `resources/views/finance/invoices/` (index, create, show)                                     |
| **Operational** | M/A    | `resources/views/operational/assignments/` (index, show)                                      |
| **Operational** | A      | `resources/views/operational/documents/surat-tugas.blade.php`                                 |
| **Operational** | M      | `resources/views/operational/monitoring/index.blade.php`                                      |
| **Operational** | M/A/D  | `resources/views/operational/tickets/` (form, index, create[D])                               |
| **Module**      | M      | `resources/views/admin/reports/index.blade.php`                                               |

### 🗄️ Database (Migrations & Seeders)

-   M `database/migrations/2025_11_26_053556_create_visit_assignments_table.php`
-   M `database/migrations/2025_11_26_053605_create_visit_attendances_table.php`
-   M `database/seeders/CustomerSeeder.php`
-   M `database/seeders/DatabaseSeeder.php`
-   M `database/seeders/VisitAssignmentSeeder.php`
-   M `database/seeders/VisitAttendanceSeeder.php`
-   M `database/seeders/VisitTicketSeeder.php`

### ⚙️ Config & Assets

-   **Assets (Cleopatra Theme)**:
    -   A `public/cleopatra.rar`
    -   M `public/cleopatra/build/css/style.css`
    -   A `resources/cleopatra/js/scripts.js`
-   **Configuration**:
    -   M `.gitignore`, `composer.json`, `composer.lock`, `package-lock.json`, `tailwind.config.js`, `vite.config.js`
-   **Routes**:
    -   M `routes/web.php`
-   **Documentation**:
    -   M `log-implement.md`
    -   A `module.md`, `routes.md`

---

## 📝 Ringkasan Perubahan

Berikut adalah ringkasan pembaruan berdasarkan perubahan file dan riwayat commit:

1.  **Modul Keuangan & Faktur**:

    -   Mengimplementasikan manajemen Faktur (`InvoiceController`), termasuk tampilan daftar (`index`), pembuatan (`create`), dan detail (`show`).

2.  **Operasional & Tiket**:

    -   **Tiket**: Perubahan besar pada manajemen Tiket (`TicketController`, `VisitTicket`). Beralih dari tampilan `create` ke pendekatan berbasis `form` baru dan menambahkan tampilan `index`.
    -   **Penugasan & Dokumen**: Menambahkan fungsionalitas untuk pembuatan "Surat Tugas" (`surat-tugas.blade.php`) dan meningkatkan penanganan Penugasan/Kehadiran (`VisitAssignment`, `VisitAttendance`, `AssignmentController`).

3.  **Integrasi UI/Tema (Cleopatra)**:

    -   Mengintegrasikan elemen tema "Cleopatra" (aset, layout global, CSS/JS).

4.  **Database & Seeding**:

    -   Menambahkan seeder awal untuk data pengujian (Pelanggan, Penugasan, Tiket).
    -   Memperbaiki migrasi untuk penugasan dan kehadiran.

5.  **Konfigurasi**:
    -   Memperbarui dependensi proyek dan konfigurasi build.


TicketController
InvoiceController