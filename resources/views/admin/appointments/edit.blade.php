@extends('layouts.admin')
@section('main')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-check me-2"></i> EDIT APPOINTMENT</h5>
                    </div>
                    <div class="card-body p-4">
                        {{-- Thông tin tóm tắt khách hàng & luật sư --}}
                        <div class="alert alert-light border mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">Client:</span>
                                <strong class="text-dark">{{ $appointment->client->name ?? 'N/A' }}</strong>
                            </div>
                            <div class="text-end">
                                <span class="text-muted small d-block">Lawyer:</span>
                                <strong class="text-dark">{{ $appointment->lawyer->name ?? 'N/A' }}</strong>
                            </div>
                        </div>

                        <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                {{-- Ngày hẹn --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="fas fa-calendar-alt text-primary me-1"></i>
                                        Appointment date</label>
                                    <input type="date" name="appointment_date"
                                        value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}"
                                        class="form-control form-control-lg shadow-sm">
                                </div>

                                {{-- Giờ hẹn --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="fas fa-clock text-primary me-1"></i>
                                        Appointment time</label>
                                    <select name="start_time" class="form-select form-select-lg shadow-sm">
                                        @foreach (['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                            <option value="{{ $time }}"
                                                {{ $appointment->start_time == $time ? 'selected' : '' }}>
                                                {{ $time }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Ghi chú --}}
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold"><i class="fas fa-sticky-note text-primary me-1"></i>
                                        Internal notes</label>
                                    <textarea name="notes" class="form-control shadow-sm" rows="4"
                                        placeholder="Nhập ghi chú chi tiết về cuộc hẹn...">{{ $appointment->notes }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.appointments.index') }}"
                                    class="btn btn-outline-secondary px-4 shadow-sm">
                                    <i class="fas fa-arrow-left me-1"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary px-5 fw-bold shadow">
                                    <i class="fas fa-save me-1"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
