@extends('layouts.admin')
<style>
    .booking-card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }

    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .btn-slot {
        font-weight: 500;
        transition: 0.2s;
        border: 1.5px solid #17a2b8;
    }

    .btn-slot:hover {
        background-color: #17a2b8;
        color: white;
    }

    .slot-booked {
        background-color: #e9ecef;
        color: #6c757d;
        border: 1px dashed #adb5bd;
        cursor: not-allowed;
    }

    .card-header-date {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        border-radius: 12px 12px 0 0 !important;
    }
</style>
@section('main')
    <div class="card shadow border-0">
        <div class="card-header bg-info text-white d-flex justify-content-between">
            <h5 class="mb-0">Lawyer's Profile: {{ $lawyer->name }}</h5>
            <a href="{{ route('admin.lawyers.index') }}" class="btn btn-sm btn-light">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($lawyer->name) }}&size=150"
                        class="rounded-circle shadow mb-3">
                    <h4>{{ $lawyer->name }}</h4>
                    <span
                        class="badge {{ $lawyer->status == 'inactive' ? 'bg-danger' : ($lawyer->lawyerProfile->is_verified ? 'bg-success' : 'bg-warning') }}">
                        {{ $lawyer->status == 'inactive' ? 'Inactive' : ($lawyer->lawyerProfile->is_verified ? 'Approve' : 'Pending') }}
                    </span>
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>Email</th>
                            <td>{{ $lawyer->email }}</td>
                        </tr>
                        <tr>
                            <th>Specialization</th>
                            <td>
                                @if ($lawyer->specializations && $lawyer->specializations->count() > 0)
                                    @foreach ($lawyer->specializations as $spec)
                                        <span class="badge bg-primary">{{ $spec->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Not updated yet</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Experience</th>
                            <td>{{ $lawyer->lawyerProfile->experience_years }} years</td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td>{{ $lawyer->lawyerProfile->location }}</td>
                        </tr>
                        <tr>
                            <th>Rating</th>
                            <td><span class="text-warning">★</span> {{ $lawyer->lawyerProfile->rating }}/5</td>
                        </tr>
                        <tr>
                            <th>Bio</th>
                            <td>{{ $lawyer->lawyerProfile->bio }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr class="my-4">

            <div class="booking-section mt-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-info rounded-circle p-2 me-3">
                        <i class="fas fa-calendar-alt text-white"></i>
                    </div>
                    <h5 class="mb-0 text-dark fw-bold"> Available appointments (within the next 7 days)</h5>
                </div>

                <div class="row g-3">
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $date = now()->addDays($i);
                            $dayNameEnglish = $date->clone()->locale('en')->format('l');
                            // Chỉ lấy các slot rảnh
                            $slots = $lawyer->availabilities->where('day_of_week', $dayNameEnglish);
                            $displayDay = $date->translatedFormat('l');
                        @endphp

                        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                            <div class="card h-100 shadow-sm border-0 booking-card">
                                <div class="card-header text-center card-header-date py-3">
                                    <div class="fw-bold text-info text-capitalize mb-1">{{ $displayDay }}</div>
                                    <div class="h6 mb-0 fw-bold">{{ $date->format('d/m') }}</div>
                                </div>

                                <div class="card-body p-3">
                                    @forelse($slots as $slot)
                                        @php
                                            $currentSlotTime = \Carbon\Carbon::parse($slot->start_time)->format('H:i');
                                            $isBooked = $bookedSlots->first(function ($booked) use (
                                                $date,
                                                $currentSlotTime,
                                            ) {
                                                return \Carbon\Carbon::parse(
                                                    $booked->appointment_date,
                                                )->toDateString() === $date->toDateString() &&
                                                    \Carbon\Carbon::parse($booked->start_time)->format('H:i') ===
                                                        $currentSlotTime;
                                            });
                                        @endphp

                                        @if ($isBooked)
                                            <div class="slot-booked rounded-pill text-center small py-2 mb-2">
                                                <i class="fas fa-lock me-1"></i> {{ $currentSlotTime }}
                                            </div>
                                        @else
                                            <form action="{{ route('appointments.store') }}" method="POST" class="mb-2">
                                                @csrf
                                                <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">
                                                <input type="hidden" name="appointment_date"
                                                    value="{{ $date->toDateString() }}">
                                                <input type="hidden" name="start_time" value="{{ $slot->start_time }}">

                                                <button type="submit"
                                                    class="btn btn-outline-info btn-sm w-100 rounded-pill btn-slot py-2">
                                                    {{ $currentSlotTime }}
                                                </button>
                                            </form>
                                        @endif
                                    @empty
                                        <div class="text-center py-4">
                                            <i class="fas fa-bed text-muted d-block mb-2"></i>
                                            <span class="text-muted x-small">No calendar!</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection
