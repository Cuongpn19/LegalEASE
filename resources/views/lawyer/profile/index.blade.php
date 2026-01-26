@extends('layouts.lawyer')
@section('main')
    <div class="schedule-card">
        <div class="card-header-custom">
            <i class="fas fa-file-lines"></i>Personal profile
        </div>

        <div class="card-body-custom">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <strong class="me-2 text-nowrap" style="min-width: 120px;">Fullname:</strong>
                        <span class="text-primary fw-bold">{{ $lawyer->user->name ?? '' }}</span>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <strong class="me-2 text-nowrap" style="min-width: 120px;">Experience year:</strong>
                        <span>{{ $lawyer->experience_years ?? 'Not yet updated' }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <strong class="me-2 text-nowrap" style="min-width: 120px;">Specialization:</strong>
                <div class="d-flex flex-wrap gap-2">
                    @if ($lawyer->specializations->isNotEmpty())
                        <span class="badge bg-light text-primary border">
                            {{ $lawyer->specializations->first()->name }}
                        </span>
                    @else
                        <span class="text-muted small">Not specified</span>
                    @endif

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="info-item d-flex align-items-center">
                        <strong class="me-2 text-nowrap" style="min-width: 120px;">Is_verified:</strong>
                        @if ($lawyer->is_verified == 1 || $lawyer->is_verified == true)
                            <span>Đã được xác minh danh tính</span>
                        @else
                            <span>Chưa được xác minh danh tính</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="info-item d-flex align-items-center">
                        <strong class="me-2 text-nowrap" style="min-width: 120px;">Address:</strong>
                        <span>{{ $lawyer->location ?? 'Address not yet updated' }}</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <strong style="min-width: 120px">Rating:</strong>
                        <span>{{ $rate->avg('rating') ? number_format($rate->avg('rating'), 1) . ' ⭐' : 'Chưa có đánh giá' }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="info-item d-flex align-items-start">
                        <strong class="d-block mb-1" style="min-width: 120px;">Introduce:</strong>
                        <p class="text-muted ">{{ $lawyer->bio ?? 'No introductory information is available' }}
                        </p>
                    </div>
                </div>
            </div>
            <a href="{{ route('lawyer.edit') }}" class="btn btn-primary mt-3">Update</a>
        </div>
    </div>
    <div class="schedule-card">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4 text-dark" style="font-weight: 700; margin-left: 25px; margin-top:20px;">
                    Đánh giá từ khách hàng
                </h4>

                @if ($rate->isEmpty())
                    <p class="text-muted ms-2" style=" margin-left: 25px;">Chưa có bình luận nào cho luật sư này.</p>
                @else
                    <div class="review-list" style="margin-left: 25px; margin-right: 25px;">
                        @foreach ($rate as $r)
                            <div class="card border-0 shadow-sm mb-3 text-start"
                                style="border-radius: 12px; background-color: #ffffff; border: 1px solid #eef2f7 !important;">
                                <div class="card-body p-4">
                                    <h6 class="text-primary fw-bold mb-2">Comment for Appointment</h6>

                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                            style="width: 35px; height: 35px;">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $r->user->name ?? 'Người dùng hệ thống' }}</span>

                                    </div>
                                    <p class="small">{{ $r->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="card-text text-secondary mb-3" style="line-height: 1.6;">
                                        "{{ $r->comment ?? 'Luật sư tư vấn rất nhiệt tình và chuyên nghiệp.' }}"
                                    </p>

                                    <div class="d-flex align-items-start">
                                        <span class="badge badge-warning text-dark px-3 py-2"
                                            style="background-color: #fff4de; border-radius: 8px;">
                                            Rating: {{ $r->rating }} <span class="ms-1">⭐</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>


    <style>
        /* Tổng thể bảng màu xanh dương nhạt và đổ bóng */
        .schedule-card {
            background-color: #f0f7ff;
            /* Xanh dương cực nhạt, dịu mắt */
            border: 1px solid #d1e3ff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 97, 255, 0.08);
            /* Đổ bóng xanh nhẹ */
            max-width: 900px;
            margin: 20px auto;
            overflow: hidden;
        }

        .schedule-comment {
            background-color: #4474ab;
            /* Xanh dương cực nhạt, dịu mắt */
            border: 1px solid #d1e3ff;
            border-radius: 16px;
            /* box-shadow: 0 10px 30px rgba(0, 97, 255, 0.08); */
            /* Đổ bóng xanh nhẹ */
            max-width: 400px;
            margin: 20px auto;
            overflow: hidden;
        }

        .glass-card {
            /* Xanh Mint nhạt như màu nước biển nông */
            background: rgba(230, 255, 250, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 15px 35px rgba(45, 200, 150, 0.1);
            /* Đổ bóng hơi xanh nhẹ */
        }

        /* Tiêu đề bảng */
        .card-header-custom {
            background-color: #e1eeff;
            padding: 15px 25px;
            color: #0061ff;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid #d1e3ff;
        }

        /* Nội dung bên trong */
        .card-body-custom {
            padding: 25px;
        }

        /* Style cho các mục TH bên trong */
        .th-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 5px solid #0061ff;
            /* Vạch xanh bên trái cho nổi bật */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }
    </style>
@endsection
