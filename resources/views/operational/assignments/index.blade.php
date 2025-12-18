@extends('app')
@section('title', 'Job Pool & Tugas Saya')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    
    <div class="flex mb-4 border-b border-gray-300">
        <button class="px-4 py-2 text-gray-700 font-bold border-b-2 border-indigo-500 focus:outline-none" id="btn-pool" onclick="showTab('pool')">
            Open Pool ({{ $openTickets->count() }})
        </button>
        <button class="px-4 py-2 text-gray-500 font-bold hover:text-gray-700 focus:outline-none" id="btn-my" onclick="showTab('my')">
            My Jobs ({{ $myAssignments->count() }})
        </button>
    </div>

    <div id="tab-pool">
        <div class="card bg-white border rounded shadow-md w-full">
            <div class="card-header border-b border-gray-200 p-4">
                <h2 class="font-bold text-gray-800">Daftar Pekerjaan Tersedia</h2>
            </div>
            <div class="card-body p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                            <th class="px-6 py-4">ID Tiket</th>
                            <th class="px-6 py-4">Kategori & Masalah</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4 text-center">Prioritas</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($openTickets as $ticket)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                            <td class="px-6 py-4 font-bold">{{ $ticket->visit_ticket_id }}</td>
                            <td class="px-6 py-4">
                                <span class="block font-bold">{{ $ticket->issue_category }}</span>
                                <span class="text-xs">{{ Str::limit($ticket->issue_description, 50) }}</span>
                            </td>
                            <td class="px-6 py-4">{{ Str::limit($ticket->visit_address, 30) }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $color = $ticket->priority_level == 'URGENT' ? 'red' : ($ticket->priority_level == 'HIGH' ? 'orange' : 'blue');
                                @endphp
                                <span class="bg-{{ $color }}-200 text-{{ $color }}-700 py-1 px-3 rounded-full text-xs font-bold">
                                    {{ $ticket->priority_level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="takeJob('{{ $ticket->visit_ticket_id }}', this)" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-xs font-bold shadow transition-all">
                                    <i class="fad fa-check mr-1"></i> AMBIL
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada pekerjaan tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tab-my" class="hidden">
        <div class="card bg-white border rounded shadow-md w-full">
            <div class="card-header border-b border-gray-200 p-4">
                <h2 class="font-bold text-gray-800">Pekerjaan Saya</h2>
            </div>
            <div class="card-body p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                            <th class="px-6 py-4">ID Tiket</th>
                            <th class="px-6 py-4">Masalah</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($myAssignments as $assignment)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                            <td class="px-6 py-4 font-bold">{{ $assignment->visit_ticket_id }}</td>
                            <td class="px-6 py-4">{{ $assignment->ticket->issue_category }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-indigo-200 text-indigo-700 py-1 px-3 rounded-full text-xs font-bold">
                                    {{ $assignment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('assignments.show', $assignment->visit_ticket_id) }}" class="bg-gray-600 hover:bg-gray-700 text-white py-1 px-3 rounded text-xs font-bold shadow transition-all">
                                    <i class="fad fa-eye mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Anda belum mengambil pekerjaan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    function showTab(tab) {
        document.getElementById('tab-pool').classList.add('hidden');
        document.getElementById('tab-my').classList.add('hidden');
        document.getElementById('btn-pool').classList.remove('border-indigo-500', 'text-gray-700');
        document.getElementById('btn-pool').classList.add('text-gray-500', 'border-transparent');
        document.getElementById('btn-my').classList.remove('border-indigo-500', 'text-gray-700');
        document.getElementById('btn-my').classList.add('text-gray-500', 'border-transparent');

        document.getElementById('tab-' + tab).classList.remove('hidden');
        document.getElementById('btn-' + tab).classList.add('border-indigo-500', 'text-gray-700');
        document.getElementById('btn-' + tab).classList.remove('text-gray-500', 'border-transparent');
    }

    function takeJob(ticketId, btn) {
        if (!confirm('Ambil pekerjaan ini?')) return;
        btn.disabled = true;
        btn.innerText = '...';
        
        fetch("{{ route('assignments.take') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ visit_ticket_id: ticketId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { alert('Berhasil!'); window.location.reload(); }
            else { alert(data.message); btn.disabled = false; btn.innerText = 'AMBIL'; }
        })
        .catch(err => { alert('Error'); btn.disabled = false; });
    }
</script>
@endsection