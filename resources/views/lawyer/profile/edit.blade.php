@extends('layouts.lawyer')
@section('main')
    <form action="{{ Route('lawyer.update') }}" method="post">
        @csrf
        @method('PUT')
        <div class="schedule-card">
            <div class="card-header-custom">
                <i class="fas fa-file-lines"></i>Hồ sơ cá nhân
            </div>

            <div class="card-body-custom">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center">
                            <strong class="me-2 text-nowrap">Họ và tên:</strong>
                            <input type="text" name="name" class="form-control"
                                value="{{ $lawyer->user->name ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center">
                            <strong class="me-2 text-nowrap">Kinh nghiệm:</strong>
                            <input type="text" name="experience_years" id="experience_years"
                                value="{{ $lawyer->experience_years ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center">
                            <div class="form-group">
                                <strong class="me-2 text-nowrap">Chuyên môn:</strong>
                                <!-- <select id="specializations" class="form-control" name="specializations">
                            @foreach ($allSpecializations as $a)
    <option value="{{ $a->id }}"
                                    {{ isset($lawyer) && $lawyer->specializations->contains($a->id) ? 'selected' : '' }}>
                                    {{ $a->name }}
                                </option>
    @endforeach
                        </select> -->
                                <select name="specializations[]" multiple class="form-control">
                                    @foreach ($allSpecializations as $a)
                                        <option value="{{ $a->id }}"
                                            {{ $lawyer->specializations->contains($a->id) ? 'selected' : '' }}>
                                            {{ $a->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="info-item d-flex align-items-center">
                            <strong class="me-2 text-nowrap">Địa chỉ:</strong>
                            <input type="text" name="location" id="location" value="{{ $lawyer->location ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="info-item bio-box">
                            <strong class="d-block mb-1">Giới thiệu:</strong>
                            <textarea name="bio" id="bio" rows="4" class="form-control custom-textarea">{{ $lawyer->bio ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                </div>

            </div>
    </form>




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

        /* Làm đẹp cho từng mục thông tin */
        /* Container bọc ngoài mỗi dòng */
        .info-item {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.6);
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            /* Khoảng cách giữa các hàng */
            width: 100%;
        }

        /* Ép các tiêu đề (strong) có độ rộng cố định để các ô Input thẳng hàng */
        .info-item strong {
            min-width: 100px;
            /* Chỉnh con số này nếu tên nhãn dài hơn */
            display: inline-block;
            color: #333;
        }

        /* Ép các ô Input và Textarea giãn đều ra hết cỡ */
        .info-item input,
        .info-item textarea {
            flex-grow: 1;
            /* Tự động dài ra lấp đầy khoảng trống */
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 7px 12px;
            background: white;
        }

        /* Riêng phần Giới thiệu là ô lớn, cho tiêu đề nằm trên nếu muốn, hoặc giữ Flex như trên */
        .bio-item {
            align-items: flex-start;
            /* Cho chữ Giới thiệu nằm ở góc trên bên trái */
            flex-direction: column;
            /* Cho ô nhập nằm xuống dưới chữ Giới thiệu cho rộng */
        }

        .bio-item strong {
            margin-bottom: 8px;
        }
    </style>
@endsection
