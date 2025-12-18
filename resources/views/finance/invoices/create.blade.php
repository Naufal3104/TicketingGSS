@extends('app')
@section('title', 'Buat Invoice')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <h1 class="h5 mb-6">Buat Draft Invoice</h1>

    <div class="card bg-white border rounded shadow-md col-span-2 lg:col-span-2">
        <div class="card-header border-b border-gray-200">
            <h2 class="font-bold text-gray-800">Detail Tiket & Pembayaran</h2>
        </div>

        <div class="card-body">
            <div class="bg-indigo-50 p-4 rounded mb-6 border border-indigo-100">
                <h3 class="font-bold text-indigo-800 mb-2">Ringkasan Tiket</h3>
                <p class="text-sm"><strong>ID:</strong> {{ $ticket->visit_ticket_id }}</p>
                <p class="text-sm"><strong>Customer:</strong> {{ $ticket->customer->customer_name }}</p>
                <p class="text-sm"><strong>Layanan:</strong> {{ $ticket->issue_category }}</p>
            </div>

            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <input type="hidden" name="visit_ticket_id" value="{{ $ticket->visit_ticket_id }}">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                        Jumlah Dasar (IDR)
                    </label>
                    <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                        <div class="px-3 bg-gray-100 border-r border-gray-300">Rp</div>
                        <input name="amount_base" type="number" class="w-full p-3 text-gray-700 focus:outline-none" placeholder="0" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                        Diskon (IDR)
                    </label>
                    <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                        <div class="px-3 bg-gray-100 border-r border-gray-300">Rp</div>
                        <input name="amount_discount" type="number" class="w-full p-3 text-gray-700 focus:outline-none" placeholder="0" value="0">
                    </div>
                </div>

                <div class="card-footer bg-gray-100 border-t border-gray-200 flex justify-end">
                     <a href="{{ url()->previous() }}" class="btn-gray mr-3 pt-2">Batal</a>
                    <button type="submit" class="btn-bs-primary shadow-md hover:shadow-xl transition-all">
                        <i class="fad fa-file-invoice-dollar mr-2"></i> Generate Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection