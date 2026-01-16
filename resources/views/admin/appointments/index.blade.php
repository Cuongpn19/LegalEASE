@extends('layouts.admin')
@section('main')
    <div class="container-fluid">

        {{-- KHỐI 1: CÁC NÚT HÀNH ĐỘNG --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('admin.appointments.public.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> Add new appointment
            </a>

            {{-- Nút để ẩn/hiện Form nạp giờ cho gọn --}}
            <button class="btn btn-success shadow-sm" type="button" data-bs-toggle="collapse"
                data-bs-target="#availabilityForm">
                <i class="fas fa-clock me-1"></i> Schedule lawyer availability
            </button>
        </div>

        {{-- KHỐI 2: FORM NẠP GIỜ RẢNH (AVALABILITY) - Đặt ở đây --}}
        <div class="collapse mb-4" id="availabilityForm">
            <div class="card card-body shadow-sm border-0">
                <h5 class="card-title mb-3">Setting & Listing Available Slots</h5>

                <form action="{{ route('admin.availabilities.store') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="small fw-bold">Choose Lawyer</label>
                            <select name="lawyer_id" class="form-select" required>
                                @foreach ($lawyers as $lawyer)
                                    <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="small fw-bold">Days</label>
                            <select name="day_of_week" class="form-select" required>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="small fw-bold">Start</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="small fw-bold">End</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100 text-white">Open during free hours</button>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Lawyer</th>
                                <th>Day</th>
                                <th>Time frame</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Lấy danh sách giờ rảnh để hiện thị (nên làm ở Controller nhưng có thể lấy nhanh ở đây)
                                $allAvailabilities = \App\Models\Availabilities::with('lawyer')
                                    ->orderBy('lawyer_id')
                                    ->get();
                            @endphp
                            @forelse($allAvailabilities as $avai)
                                <tr>
                                    <td>{{ $avai->lawyer->name }}</td>
                                    <td>{{ $avai->day_of_week }}</td>
                                    <td>{{ substr($avai->start_time, 0, 5) }} - {{ substr($avai->end_time, 0, 5) }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.availabilities.edit', $avai->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <form action="{{ route('admin.availabilities.destroy', $avai->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this time frame?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted small">No available time slots have
                                        been created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KHỐI 3: DANH SÁCH LỊCH HẸN --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="ps-3">Client</th>
                            <th>Lawyer</th>
                            <th class="text-center">Appointment date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Notes</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $app)
                            <tr>
                                <td>{{ $app->client->name }}</td>
                                <td>{{ $app->lawyer->name }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($app->appointment_date)->format('d/m/Y') }}
                                    <span class="badge bg-light text-dark">{{ $app->start_time }}</span>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge
                                {{ $app->status == 'confirmed'
                                    ? 'bg-info'
                                    : ($app->status == 'pending'
                                        ? 'bg-warning'
                                        : ($app->status == 'cancelled'
                                            ? 'bg-danger'
                                            : 'bg-success')) }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $app->notes ?? 'N/A' }}</td>

                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <div class="input-group input-group-sm" style="width: 130px;">
                                            <form action="{{ route('admin.appointments.updateStatus', $app->id) }}"
                                                method="POST" class="w-100">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()"
                                                    class="form-select form-select-sm border-secondary shadow-sm">
                                                    <option value="pending"
                                                        {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="confirmed"
                                                        {{ $app->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                                    </option>
                                                    <option value="completed"
                                                        {{ $app->status == 'completed' ? 'selected' : '' }}>Completed
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $app->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                    </option>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            {{-- Nút Chỉnh sửa --}}
                                            <a href="{{ route('admin.appointments.edit', $app->id) }}"
                                                class="btn btn-sm btn-outline-primary btn-action-custom"
                                                title="Edit appointment schedule">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Nút Xóa --}}
                                            <form action="{{ route('admin.appointments.destroy', $app->id) }}"
                                                method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger btn-action-custom"
                                                    title="Delete appointment schedule"
                                                    onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No appointments are scheduled.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- THÊM ĐOẠN NÀY ĐỂ HIỂN THỊ PHÂN TRANG --}}
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-center">
                    {{ $appointments->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
