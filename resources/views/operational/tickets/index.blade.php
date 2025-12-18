@extends('app')
@section('title', 'List Tiket Masuk')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h1 class="h5">Data Tiket Masuk</h1>
        
        <a href="{{ route('tickets.create') }}" class="btn-bs-primary shadow-md hover:shadow-xl transition-all mt-4 md:mt-0">
            <i class="fad fa-plus-circle mr-2"></i> Buat Tiket Baru
        </a>
    </div>

    <div class="card bg-white border rounded shadow-md w-full">
        
        <div class="card-header border-b border-gray-200 flex justify-between items-center p-4">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-bold text-gray-900">{{ $tickets->firstItem() ?? 0 }}</span> - <span class="font-bold text-gray-900">{{ $tickets->lastItem() ?? 0 }}</span> dari <span class="font-bold text-gray-900">{{ $tickets->total() }}</span> data
            </div>
            </div>

        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                        <th class="px-6 py-4">ID Tiket</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Kategori Masalah</th>
                        <th class="px-6 py-4 text-center">Prioritas</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Tanggal Dibuat</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    
                    @forelse($tickets as $ticket)
                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                        <td class="px-6 py-4 font-bold text-indigo-600">
                            {{ $ticket->visit_ticket_id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3 text-indigo-700 font-bold text-xs">
                                    {{ substr($ticket->customer->customer_name ?? 'C', 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-bold text-gray-800 block">{{ $ticket->customer->customer_name ?? 'Unknown' }}</span>
                                    <span class="text-xs text-gray-500">{{ $ticket->customer->pic_name ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="block font-semibold">{{ $ticket->issue_category }}</span>
                            <span class="text-xs text-gray-500 truncate w-32 block" title="{{ $ticket->issue_description }}">{{ Str::limit($ticket->issue_description, 30) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $prioColor = match($ticket->priority_level) {
                                    'URGENT' => 'red',
                                    'HIGH' => 'orange',
                                    'MEDIUM' => 'blue',
                                    default => 'gray'
                                };
                            @endphp
                            <span class="bg-{{ $prioColor }}-200 text-{{ $prioColor }}-800 py-1 px-3 rounded-full text-xs font-bold">
                                {{ $ticket->priority_level }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                             @php
                                $statusColor = match($ticket->status) {
                                    'OPEN' => 'green',
                                    'ASSIGNED' => 'blue',
                                    'IN_PROGRESS' => 'yellow',
                                    'COMPLETED' => 'gray',
                                    default => 'gray'
                                };
                            @endphp
                            <span class="bg-{{ $statusColor }}-200 text-{{ $statusColor }}-700 py-1 px-3 rounded-full text-xs font-bold">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $ticket->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('assignments.show', $ticket->visit_ticket_id) }}" class="w-4 mr-2 transform hover:text-indigo-700 hover:scale-110 transition-transform" title="Lihat Detail">
                                    <i class="fad fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada tiket yang dibuat.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="card-footer border-t border-gray-200 bg-gray-50 p-4">
            {{ $tickets->links() }}
        </div>

    </div>
</div>

@endsection