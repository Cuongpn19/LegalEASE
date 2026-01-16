@extends('layouts.admin')

@section('main')
    <div class="container-fluid">
        {{-- <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-gray-800 fw-bold text-uppercase">Bảng điều khiển hệ thống</h2>
        </div> --}}

        <div class="row mt-2">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 bg-primary text-white">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Total clients
                                </div>
                                <div class="h5 mb-0 font-weight-bold">{{ $status['total_clients'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 bg-success text-white">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Total
                                    lawyers
                                </div>
                                <div class="h5 mb-0 font-weight-bold">{{ $status['total_lawyers'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 bg-warning text-dark">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Pending
                                </div>
                                <div class="h5 mb-0 font-weight-bold">{{ $status['pending_appointments'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2 bg-info text-white">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Confirmed
                                </div>
                                <div class="h5 mb-0 font-weight-bold">{{ $status['confirmed_appointments'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-pie me-1"></i> Appointment
                            status rate</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="height: 300px;">
                            <canvas id="myPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-0 mt-2">
            <div class="card-header bg-white py-3 border-0">
                <ul class="nav nav-pills card-header-pills" id="adminTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active fw-bold px-4" id="lawyer-tab" data-bs-toggle="tab"
                            data-bs-target="#lawyers" type="button">
                            <i class="fas fa-user-tie me-1"></i> List of Lawyers
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold px-4" id="client-tab" data-bs-toggle="tab" data-bs-target="#clients"
                            type="button">
                            <i class="fas fa-users me-1"></i> List of Clients
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="adminTabsContent">
                    <div class="tab-pane fade show active" id="lawyers" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Full name</th>
                                        <th>Specialization</th>
                                        <th>Location</th>
                                        <th>Experience</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lawyers as $lawyer)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $lawyer->name }}</td>
                                            <td>
                                                @if ($lawyer->specializations->count() > 0)
                                                    {{ $lawyer->specializations->pluck('name')->implode(', ') }}
                                                @else
                                                    <span class="text-muted">Not updated yet</span>
                                                @endif
                                            </td>
                                            <td>{{ $lawyer->lawyerProfile->location ?? 'N/A' }}</td>
                                            <td>{{ $lawyer->lawyerProfile->experience_years ?? 'N/A' }} years</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge rounded-pill {{ $lawyer->status == 'active' ? 'bg-success' : ($lawyer->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                    {{ ucfirst($lawyer->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="clients" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Full name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $client->name }}</td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->clientProfile->phone_number ?? 'N/A' }}</td>
                                            <td>{{ $client->clientProfile->address ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var labels = {!! json_encode($chartData['labels']) !!};
            var dataValues = {!! json_encode($chartData['data']) !!};
            var ctx = document.getElementById('myPieChart').getContext('2d');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataValues,
                        backgroundColor: ['#ffc107', '#0dcaf0', '#198754', '#dc3545'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endsection
