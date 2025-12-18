@extends('app')
@section('title', 'Daftar Invoice')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h1 class="h5">Daftar Invoice</h1>
        
        </div>

    <div class="card bg-white border rounded shadow-md w-full">
        
        <div class="card-header border-b border-gray-200 flex justify-between items-center p-4">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-bold text-gray-900">{{ $invoices->firstItem() ?? 0 }}</span> - <span class="font-bold text-gray-900">{{ $invoices->lastItem() ?? 0 }}</span> dari <span class="font-bold text-gray-900">{{ $invoices->total() }}</span> data
            </div>
            
            <div class="flex items-center">
                 <form action="{{ route('invoices.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari ID / Customer..." value="{{ request('search') }}" class="border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-indigo-300 transition-all w-40 md:w-64">
                 </form>
            </div>
        </div>

        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                        <th class="px-6 py-4">ID Invoice</th>
                        <th class="px-6 py-4">ID Tiket</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4 text-right">Total (IDR)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    
                    @forelse($invoices as $invoice)
                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                        <td class="px-6 py-4 font-bold text-indigo-600">
                            {{ $invoice->invoice_id }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $invoice->visit_ticket_id }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800 block">{{ $invoice->ticket->customer->customer_name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-right font-mono font-bold">
                            {{ number_format($invoice->amount_final, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusColor = match($invoice->status) {
                                    'PAID' => 'green',
                                    'SENT' => 'blue',
                                    'DRAFT' => 'gray',
                                    'CANCELLED' => 'red',
                                    default => 'gray'
                                };
                            @endphp
                            <span class="bg-{{ $statusColor }}-200 text-{{ $statusColor }}-800 py-1 px-3 rounded-full text-xs font-bold">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $invoice->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('invoices.show', $invoice->invoice_id) }}" class="w-4 mr-2 transform hover:text-indigo-700 hover:scale-110 transition-transform" title="Lihat Detail">
                                    <i class="fad fa-eye"></i>
                                </a>
                                </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data invoice.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="card-footer border-t border-gray-200 bg-gray-50 p-4">
            {{ $invoices->links() }}
        </div>

    </div>
</div>

@endsection