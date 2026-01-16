@extends('layouts.client')

@section('main')
    <div class="container py-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0"><i class="fas fa-calendar-check me-2 text-primary"></i>My Appointments</h2>
                <p class="text-muted small mb-0">Manage your legal consultation schedule</p>
            </div>
            <a href="{{ route('client.lawyers.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i>Book New
            </a>
        </div>

        {{-- Appointment Table Card --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 ps-3">Lawyer</th>
                            <th class="border-0">Schedule</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $apt)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-soft-primary rounded-circle me-3 d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px; background: #f0f4ff;">
                                            <i class="fas fa-user-tie text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $apt->lawyer->name }}</h6>
                                            <small
                                                class="text-muted">{{ $apt->lawyer->lawyerProfile->specialization ?? 'General Lawyer' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <span class="d-block fw-bold text-dark"><i
                                                class="far fa-calendar-alt me-1 text-primary"></i>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('M d, Y') }}</span>
                                        <span class="text-muted"><i
                                                class="far fa-clock me-1"></i>{{ $apt->start_time }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusBadge = [
                                            'pending' => 'bg-warning text-dark',
                                            'confirmed' => 'bg-info text-white',
                                            'completed' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white',
                                        ];
                                    @endphp
                                    <span
                                        class="badge rounded-pill {{ $statusBadge[$apt->status] ?? 'bg-secondary' }} px-3 py-2">
                                        {{ ucfirst($apt->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Nút Hủy (Chỉ hiện khi chưa diễn ra) --}}
                                        @if (in_array($apt->status, ['pending', 'confirmed']))
                                            <form action="{{ route('client.appointments.cancel', $apt->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Nút Đánh giá (Chỉ hiện khi đã hoàn thành và chưa đánh giá) --}}
                                        @if ($apt->status == 'completed' && !$apt->review)
                                            <button type="button"
                                                class="btn btn-sm btn-warning rounded-pill px-3 fw-bold shadow-sm"
                                                data-bs-toggle="modal" data-bs-target="#reviewModal{{ $apt->id }}">
                                                <i class="fas fa-star me-1"></i>Review
                                            </button>
                                        @endif

                                        @if ($apt->status == 'cancelled' || ($apt->status == 'completed' && $apt->review))
                                            <span class="text-muted small italic">No actions available</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1432/1432414.png" width="80"
                                        class="mb-3 opacity-25">
                                    <p class="text-muted">You don't have any appointments scheduled yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $appointments->links() }}
        </div>
    </div>

    {{-- Modals Loop --}}
    @foreach ($appointments as $apt)
        @if ($apt->status == 'completed' && !$apt->review)
            <div class="modal fade" id="reviewModal{{ $apt->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <form action="{{ route('client.reviews.store', $apt->id) }}" method="POST">
                            @csrf
                            <div class="modal-header border-0 pb-0">
                                <h5 class="fw-bold"><i class="fas fa-pen-nib me-2 text-warning"></i>Write a Review</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body pt-3">
                                <p class="text-muted mb-4 small text-center">Your feedback helps
                                    <strong>{{ $apt->lawyer->name }}</strong> improve their service.</p>

                                <div class="mb-4 text-center">
                                    <label class="form-label d-block fw-bold mb-3">Rating Score</label>
                                    <select name="rating"
                                        class="form-select border-0 bg-light rounded-pill px-4 py-2 mx-auto"
                                        style="max-width: 300px;">
                                        <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                                        <option value="4">⭐⭐⭐⭐ (Good)</option>
                                        <option value="3">⭐⭐⭐ (Average)</option>
                                        <option value="2">⭐⭐ (Poor)</option>
                                        <option value="1">⭐ (Very Bad)</option>
                                    </select>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold">Detailed Feedback</label>
                                    <textarea name="comment" class="form-control border-0 bg-light" rows="4" style="border-radius: 15px;"
                                        placeholder="Share your experience with this lawyer..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-4 pt-0">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                                    Post Review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
