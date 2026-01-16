@extends('layouts.lawyer')
@section('main')
    <div class="schedule-card">
        <div class="card-header-custom">
            <i class="fas fa-file-lines"></i>Personal profile
        </div>

        <div class="card-body-custom">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center">
                        <strong class="me-2 text-nowrap">Fullname:</strong>
                        <span class="text-primary fw-bold">{{ $lawyer->user->name ?? '' }}</span>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center">
                        <strong class="me-2 text-nowrap">Experience:</strong>
                        <span>{{ $lawyer->experience_years ?? 'Not yet updated' }}</span>
                    </div>
                </div>

            </div>
            <div class="info-item d-flex align-items-start mb-3">
                <strong class="me-2 text-nowrap" style="min-width: 120px;">Specialization:</strong>
                <div class="d-flex flex-wrap gap-2">
                    @forelse ($lawyer->specializations as $spec)
                        <span class="badge"
                            style="
                background-color: #e3f2fd;
                color: #0d47a1;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 500;
                border: 1px solid #bbdefb;
            ">
                            {{ $spec->name }}
                        </span>
                    @empty
                        <span class="text-muted">Not yet updated</span>
                    @endforelse
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="info-item d-flex align-items-center">
                        <strong class="me-2 text-nowrap">Address:</strong>
                        <span>{{ $lawyer->location ?? 'Address not yet updated' }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="info-item">
                        <strong class="d-block mb-1">Introduce:</strong>
                        <p class="text-muted small mb-0">{{ $lawyer->bio ?? 'No introductory information is available' }}
                        </p>
                    </div>
                </div>
            </div>
            <a href="{{ route('lawyer.edit') }}" class="btn btn-primary mt-3">Update</a>
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
                max-width: 800px;
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
