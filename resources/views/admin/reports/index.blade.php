@extends('layouts.admin')

@section('main')
    <div class="container-fluid px-4 py-5 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1">Reports & Analysis</h2>
                <p class="text-muted small">Data updated to date {{ date('d/m/Y') }}</p>
            </div>
            <div class="dropdown">
                <button class="btn btn-dark shadow-sm px-4 py-2" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-file-export me-2"></i> Export data
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item py-2" href="{{ route('admin.reports.export.lawyers') }}"><i
                                class="fas fa-user-tie me-2 text-primary"></i> Lawyer Activities</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('admin.reports.export.appointments') }}"><i
                                class="fas fa-calendar-check me-2 text-success"></i>Appointment Schedule List</a></li>
                </ul>
            </div>
        </div>

        <div class="row g-4 mb-5">
            @php
                $stats = [
                    [
                        'label' => 'Total appointment schedule',
                        'value' => $appointmentStats['total'],
                        'icon' => 'fa-calendar',
                        'color' => 'primary',
                    ],
                    [
                        'label' => 'Completed',
                        'value' => $appointmentStats['completed'],
                        'icon' => 'fa-check',
                        'color' => 'success',
                    ],
                    [
                        'label' => 'Confirmed',
                        'value' => $appointmentStats['confirmed'],
                        'icon' => 'fa-check-circle',
                        'color' => 'info',
                    ],
                    [
                        'label' => 'Pending',
                        'value' => $appointmentStats['pending'],
                        'icon' => 'fa-clock',
                        'color' => 'warning',
                    ],
                    [
                        'label' => 'Canceled',
                        'value' => $appointmentStats['cancelled'],
                        'icon' => 'fa-ban',
                        'color' => 'danger',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-uppercase fw-bold text-muted small mb-1">
                                        {{ $stat['label'] }}
                                    </p>
                                    <h3 class="fw-bold mb-0">
                                        {{ number_format($stat['value']) }}
                                    </h3>
                                </div>

                                <div class="rounded-circle bg-{{ $stat['color'] }} text-white
                    d-flex align-items-center justify-content-center"
                                    style="width:48px;height:48px;">
                                    <i class="fa-solid {{ $stat['icon'] }} fa-lg"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold text-dark mb-0">Lawyer Performance (Top 10)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr class="text-muted small">
                                        <th class="border-0 px-4">LAWYER</th>
                                        <th class="border-0 text-center">APPOINTMENT SCHEDULE</th>
                                        <th class="border-0" style="width: 30%;">PROGRESS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lawyerPerformance as $lawyer)
                                        <tr>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold text-dark">{{ $lawyer->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                                    {{ $lawyer->appointments_count }} appointment
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $percent =
                                                        $appointmentStats['total'] > 0
                                                            ? ($lawyer->appointments_count /
                                                                    $appointmentStats['total']) *
                                                                100
                                                            : 0;
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <div class="progress w-100" style="height: 8px;">
                                                        <div class="progress-bar bg-primary shadow-none"
                                                            style="width: {{ $percent }}%"></div>
                                                    </div>
                                                    <span class="ms-2 small text-muted">{{ round($percent) }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold text-dark mb-0">Customer feedback</h5>
                    </div>
                    <div class="card-body scroll-area" style="max-height: 500px; overflow-y: auto;">
                        @forelse($recentFeedbacks as $fb)
                            <div class="p-3 bg-light rounded-3 mb-3 border-start border-primary border-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold small text-dark">{{ $fb->client->name ?? 'Khách ẩn danh' }}</span>
                                    <span class="text-muted" style="font-size: 11px;"><i
                                            class="far fa-clock me-1"></i>{{ $fb->updated_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-muted small mb-2 fst-italic">"{{ Str::limit($fb->feedback, 120) }}"</p>
                                <div class="d-flex align-items-center mt-2">
                                    <i class="fas fa-user-tie text-primary me-2" style="font-size: 12px;"></i>
                                    <span class="small text-primary fw-bold">{{ $fb->lawyer->name }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-comment-slash fa-3x text-light mb-3"></i>
                                <p class="text-muted">No response received yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
