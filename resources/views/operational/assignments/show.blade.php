@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Operational /</span> Visit Detail</h4>

    <div class="row">
        <!-- Ticket Info -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ticket #{{ $ticket->visit_ticket_id }}</h5>
                    <span class="badge bg-{{ $ticket->status == 'OPEN' ? 'success' : ($ticket->status == 'IN_PROGRESS' ? 'warning' : 'primary') }}">
                        {{ $ticket->status }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Customer</label>
                        <p class="fw-bold">{{ $ticket->customer->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Alamat Kunjungan</label>
                        <p>{{ $ticket->visit_address }}</p>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($ticket->visit_address) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-map me-1"></i> Buka Maps
                        </a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Issue</label>
                        <p><strong>{{ $ticket->issue_category }}</strong>: {{ $ticket->issue_description }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Jadwal</label>
                        <p>{{ $ticket->visit_date }} {{ $ticket->visit_time }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action & Documents -->
        <div class="col-md-6 mb-4">
            <!-- 1. Attendance Action -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Absensi & Status</h5>
                </div>
                <div class="card-body text-center">
                    @if($ticket->status == 'ASSIGNED')
                    <button id="btn-checkin" class="btn btn-lg btn-primary w-100 mb-2">
                        <i class="bx bx-run me-2"></i> CHECK-IN (Start Job)
                    </button>
                    <small class="text-muted">Pastikan Anda sudah di lokasi.</small>
                    @elseif($ticket->status == 'IN_PROGRESS')
                    <div class="alert alert-warning">Sedang dikerjakan...</div>
                    <button id="btn-checkout" class="btn btn-lg btn-success w-100">
                        <i class="bx bx-check-circle me-2"></i> CHECK-OUT (Finish)
                    </button>
                    @else
                    <div class="alert alert-info">Pekerjaan Selesai / On Hold</div>
                    @endif
                </div>
            </div>

            <!-- 2. Documents -->
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Dokumen Kunjungan</h5>
                    <a href="{{ route('documents.surat-tugas', $ticket->visit_ticket_id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                        <i class="bx bx-download me-1"></i> Surat Tugas
                    </a>
                </div>
                <div class="card-body">
                    <!-- List -->
                    <ul class="list-group list-group-flush mb-3" id="doc-list">
                        @forelse($ticket->documents as $doc)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-label-secondary me-2">{{ $doc->document_type }}</span>
                                <a href="{{ $doc->file_url }}" target="_blank" class="text-body fw-semibold">{{ $doc->file_name }}</a>
                            </div>
                            <small class="text-muted">{{ $doc->created_at->format('d/m H:i') }}</small>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Belum ada dokumen.</li>
                        @endforelse
                    </ul>

                    <!-- Upload Form -->
                    @if(in_array($ticket->status, ['IN_PROGRESS', 'ASSIGNED']))
                    <form id="upload-form" class="mt-3">
                        @csrf
                        <input type="hidden" name="visit_ticket_id" value="{{ $ticket->visit_ticket_id }}">

                        <div class="mb-3">
                            <label class="form-label">Upload Dokumen</label>
                            <div class="input-group">
                                <select class="form-select" name="document_type" required>
                                    <option value="BAST_SIGNED">BAST (Signed)</option>
                                    <option value="EVIDENCE_PHOTO">Foto Bukti</option>
                                    <option value="OTHER">Lainnya</option>
                                </select>
                                <input type="file" class="form-control" name="file" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-upload me-1"></i> Upload
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
    document.addEventListener('DOMContentLoaded', function() {

        // Helper: Get Location
        function getLocation(callback) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => callback(position.coords),
                    (error) => {
                        alert("Gagal mendapatkan lokasi: " + error.message);
                        // For Dev/Testing without https, maybe allow bypass or mock?
                        // callback({latitude: -6.200000, longitude: 106.816666}); 
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Check-in
        const btnCheckin = document.getElementById('btn-checkin');
        if (btnCheckin) {
            btnCheckin.addEventListener('click', function() {
                if (!confirm('Anda yakin ingin Check-in sekarang?')) return;

                this.disabled = true;
                this.innerHTML = '<i class="bx bx-loader bx-spin"></i> Getting Location...';

                getLocation((coords) => {
                    fetch('{{ route("attendance.checkIn") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                visit_ticket_id: '{{ $ticket->visit_ticket_id }}',
                                latitude: coords.latitude,
                                longitude: coords.longitude
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert('Error: ' + data.message);
                                btnCheckin.disabled = false;
                                btnCheckin.textContent = 'CHECK-IN (Start Job)';
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Terjadi kesalahan sistem.');
                            btnCheckin.disabled = false;
                        });
                });
            });
        }

        // Check-out
        const btnCheckout = document.getElementById('btn-checkout');
        if (btnCheckout) {
            btnCheckout.addEventListener('click', function() {
                if (!confirm('Pekerjaan selesai?')) return;

                this.disabled = true;
                this.innerHTML = '<i class="bx bx-loader bx-spin"></i> Processing...';

                getLocation((coords) => {
                    fetch('{{ route("attendance.checkOut") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                visit_ticket_id: '{{ $ticket->visit_ticket_id }}',
                                latitude: coords.latitude,
                                longitude: coords.longitude,
                                status_update: 'COMPLETED_PENDING_DOCS'
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert('Error: ' + data.message);
                                btnCheckout.disabled = false;
                            }
                        });
                });
            });
        }

        // Upload
        const uploadForm = document.getElementById('upload-form');
        if (uploadForm) {
            uploadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = this.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = '<i class="bx bx-loader bx-spin"></i> Uploading...';

                const formData = new FormData(this);

                fetch('{{ route("documents.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Upload berhasil!');
                            location.reload();
                        } else {
                            alert('Upload gagal: ' + data.message);
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bx bx-upload me-1"></i> Upload';
                        }
                    })
                    .catch(err => {
                        alert('Request failed');
                        btn.disabled = false;
                    });
            });
        }
    });
</script>
@endpush
@endsection