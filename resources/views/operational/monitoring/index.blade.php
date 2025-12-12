@extends('layouts.app')

@section('title', 'Monitoring Kunjungan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="py-3 mb-0"><span class="text-muted fw-light">Operational /</span> Monitoring</h4>
        <span class="badge bg-label-primary">{{ \Carbon\Carbon::parse($today)->format('d F Y') }}</span>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-calendar"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $stats['total'] }}</h4>
                    </div>
                    <p class="mb-1">Total Kunjungan</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-run"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $stats['on_site'] }}</h4>
                    </div>
                    <p class="mb-1">On Site (Sedang Dikerjakan)</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $stats['completed'] }}</h4>
                    </div>
                    <p class="mb-1">Selesai</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-time"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $stats['pending'] }}</h4>
                    </div>
                    <p class="mb-1">Belum Jalan / Pending</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <h5 class="card-header">Jadwal Hari Ini</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Jam</th>
                        <th>Ticket ID</th>
                        <th>TS</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Check-in</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todaysVisits as $visit)
                    @php
                    // Emergency Check logic for UI
                    $isLate = false;
                    if($visit->status == 'ASSIGNED' && \Carbon\Carbon::parse($visit->visit_date . ' ' . $visit->visit_time)->addMinutes(30)->isPast()) {
                    $isLate = true;
                    }
                    @endphp
                    <tr class="{{ $isLate ? 'table-danger' : '' }}">
                        <td><strong>{{ \Carbon\Carbon::parse($visit->visit_time)->format('H:i') }}</strong></td>
                        <td>{{ $visit->visit_ticket_id }}</td>
                        <td>
                            @if($visit->assignment)
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-xs me-2">
                                        <span class="avatar-initial rounded-circle bg-label-secondary">{{ substr($visit->assignment->ts->name ?? 'T', 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-truncate">{{ $visit->assignment->ts->name ?? 'Unknown' }}</span>
                                </div>
                            </div>
                            @else
                            <span class="badge bg-label-secondary">Belum Diambil</span>
                            @endif
                        </td>
                        <td>{{ $visit->customer->name ?? '-' }}</td>
                        <td>
                            @if($isLate)
                            <span class="badge bg-danger blink">LATE CHECK-IN</span>
                            @else
                            <span class="badge bg-label-{{ $visit->status == 'COMPLETED' ? 'success' : ($visit->status == 'IN_PROGRESS' ? 'primary' : 'warning') }}">
                                {{ $visit->status }}
                            </span>
                            @endif
                        </td>
                        <td>
                            {{-- Assuming check-in time is in attendance relation, but we didn't eager load it here. 
                                     But status IN_PROGRESS implies checking in. 
                                     For MVP, just show status. --}}
                            @if($visit->status == 'IN_PROGRESS')
                            <i class="bx bx-check text-success"></i>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <a href="{{ route('assignments.show', $visit->visit_ticket_id) }}" class="btn btn-sm btn-icon btn-outline-secondary" title="View Detail">
                                    <i class="bx bx-show"></i>
                                </a>

                                @if($visit->status == 'COMPLETED')
                                @if($visit->invoice)
                                <a href="{{ route('invoices.show', $visit->invoice->invoice_id) }}" class="btn btn-sm btn-icon btn-outline-success" title="View Invoice">
                                    <i class="bx bx-file"></i>
                                </a>
                                @else
                                <a href="{{ route('invoices.create', ['ticket_id' => $visit->visit_ticket_id]) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Create Invoice">
                                    <i class="bx bx-money"></i>
                                </a>
                                @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada jadwal kunjungan hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection