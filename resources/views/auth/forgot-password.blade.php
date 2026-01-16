<div class="card p-4 shadow-lg border-0" style="max-width: 400px; margin: 100px auto;">
    <h3 class="text-center fw-bold">Quên mật khẩu?</h3>
    <p class="text-muted small text-center">Nhập email của bạn để tiếp tục</p>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email tài khoản</label>
            <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">GỬI YÊU CẦU</button>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none small">Quay lại Đăng nhập</a>
        </div>
    </form>
</div>
