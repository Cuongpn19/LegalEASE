@extends('layouts.admin')

@section('main')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Header tinh tế hơn --}}
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark mb-1">New Consultation Appointment</h2>
                    <p class="text-muted">Fill in the details below to log a new legal session.</p>
                </div>

                <form action="{{ route('admin.appointments.public.store') }}" method="POST"
                    class="card-booking p-4 p-md-5 bg-white shadow">
                    @csrf

                    {{-- Bước 1: Đối tượng --}}
                    <div class="form-section-title">
                        <h5 class="fw-bold m-0 text-uppercase">1. Client Selection</h5>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Search Existing Client</label>
                            <select name="client_id" class="form-select form-select-lg" required>
                                <option value="">Select a client...</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }} (ID: #{{ $client->id }}) - {{ $client->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Bước 2: Phân bổ --}}
                    <div class="form-section-title">
                        <h5 class="fw-bold m-0 text-uppercase">2. Lawyer & Schedule</h5>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Assign Lawyer</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-user-tie"></i></span>
                                <select name="lawyer_id" class="form-select form-select-lg border-start-0" required>
                                    <option value="" disabled selected>Select lawyer...</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}">Mr/Ms. {{ $lawyer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Select Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="fas fa-calendar-alt"></i></span>
                                <input type="date" name="appointment_date"
                                    class="form-control form-control-lg border-start-0" min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        {{-- Time Slots --}}
                        <div class="col-12 mt-4">
                            <label
                                class="form-label small fw-bold text-muted text-uppercase mb-3 d-block text-center">Select
                                Starting Time</label>
                            <div class="row row-cols-2 row-cols-sm-4 g-3">
                                @foreach (['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                    <div class="col">
                                        <input type="radio" name="start_time" id="time-{{ $loop->index }}"
                                            value="{{ $time }}" class="time-slot-item" required>
                                        <label for="time-{{ $loop->index }}" class="time-slot-label">
                                            <i class="far fa-clock me-2"></i> {{ $time }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Bước 3: Nội dung --}}
                    <div class="form-section-title">
                        <h5 class="fw-bold m-0 text-uppercase">3. Consultation Details</h5>
                    </div>

                    <div class="mb-5">
                        <label class="form-label small fw-bold text-muted text-uppercase">Case Summary & Notes</label>
                        <textarea name="notes" class="form-control" rows="4"
                            placeholder="Briefly describe the case or special requirements for this appointment..."></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn btn-dark btn-lg w-100 py-3 fw-bold shadow">
                            CREATE APPOINTMENT <i class="fas fa-check-circle ms-2"></i>
                        </button>
                        <a href="{{ route('admin.appointments.index') }}"
                            class="btn btn-link w-100 mt-3 text-muted text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
