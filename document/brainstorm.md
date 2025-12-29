# Brainstorming: Migrasi Arsitektur Controller ke Service Layer Pattern

Dokumen ini berisi analisis dan rencana strategis untuk mengubah arsitektur aplikasi dari pendekatan _Fat Controller_ (yang tersirat di `controller.md` saat ini) menjadi **Skinny Controller, Fat Service** seperti yang didefinisikan di `arsitektur.md`.

## 1. Analisis Situasi (Gap Analysis)

| Aspek               | Kondisi Saat Ini (`controller.md`)                                                                                                           | Target Arsitektur (`arsitektur.md`)                                                                                               |
| :------------------ | :------------------------------------------------------------------------------------------------------------------------------------------- | :-------------------------------------------------------------------------------------------------------------------------------- |
| **Logika Bisnis**   | Tersebar di banyak method controller (`store`, `update`, dll). Rentan duplikasi antar role (misal: CS dan Admin melakukan logic yang mirip). | Terpusat di **Service Class**. Controller hanya memanggil Service.                                                                |
| **Validasi**        | Kemungkinan besar `$request->validate([...])` langsung di controller.                                                                        | Menggunakan **FormRequest** terpisah untuk validasi input.                                                                        |
| **Query DB**        | Query builder atau Eloquent chain panjang di dalam controller.                                                                               | Menggunakan **Query Scopes** di Model untuk _readability_ dan _reuse_.                                                            |
| **Response**        | `return view()` atau `return response()->json()` dengan data mentah model.                                                                   | Menggunakan **API Resource** (untuk API) atau DTO/ViewModel (untuk View) agar konsisten.                                          |
| **Role Management** | Controller dipisah per folder (`Admin/`, `Operational/`, `Finance/`), tapi logic mungkin ditulis ulang di masing-masing.                     | Folder Controller tetap dipisah untuk _Clean Routing_ & _Middleware_, tapi semua memanggil **Service yang SAMA** (DRY Principle). |

---

## 2. Strategi Migrasi (The "Best Practice" Plan)

Untuk mencapai arsitektur ideal tanpa merusak fitur yang sudah jalan, kita gunakan pendekatan bertahap (_strangler pattern_ versi mini).

### Phase 1: Standardization (Fondasi)

1.  **FormRequest First**: Pindahkan semua `$request->validate` dari controller ke class `Http/Requests`. Ini langkah paling mudah dan _high impact_.
2.  **API Resources**: Jika ada return JSON, bungkus dengan `Http/Resources`.

### Phase 2: Service Extraction (Inti)

Identifikasi "Kata Kerja Utama" bisnis dan buat Service-nya.

-   **CustomerService**: Handle register (WA/Manual), update profil, soft delete.
-   **TicketService**: Handle create ticket, check quota, assign job, cancel ticket.
-   **AttendanceService**: Handle check-in geometry, check-out, validation.
-   **InvoiceService**: Handle generate, calculation, approval sales.

### Phase 3: Controller Refactoring

Ubah kode controller menjadi sangat tipis.
**Contoh Transformasi `TicketController@store`**:

```php
// Before
public function store(Request $request) {
    $request->validate(...);
    $ticket = new Ticket();
    // ... 20 baris logic set value, cek user login, cek kuota ...
    $ticket->save();
    return redirect(...);
}

// After
public function store(StoreTicketRequest $request, TicketService $service) {
    // 1. Validasi otomatis via FormRequest
    // 2. Logic bisnis via Service
    $result = $service->createTicket($request->validated(), auth()->user());

    // 3. Response
    return redirect()->route(...)->with('success', ...);
}
```

---

## 3. Usulan Struktur Folder (Hasil Refactoring)

Struktur folder controller tetap dipertahankan (karena bagus untuk separasi _entry point_), tapi kita tambahkan layer baru:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/         (UI Admin - hanya panggil Service)
│   │   ├── Operational/   (UI TS - hanya panggil Service)
│   │   ├── Finance/       (UI Sales - hanya panggil Service)
│   │   └── Api/           (Entry point WA/Mobile - hanya panggil Service)
│   ├── Requests/          (Validasi terpusat)
│   │   ├── Operational/
│   │   │   ├── StoreTicketRequest.php
│   │   │   └── CheckInRequest.php
│   │   └── ...
│   └── Resources/         (Format JSON standar)
│
├── Services/              (JANTUNG APLIKASI)
│   ├── TicketService.php
│   ├── CustomerService.php
│   ├── AttendanceService.php
│   └── Finance/
│       └── InvoiceService.php
│
└── Models/                (Dengan Scopes)
    └── VisitTicket.php (scopeOpen(), scopeAssignedTo($user))
```

## 4. Rencana Eksekusi: Strangler Pattern (Penerapan pada Fitur Existing)

Mengingat **InvoiceController** dan **TicketController** sudah dikerjakan (memiliki fitur dasar CRUD), kita akan menerapkan **Strangler Pattern** untuk memigrasinya ke arsitektur baru tanpa merombak ulang dari nol.
