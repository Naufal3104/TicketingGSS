@extends('app')
@section('title', 'Monitoring Operasional')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <div class="flex justify-between items-center mb-6">
        <h1 class="h5">Monitoring Kunjungan Hari Ini</h1>
        <span class="bg-indigo-100 text-indigo-800 py-1 px-3 rounded text-sm font-bold">
            {{ \Carbon\Carbon::parse($today)->format('d F Y') }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="card bg-white border rounded shadow-md p-4 flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fad fa-calendar-alt text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm uppercase font-bold">Total</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
        </div>
        <div class="card bg-white border rounded shadow-md p-4 flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <i class="fad fa-running text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm uppercase font-bold">On Site</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['on_site'] }}</p>
            </div>
        </div>
        <div class="card bg-white border rounded shadow-md p-4 flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <i class="fad fa-check-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm uppercase font-bold">Selesai</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['completed'] }}</p>
            </div>
        </div>
        <div class="card bg-white border rounded shadow-md p-4 flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                <i class="fad fa-clock text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm uppercase font-bold">Pending</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
            </div>
        </div>
    </div>

    <div class="card bg-white border rounded shadow-md w-full">
        <div class="card-header border-b border-gray-200 p-4">
            <h2 class="font-bold text-gray-800">Jadwal Real-time</h2>
        </div>
        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                        <th class="px-6 py-4">Jam</th>
                        <th class="px-6 py-4">ID Tiket</th>
                        <th class="px-6 py-4">Teknisi (TS)</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($todaysVisits as $visit)
                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                        <td class="px-6 py-4 font-bold">{{ \Carbon\Carbon::parse($visit->visit_time)->format('H:i') }}</td>
                        <td class="px-6 py-4">{{ $visit->visit_ticket_id }}</td>
                        <td class="px-6 py-4">
                            @if($visit->assignment)
                                <span class="font-bold text-gray-800">{{ $visit->assignment->ts->name ?? 'TS' }}</span>
                            @else
                                <span class="italic text-gray-400">Belum diambil</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $visit->customer->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs font-bold">
                                {{ $visit->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('assignments.show', $visit->visit_ticket_id) }}" class="text-indigo-600 hover:text-indigo-900 mx-1">
                                <i class="fad fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada jadwal hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection