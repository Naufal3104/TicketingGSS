# 🏗️ Laravel Architecture Best Practices

Prinsip **"Skinny Controller, Fat Model/Service"** membantu menjaga kode tetap bersih, modular, dan mudah dirawat. Berikut adalah 4 pilar utamanya:

---

## 🛡️ 1. Validasi: FormRequest

> **Jangan biarkan Controller mengurusi validasi data mentah.**

| Aspek       | Penjelasan                                                                                    |
| :---------- | :-------------------------------------------------------------------------------------------- |
| **Masalah** | Controller penuh dengan `$request->validate([...])`. Sulit dibaca jika rule validasi panjang. |
| **Solusi**  | Pindahkan logic ke class **FormRequest**.                                                     |
| **Manfaat** | Controller lebih bersih & logic validasi bisa di-reuse di tempat lain.                        |

**Contoh:**

```php
// ❌ Before (Controller)
public function store(Request $request) {
    $request->validate(['title' => 'required|max:255', 'body' => 'required']);
    // ... logic simpan
}

// ✅ After (Controller)
public function store(StorePostRequest $request) {
    // Data otomatis valid di sini. Controller fokus ke proses bisnis.
    // ... logic simpan
}
```

---

## 🧠 2. Logika Bisnis: Service / Action Classes

> **Controller hanya "Traffic Police", bukan "Worker".**

| Aspek       | Penjelasan                                                                            |
| :---------- | :------------------------------------------------------------------------------------ |
| **Masalah** | Controller menangani logic kompleks (e.g. hitung pajak + update stok + kirim email).  |
| **Solusi**  | Pindahkan logic tersebut ke **Service Class** atau **Action Class**.                  |
| **Manfaat** | Logic bisa dipanggil dari mana saja (API, CLI, Queue) & mudah di-test (Unit Testing). |

**Contoh:**

```php
// ❌ Before (Controller)
$order->total = $items->sum('price') * 1.1; // Hitung manual
$order->save();
Mail::to($user)->send(new OrderInvoice($order));

// ✅ After (Controller)
$orderService->processCheckout($user, $items); // Delegasi ke ahlinya
```

---

## 🔍 3. Query Kompleks: Query Scopes

> **Buat query database terbaca seperti bahasa manusia.**

| Aspek       | Penjelasan                                                          |
| :---------- | :------------------------------------------------------------------ |
| **Masalah** | Chain query panjang & berulang di berbagai controller.              |
| **Solusi**  | Bungkus logic query ke dalam **Local Scopes** di Model.             |
| **Manfaat** | Code lebih semantik (_readable_) dan DRY (_Don't Repeat Yourself_). |

**Contoh:**

```php
// ❌ Before
$users = User::where('active', 1)->where('created_at', '>', now()->subDays(7))->get();

// ✅ After
$users = User::active()->lastWeek()->get();
```

---

## 📦 4. Format Response: API Resource

> **Pisahkan struktur Database dari struktur JSON Output.**

| Aspek       | Penjelasan                                                                                  |
| :---------- | :------------------------------------------------------------------------------------------ |
| **Masalah** | Return model langsung (`$user`) mengekspos semua kolom DB & format tanggal tidak konsisten. |
| **Solusi**  | Gunakan **API Resource** untuk transformasi data.                                           |
| **Manfaat** | Format JSON konsisten, aman (field sensitif tersembunyi), & fleksibel jika DB berubah.      |

**Contoh:**

```php
// ❌ Before
return response()->json($user); // Mengekspos 'password', 'created_at' apa adanya

// ✅ After
return new UserResource($user); // Output terkontrol: { "id": 1, "name": "Budi", ... }
```

---

## 🎭 5. Multi-Role: Separation of Concerns

> **Satu Core Logic, Banyak Pintu Masuk.**

| Aspek       | Penjelasan                                                                         |
| :---------- | :--------------------------------------------------------------------------------- |
| **Masalah** | Logic sama berulang di controller berbeda-beda role (Admin, User, Manager).        |
| **Solusi**  | **Pisahkan Folder Controller** per Role, gunakan **Service** untuk logic utamanya. |
| **Manfaat** | Struktur folder rapi, akses kontrol jelas, tapi logic bisnis tetap terpusat (DRY). |

**Contoh Struktur:**

```text
app/Http/Controllers/
├── Admin/
│   └── InvoiceController.php  -> Memanggil InvoiceService->approve()
├── Finance/
│   └── InvoiceController.php  -> Memanggil InvoiceService->generate()
└── Customer/
    └── InvoiceController.php  -> Memanggil InvoiceService->download()
```
