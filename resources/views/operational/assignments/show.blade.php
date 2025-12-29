@extends('app')
@section('title', 'Detail Pekerjaan')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <div class="flex justify-between items-center mb-6">
        <h1 class="h5">Detail Kunjungan #{{ $ticket->visit_ticket_id }}</h1>
        <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-sm font-bold">{{ $ticket->status }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="card bg-white border rounded shadow-md">
            <div class="card-header border-b border-gray-200">
                <h2 class="font-bold text-gray-800">Informasi Tiket</h2>
            </div>
            <div class="card-body p-6">
                {{-- 1. Perbaikan Customer Name --}}
                <div class="mb-4">
                    <label class="block text-gray-500 text-xs uppercase tracking-wider mb-1">Customer</label>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3 text-indigo-700 font-bold text-xs">
                            {{ substr($ticket->customer->instance ?? $ticket->customer->customer_name, 0, 1) }}
                        </div>
                        <div>
                            {{-- Ganti 'name' menjadi 'customer_name' --}}
                            <p class="font-bold text-gray-800 text-lg">{{ $ticket->customer->instance ?? 'Unknown Customer' }}</p>
                            <p class="text-xs text-gray-500">{{ $ticket->customer->customer_name ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- 2. Menampilkan Kebutuhan Kuota --}}
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-500 text-xs uppercase tracking-wider mb-1">Prioritas</label>
                        @php
                        $prioColor = match($ticket->priority_level) {
                        'URGENT' => 'red',
                        'HIGH' => 'orange',
                        'MEDIUM' => 'blue',
                        default => 'gray'
                        };
                        @endphp
                        <span class="text-xs font-bold text-{{ $prioColor }}-600 bg-{{ $prioColor }}-100 py-1 px-2 rounded">
                            {{ $ticket->priority_level }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs uppercase tracking-wider mb-1">Butuh Teknisi</label>
                        <span class="font-bold text-gray-800">
                            <i class="fad fa-users mr-1 text-indigo-500"></i> {{ $ticket->ts_quota_needed }} Orang
                        </span>
                    </div>
                </div>

                {{-- 3. Menampilkan Teknisi yang Bertugas --}}
                <div class="mb-4 bg-gray-50 p-3 rounded border border-gray-100">
                    <label class="block text-gray-500 text-xs uppercase tracking-wider mb-2">Teknisi Bertugas (PIC)</label>
                    @forelse($ticket->assignment as $assign)
                    @if($assign->ts)
                    <div class="flex items-center mb-2">
                        <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-2 text-green-700 font-bold text-xs">
                            {{ substr($assign->ts->name, 0, 1) }}
                        </div>
                        <span class="font-semibold text-gray-700 text-sm">
                            {{ $assign->ts->name }}
                        </span>
                    </div>
                    @endif
                    @empty
                    <span class="text-sm text-gray-400 italic">Belum ada teknisi yang mengambil.</span>
                    @endforelse
                </div>

                <div class="mb-4">
                    <label class="block text-gray-500 text-xs uppercase tracking-wider mb-1">Masalah</label>
                    <p class="font-bold text-gray-800">{{ $ticket->issue_category }}</p>
                    <p class="text-gray-600 text-sm mt-1 bg-yellow-50 p-2 ">
                        "{{ $ticket->issue_description }}"
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-500 text-xs uppercase tracking-wider mb-1">Alamat Kunjungan</label>
                    <p class="text-gray-700 text-sm">{{ $ticket->visit_address }}</p>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($ticket->visit_address) }}" target="_blank" class="text-indigo-600 text-sm hover:underline mt-2 inline-flex items-center">
                        <i class="fad fa-map-marked-alt mr-1"></i> Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="card bg-white border rounded shadow-md">
                <div class="card-header border-b border-gray-200">
                    <h2 class="font-bold text-gray-800">Aksi Absensi</h2>
                </div>
                <div class="card-body p-6 text-center">
                    @if($ticket->status == 'ASSIGNED')
                    <button id="btn-checkin" class="btn-bs-primary w-full py-3 shadow-md hover:shadow-xl transition-all">
                        <i class="fad fa-running mr-2"></i> CHECK-IN (Mulai)
                    </button>
                    @elseif($ticket->status == 'IN_PROGRESS')
                    <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-3 border border-yellow-200">
                        <i class="fad fa-clock"></i> Sedang dikerjakan...
                    </div>
                    <button id="btn-checkout" class="bg-green-500 hover:bg-green-600 text-white font-bold w-full py-3 rounded shadow-md transition-all">
                        <i class="fad fa-check-circle mr-2"></i> CHECK-OUT (Selesai)
                    </button>
                    @else
                    <div class="bg-green-100 text-green-800 p-3 rounded border border-green-200">
                        <i class="fad fa-check"></i> Pekerjaan Selesai
                    </div>
                    @endif
                </div>
            </div>

            <div class="card bg-white border rounded shadow-md">
                <div class="card-header border-b border-gray-200 flex justify-between items-center">
                    <h2 class="font-bold text-gray-800">Dokumen</h2>
                    <a href="{{ route('documents.surat-tugas', $ticket->visit_ticket_id) }}" class="text-sm text-gray-600 hover:text-indigo-600">
                        <i class="fad fa-file-download"></i> Surat Tugas
                    </a>
                </div>
                <div class="card-body p-6">
                    <ul class="mb-4 space-y-2">
                        @forelse($ticket->documents as $doc)
                        <li class="flex justify-between items-center bg-gray-50 p-2 rounded">
                            <a href="{{ $doc->file_url }}" target="_blank" class="text-indigo-600 font-semibold text-sm hover:underline">
                                {{ $doc->file_name }}
                            </a>
                            <span class="text-xs text-gray-500">{{ $doc->document_type }}</span>
                        </li>
                        @empty
                        <li class="text-gray-500 text-sm italic">Belum ada dokumen diupload.</li>
                        @endforelse
                    </ul>

                    @if(in_array($ticket->status, ['IN_PROGRESS', 'ASSIGNED']))
                    <form id="upload-form" class="mt-4 pt-4 border-t border-gray-100">
                        @csrf
                        <input type="hidden" name="visit_ticket_id" value="{{ $ticket->visit_ticket_id }}">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload Bukti</label>
                        <select name="document_type" class="w-full border border-gray-300 rounded p-2 text-sm mb-2 bg-white">
                            <option value="BAST_SIGNED">BAST (Tanda Tangan)</option>
                            <option value="EVIDENCE_PHOTO">Foto Bukti</option>
                        </select>
                        <input type="file" name="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mb-2" />
                        <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition-all">
                            Upload
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ... Copy logic JS dari file sebelumnya ...
    // Pastikan route('attendance.checkIn') dsb tetap ada.
</script>
@endpush

@endsection