@extends('app')
@section('title', 'Invoice #' . $invoice->invoice_id)
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <div class="flex justify-between items-center mb-6">
        <h1 class="h5">Invoice Detail</h1>
        <button onclick="window.print()" class="bg-gray-800 text-white py-2 px-4 rounded shadow hover:bg-gray-900 transition-all">
            <i class="fad fa-print mr-2"></i> Print / PDF
        </button>
    </div>

    <div class="card bg-white border rounded shadow-lg w-full max-w-4xl mx-auto p-8">
        
        <div class="flex justify-between items-start border-b-2 border-gray-800 pb-6 mb-6">
            <div>
                <h2 class="text-4xl font-extrabold text-gray-800 tracking-wide">INVOICE</h2>
                <span class="inline-block mt-2 px-3 py-1 rounded bg-gray-200 text-gray-800 text-sm font-bold">
                    {{ $invoice->status }}
                </span>
            </div>
            <div class="text-right">
                <h3 class="font-bold text-xl text-gray-800">GSS Ticketing</h3>
                <p class="text-gray-500 text-sm">Jl. Teknologi No. 12<br>Jakarta, Indonesia</p>
            </div>
        </div>

        <div class="flex justify-between mb-8">
            <div>
                <p class="text-gray-500 text-xs uppercase font-bold mb-1">Ditagihkan Kepada:</p>
                <p class="font-bold text-lg text-gray-800">{{ $invoice->ticket->customer->customer_name }}</p>
                <p class="text-gray-600 text-sm">{{ $invoice->ticket->customer->customer_address ?? 'Alamat tidak tersedia' }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm"><span class="font-bold text-gray-600">No. Invoice:</span> {{ $invoice->invoice_id }}</p>
                <p class="text-sm"><span class="font-bold text-gray-600">Tanggal:</span> {{ $invoice->created_at->format('d M Y') }}</p>
                <p class="text-sm"><span class="font-bold text-gray-600">Ref Tiket:</span> {{ $invoice->visit_ticket_id }}</p>
            </div>
        </div>

        <table class="w-full mb-8">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-3 text-gray-600 uppercase text-xs font-bold">Deskripsi Layanan</th>
                    <th class="text-right py-3 text-gray-600 uppercase text-xs font-bold">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-100">
                    <td class="py-4">
                        <p class="font-bold text-gray-800">Jasa Kunjungan Teknisi</p>
                        <p class="text-sm text-gray-500">{{ $invoice->ticket->issue_category }} - {{ $invoice->ticket->issue_description }}</p>
                    </td>
                    <td class="text-right py-4 font-bold text-gray-800">
                        Rp {{ number_format($invoice->amount_base, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-end mb-8">
            <div class="w-1/2 lg:w-1/3">
                <div class="flex justify-between mb-2 text-gray-600 text-sm">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($invoice->amount_base, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-2 text-red-500 text-sm">
                    <span>Diskon</span>
                    <span>- Rp {{ number_format($invoice->amount_discount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-t border-gray-800 pt-3 mt-2">
                    <span class="font-bold text-xl text-gray-800">Total</span>
                    <span class="font-bold text-xl text-gray-800">Rp {{ number_format($invoice->amount_final, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 -mx-8 -mb-8 p-6 rounded-b flex items-center justify-between border-t border-gray-200">
            <form action="{{ route('invoices.update', $invoice->invoice_id) }}" method="POST" class="flex items-center">
                @csrf
                @method('PUT')
                <label class="mr-3 font-bold text-sm text-gray-700">Update Status:</label>
                <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded p-2 text-sm bg-white focus:outline-none focus:border-indigo-500">
                    <option value="DRAFT" {{ $invoice->status == 'DRAFT' ? 'selected' : '' }}>DRAFT</option>
                    <option value="SENT" {{ $invoice->status == 'SENT' ? 'selected' : '' }}>SENT</option>
                    <option value="PAID" {{ $invoice->status == 'PAID' ? 'selected' : '' }}>PAID</option>
                    <option value="CANCELLED" {{ $invoice->status == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                </select>
            </form>
            <p class="text-xs text-gray-400 italic">Dibuat otomatis oleh sistem GSS Ticketing</p>
        </div>
    </div>
</div>
@endsection