@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-5 mb-4">
                <h2 class="fw-bold text-navy mb-4">Liên hệ với chúng tôi</h2>
                <p class="text-muted">Bạn có câu hỏi hoặc cần hỗ trợ? Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ 24/7.</p>

                <div class="mt-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                        <p>123 Đường ABC, Quận 1, TP. Hồ Chí Minh</p>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fas fa-phone text-primary me-3 mt-1"></i>
                        <p>+84 123 456 789</p>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                        <p>contact@legalease.vn</p>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" placeholder="Nguyễn Văn A">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="email@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Chủ đề</label>
                            <select class="form-select">
                                <option>Tư vấn dân sự</option>
                                <option>Luật doanh nghiệp</option>
                                <option>Hôn nhân & Gia đình</option>
                                <option>Khác</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lời nhắn</label>
                            <textarea class="form-control" rows="5" placeholder="Hãy mô tả vấn đề của bạn..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 py-2">Gửi tin nhắn</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
