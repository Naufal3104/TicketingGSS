<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private function generateId()
    {
        // 1. Ambil customer dengan ID paling besar (terakhir) berdasarkan string
        $latest = Customer::orderBy('customer_id', 'desc')->first();

        // 2. Jika belum ada data sama sekali, mulai dari CUST-001
        if (! $latest) {
            return 'CUST-001';
        }

        // 3. Jika sudah ada, ambil 3 angka terakhir
        // Contoh: CUST-005 -> diambil "005" -> diubah jadi integer 5
        $lastId = $latest->customer_id;

        // Mengambil 3 karakter terakhir dari string ID
        $number = (int) substr($lastId, -3);

        // 4. Tambahkan 1, lalu format ulang jadi 3 digit angka (contoh: 5 jadi 005)
        $newNumber = $number + 1;

        // Format: CUST- diikuti 3 digit angka (str_pad menambahkan nol di depan)
        return 'CUST-'.str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        // Fitur pencarian sederhana
        $query = Customer::query();

        if ($request->has('search')) {
            $query->where('customer_name', 'ilike', '%'.$request->search.'%') // 'ilike' untuk case-insensitive di Postgres
                ->orWhere('customer_id', 'ilike', '%'.$request->search.'%');
        }

        // Pagination 10 data per halaman
        $customers = $query->paginate(10);

        return view('customers-index', compact('customers'));
    }

    // MENAMPILKAN FORM TAMBAH
    public function create()
    {
        // Kita gunakan view yang sama untuk create dan edit, tapi variabel $customer null
        return view('customers-form', ['customer' => null]);
    }

    // MENYIMPAN DATA BARU (CREATE)
    public function store(Request $request)
    {
        // 1. Generate ID lagi di sini untuk keamanan (mencegah duplikat jika ada 2 orang input bersamaan)
        $newId = $this->generateId();

        // 2. Masukkan ID otomatis tersebut ke dalam data Request
        // Ini memaksa data 'customer_id' menjadi yang kita generate, mengabaikan input user
        $request->merge(['customer_id' => $newId]);

        // Validasi input
        $request->validate([
            'customer_id' => 'required|string|max:20|unique:customers,customer_id',
            'customer_name' => 'required|string|max:100',
            'email' => 'nullable|email',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Data Customer berhasil disimpan dengan ID: '.$newId);
    }

    // MENAMPILKAN FORM EDIT
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers-form', compact('customer'));
    }

    // UPDATE DATA (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            // customer_id diabaikan dalam pengecekan unique karena sedang diedit milik sendiri
            'customer_id' => 'required|string|max:20|unique:customers,customer_id,'.$id.',customer_id',
            'customer_name' => 'required|string|max:100',
            'email' => 'nullable|email',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        $customer = Customer::findOrFail($id);
        // Jika ID diubah, kita harus hati-hati, tapi biasanya ID Primary Key jarang diubah.
        // Kode di bawah mengasumsikan ID bisa diedit jika memang diperlukan,
        // tapi Laravel mungkin memblokir update PK secara default tergantung versi.
        // Aman-nya, $request->except('customer_id') jika PK tidak boleh ganti.

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Data Customer berhasil diperbarui.');
    }

    // HAPUS DATA (DELETE)
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Data Customer berhasil dihapus.');
    }
}
