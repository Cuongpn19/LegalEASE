<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegalEase</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .vh-100-custom {
            min-height: 100vh;
            background: linear-gradient(135deg, #0b1fd3 0%, #2c3e50 100%);
        }

        .login-card {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .login-img {
            border-radius: 1rem 0 0 1rem;
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .form-control:focus {
            border-color: #0b1fd3;
            box-shadow: 0 0 0 0.2rem rgba(11, 31, 211, 0.25);
        }

        .btn-login {
            background-color: #2c3e50;
            color: white;
            border: none;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: #1a252f;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <section class="vh-100-custom d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-xl-10">
                    <div class="card login-card">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://images.unsplash.com/photo-1505664194779-8beaceb93744?q=80&w=2070&auto=format&fit=crop"
                                    alt="login form" class="login-img" />
                            </div>

                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-scale-balanced fa-3x me-3" style="color: #0b1fd3;"></i>
                                            <span class="h1 fw-italic mb-0" style="color: #0b1fd3">LegalEase</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login to the
                                            system</h5>

                                        <div class="form-outline mb-4">
                                            <label class="form-label fw-bold" for="email">Email</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" required autofocus />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label fw-bold" for="password">Password</label>
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                required autocomplete="current-password" />
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label text-muted small" for="remember">
                                                Remember login
                                            </label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-login btn-lg w-100 py-2"
                                                type="submit">LOGIN</button>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            {{-- <a class="small text-muted text-decoration-none"
                                                href="{{ route('password.request') }}">Quên mật
                                                khẩu?</a> --}}
                                            <p class="small text-muted mb-0">Don't have an account yet?
                                                <a href="{{ route('register') }}"
                                                    class="fw-bold text-primary text-decoration-none">Register</a>
                                            </p>
                                        </div>

                                        <hr class="my-4">
                                        <div class="d-flex justify-content-center small text-muted">
                                            <a href="#!" class="me-3 text-muted text-decoration-none">Privacy
                                                Policy</a>
                                            <a href="#!" class="text-muted text-decoration-none">Terms and
                                                Conditions</a>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
