@extends('layouts.client')
<style>
    /* Style khi một slot bị khóa và đã booked */
    .btn-check.booked:disabled+.btn {
        background-color: #e9ecef !important;
        border-color: #dee2e6 !important;
        color: #adb5bd !important;
        text-decoration: line-through;
        cursor: not-allowed;
    }

    /* Inactive slot (disabled but NOT booked) */
    .btn-check.inactive:disabled+.btn {
        background-color: #f8f9fa !important;
        border-color: #dee2e6 !important;
        color: #6c757d !important;
        text-decoration: none;
        cursor: not-allowed;
    }

    .time-slot-input:checked+.btn {
        background-color: #0d6efd !important;
        color: white !important;
    }
</style>
@section('main')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-center mb-4">Book an Appointment</h3>
                        <div class="text-center mb-4">
                            <div class="avatar-md bg-light rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-user-tie fa-2x text-primary"></i>
                            </div>
                            <p class="text-muted mb-0">Lawyer: <strong>{{ $lawyer->name }}</strong></p>
                        </div>

                        <form action="{{ route('client.lawyers.storeBooking') }}" method="POST">
                            @csrf
                            <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Date</label>
                                <input type="date" name="appointment_date"
                                    class="form-control rounded-pill border-0 bg-light px-3"
                                    min="{{ now()->addDay()->format('Y-m-d') }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold d-block text-center mb-3">Select Starting Time</label>
                                <div class="row row-cols-2 row-cols-sm-4 g-3" id="time-slots-container">
                                    @foreach (['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                        <div class="col">
                                            <input type="radio" name="start_time" id="time-{{ $loop->index }}"
                                                value="{{ $time }}:00" class="btn-check time-slot-input inactive"
                                                disabled required>
                                            <label class="btn btn-outline-primary w-100 rounded-pill py-2 shadow-sm fw-bold"
                                                for="time-{{ $loop->index }}">
                                                {{ $time }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Brief Description of Case</label>
                                <textarea name="notes" class="form-control border-0 bg-light" rows="3" style="border-radius: 15px;"
                                    placeholder="Optional..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill fw-bold shadow">
                                Send Booking Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[name="appointment_date"]').on('change', function() {
                let selectedDate = $(this).val();
                let lawyerId = $('input[name="lawyer_id"]').val();

                if (selectedDate) {
                    // Reset tất cả các nút về trạng thái bình thường trước khi check
                    $('.time-slot-input').prop('disabled', false).prop('checked', false).removeClass(
                        'inactive booked');

                    $.ajax({
                        url: "{{ route('client.lawyers.checkAvailability') }}", // Bạn cần tạo route này
                        method: "GET",
                        data: {
                            date: selectedDate,
                            lawyer_id: lawyerId
                        },
                        success: function(bookedTimes) {
                            // bookedTimes trả về mảng ví dụ: ["08:00:00", "10:00:00"]
                            $('.time-slot-input').each(function() {
                                let slotValue = $(this).val();
                                if (bookedTimes.includes(slotValue)) {
                                    $(this).prop('disabled', true);
                                    $(this).addClass(
                                    'booked'); // 🔥 enables strikethrough
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
