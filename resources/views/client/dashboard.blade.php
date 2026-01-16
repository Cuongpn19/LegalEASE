@extends('layouts.client')
<style>
    /* Hiệu ứng nhấp nhô nhẹ cho icon mặt trời/mặt trăng */
    .animate-bounce {
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }
</style>
@section('main')
    <div class="container py-4">
        {{-- Khối 1: Welcome Banner --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden"
                    style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-center">
                            <div class="col-md-8 text-white">
                                <h1 class="display-6 fw-bold mb-2">
                                    <i class="fas {{ $icon }} me-2 text-warning animate-bounce"></i>
                                    {{ $greeting }}, {{ Auth::user()->name }}!
                                </h1>
                                <p class="lead mb-4 opacity-75">
                                    You have <strong class="text-warning">{{ $stats['upcoming'] }}</strong> confirmed
                                    appointments today.
                                    Need help with a new case?
                                </p>
                                <a href="{{ route('client.lawyers.index') }}"
                                    class="btn btn-warning btn-lg px-4 fw-bold rounded-pill shadow-sm">
                                    <i class="fas fa-search me-2"></i>Find a Professional Lawyer
                                </a>
                            </div>
                            <div class="col-md-4 d-none d-md-flex align-items-center justify-content-end">
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/uploads/contents/business-8598080_640.jpg') }}"
                                        class="img-fluid welcome-img">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Khối 2: Thống kê nhanh (Stats) --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-info-subtle text-info p-3 rounded-3 me-3">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Upcoming</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['upcoming'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success-subtle text-success p-3 rounded-3 me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Completed</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['completed'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-warning-subtle text-warning p-3 rounded-3 me-3">
                            <i class="fas fa-spinner fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pending</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['pending'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Khối 3: Lịch hẹn sắp tới --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Recent Appointments</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small uppercase">
                            <tr>
                                <th class="ps-4">Lawyer</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th class="text-end pe-5">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $app)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-secondary rounded-circle me-3 text-white d-flex align-items-center justify-content-center"
                                                style="width: 35px; height: 35px;">
                                                {{ substr($app->lawyer->name, 0, 1) }}
                                            </div>
                                            <span class="fw-bold">{{ $app->lawyer->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($app->appointment_date)->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $app->start_time }}</small>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $app->status == 'confirmed' ? 'bg-info' : ($app->status == 'pending' ? 'bg-warning text-dark' : ($app->status == 'cancelled' ? 'bg-danger' : 'bg-success')) }}">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-outline-primary view-details-btn"
                                            data-bs-toggle="modal" data-bs-target="#appointmentModal"
                                            data-lawyer="{{ $app->lawyer->name }}"
                                            data-date="{{ \Carbon\Carbon::parse($app->appointment_date)->format('M d, Y') }}"
                                            data-time="{{ $app->start_time }}" data-status="{{ ucfirst($app->status) }}"
                                            data-notes="{{ $app->notes ?? 'No additional notes provided.' }}">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                        <p>No upcoming appointments found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="avatar-lg bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                            style="width: 70px; height: 70px;">
                            <i class="fas fa-file-contract fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-1" id="modalLawyerName"></h4>
                        <span class="badge rounded-pill" id="modalStatus"></span>
                    </div>

                    <div class="bg-light p-3 rounded-4 mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-bold">DATE</span>
                            <span class="fw-bold" id="modalDate"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small fw-bold">TIME</span>
                            <span class="fw-bold" id="modalTime"></span>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="text-muted small fw-bold mb-1 d-block">NOTES</label>
                        <p class="mb-0 text-dark italic border-start border-3 ps-3" id="modalNotes"
                            style="font-style: italic;"></p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 w-100"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appointmentModal = document.getElementById('appointmentModal');

            appointmentModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const lawyer = button.getAttribute('data-lawyer');
                const date = button.getAttribute('data-date');
                const time = button.getAttribute('data-time');
                const status = button.getAttribute('data-status');
                const notes = button.getAttribute('data-notes');

                document.getElementById('modalLawyerName').textContent = lawyer;
                document.getElementById('modalDate').textContent = date;
                document.getElementById('modalTime').textContent = time;
                document.getElementById('modalNotes').textContent = notes;

                const statusBadge = document.getElementById('modalStatus');
                statusBadge.textContent = status;
                statusBadge.className = 'badge rounded-pill '; // Reset class

                if (status === 'Confirmed') statusBadge.classList.add('bg-info');
                else if (status === 'Pending') statusBadge.classList.add('bg-warning');
                else if (status === 'Completed') statusBadge.classList.add('bg-success');
                else statusBadge.classList.add('bg-danger');
            });
        });
    </script>
@endsection
